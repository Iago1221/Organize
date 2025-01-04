<?php

namespace Libraries\Faturamento\Sefaz\App;

use Libraries\Faturamento\NotaFiscal\Dominio\NotaFiscal;
use Libraries\Faturamento\Sefaz\Dominio\ConfiguracaoSefaz;

/**
 * @author Iago Oliveira <prog.iago.oliveira@gmail.com>
 * @since 03/11/2024
 */
class SefazApp
{
    private $tools;
    private ConfiguracaoSefaz $configuracaoSefaz;

    private NotaFiscal $notaFiscal;

    public function __construct($configuracaoSefaz, $certificadoDigital)
    {
        $this->configuracaoSefaz = $configuracaoSefaz;
        $this->tools = new \NFePHP\NFe\Tools($configuracaoSefaz->toJsonForTools(), \NFePHP\Common\Certificate::readPfx($certificadoDigital->getContent(), $certificadoDigital->getPassword()));
    }

    public function setNotaFiscal(NotaFiscal $notaFiscal)
    {
        $this->notaFiscal = $notaFiscal;
    }

    public function autorizacao()
    {
        $xmlEnvio = $this->tools->signNFe($this->montaXml());
        $idLote = str_pad(100, 15, '0', STR_PAD_LEFT); // Identificador do lote
        $recibo = $this->tools->sefazEnviaLote([$xmlEnvio], $idLote);

        $st = new \NFePHP\NFe\Common\Standardize();
        return [$st->toStd($recibo), $xmlEnvio];
    }

    private function montaXml()
    {
        $nfe = new \NFePHP\NFe\Make();
        $this->montaDadosGeraisXml($nfe);
        $this->montaEmitenteXml($nfe);
        $this->montaDestinatarioXml($nfe);
        $this->montaProdutosXml($nfe);
        $this->montaImpostosXml($nfe);
        $this->montaTransporteXml($nfe);
        $this->montaResponsavelTecnicoXml($nfe);

        return $nfe->getXML();
    }

    /** @param \NFePHP\NFe\Make $nfe */
    private function montaDadosGeraisXml(&$nfe)
    {
        $std = new \stdClass();
        $std->versao = $this->configuracaoSefaz->getVersao();
        $nfe->taginfNFe($std);

        $std = new \stdClass();
        $std->vTroco = '0';
        $nfe->tagpag($std);

        $std = new \stdClass();
        $std->indPag = '0';
        $std->tPag = '01';
        $std->vPag = '00';
        $std->dPag = date_format($this->notaFiscal->getPedido()->getData(),'Y-m-d');
        $nfe->tagdetPag($std);

        $std = new \stdClass();
        $std->cUF = 42; //$this->notaFiscal->getRemetente()->getEndereco()->getUf();
        $std->cNF = '80070008';
        $std->natOp = 'VENDA';
        $std->indPag = 0;
        $std->mod = 55;
        $std->serie = 1;
        $std->nNF = 2;
        $std->dhEmi = '2024-11-16T20:48:00-02:00';
        $std->dhSaiEnt = '2024-11-16T20:48:00-02:00';
        $std->tpNF = 1;
        $std->idDest = 1;
        $std->cMunFG = $this->configuracaoSefaz->getEntidade()->getEndereco()->getIbge();
        $std->tpImp = 1;
        $std->tpEmis = 1;
        $std->cDV = 2;
        $std->tpAmb = $this->configuracaoSefaz->getTipoAmbiente(); // Se deixar o tpAmb como 2 você emitirá a nota em ambiente de homologação(teste) e as notas fiscais aqui não tem valor fiscal
        $std->finNFe = 1;
        $std->indFinal = 0;
        $std->indPres = 0;
        $std->procEmi = '3';
        $std->verProc = 1;
        $nfe->tagide($std);
    }

    /** @param \NFePHP\NFe\Make $nfe */
    private function montaEmitenteXml(&$nfe)
    {
        $emitente = $this->notaFiscal->getRemetente();
        $std = new \stdClass();
        $std->xNome = $emitente->getRazaoSocial();
        $std->IE = $emitente->getInscricaoEstadual();
        $std->CRT = 3;
        $std->CNPJ = $emitente->getCnpj();
        $nfe->tagemit($std);

        $std = new \stdClass();
        $std->xLgr = $emitente->getEndereco()->getLogradouro();
        $std->nro = $emitente->getEndereco()->getNumero();
        $std->xBairro = $emitente->getEndereco()->getBairro();
        $std->cMun = $emitente->getEndereco()->getIbge();
        $std->xMun = $emitente->getEndereco()->getCidade();
        $std->UF = $emitente->getEndereco()->getUf();
        $std->CEP = $emitente->getEndereco()->getCep();
        $std->cPais = '1058';
        $std->xPais = 'BRASIL';
        $nfe->tagenderEmit($std);
    }

    /** @param \NFePHP\NFe\Make $nfe */
    private function montaDestinatarioXml(&$nfe)
    {
        $destinatario = $this->notaFiscal->getPedido()->getDestinatario();
        $std = new \stdClass();
        $std->xNome = $destinatario->getNome();
        $std->indIEDest = 1;

        if ($destinatario->isPessoaJuridica()) {
            $std->IE =  $destinatario->getInscricaoEstadual();
            $std->CNPJ = $destinatario->getCnpj();
        } else {
            $std->CPF = $destinatario->getCpf();
        }

        $nfe->tagdest($std);

        $endereco = $destinatario->getEndereco();
        $std = new \stdClass();
        $std->xLgr = $endereco->getLogradouro();
        $std->nro = $endereco->getNumero();
        $std->xBairro = $endereco->getBairro();
        $std->cMun = $endereco->getIbge();
        $std->xMun = $endereco->getCidade();
        $std->UF = $endereco->getUf();
        $std->CEP =$endereco->getCep();
        $std->cPais = '1058';
        $std->xPais = 'BRASIL';
        $nfe->tagenderDest($std);
    }

    /** @param \NFePHP\NFe\Make $nfe */
    private function montaProdutosXml(&$nfe)
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->cProd = '0001';
        $std->cEAN = 'SEM GTIN';
        $std->cEANTrib = 'SEM GTIN';
        $std->xProd = "Produto teste";
        $std->NCM = '01029000';
        $std->CFOP = '5102';
        $std->uCom = 'PÇ';
        $std->qCom = '1.0000';
        $std->vUnCom = '10.99';
        $std->vProd = '10.99';
        $std->uTrib = 'PÇ';
        $std->qTrib = '1.0000';
        $std->vUnTrib = '10.99';
        $std->indTot = 1;
        $nfe->tagprod($std);

        $std = new \stdClass();
        $std->item = 1;
        $std->vTotTrib = 10.99;
        $nfe->tagimposto($std);

        $std = new \stdClass();
        $std->item = 1;
        $std->orig = 0;
        $std->CST = '00';
        $std->modBC = 0;
        $std->vBC = 0.20;
        $std->pICMS = '18.0000';
        $std->vICMS ='0.04';
        $nfe->tagICMS($std);

        $std = new \stdClass();
        $std->item = 1;
        $std->cEnq = '999';
        $std->CST = '50';
        $std->vIPI = 0;
        $std->vBC = 0;
        $std->pIPI = 0;
        $nfe->tagIPI($std);

        $std = new \stdClass();
        $std->item = 1;
        $std->CST = '07';
        $std->vBC = 0;
        $std->pPIS = 0;
        $std->vPIS = 0;
        $nfe->tagPIS($std);

        $std = new \stdClass();
        $std->item = 1;
        $std->CST = '02';
        $std->vCOFINS = 0;
        $std->vBC = 0;
        $std->pCOFINS = 0;
        $nfe->tagCOFINS($std);
    }

    /** @param \NFePHP\NFe\Make $nfe */
    private function montaImpostosXml(&$nfe)
    {
        $std = new \stdClass();
        $std->vBC = 0.00;
        $std->vICMS = 0.00;
        $std->vICMSDeson = 0.00;
        $std->vBCST = 0.00;
        $std->vST = 0.00;
        $std->vProd = 10.99;
        $std->vFrete = 0.00;
        $std->vSeg = 0.00;
        $std->vDesc = 0.00;
        $std->vII = 0.00;
        $std->vIPI = 0.00;
        $std->vPIS = 0.00;
        $std->vCOFINS = 0.00;
        $std->vOutro = 0.00;
        $std->vNF = 11.03;
        $std->vTotTrib = 0.00;
        $nfe->tagICMSTot($std);
    }

    /** @param \NFePHP\NFe\Make $nfe */
    private function montaTransporteXml(&$nfe)
    {
        $std = new \stdClass();
        $std->modFrete = 1;
        $nfe->tagtransp($std);
    }

    /** @param \NFePHP\NFe\Make $nfe */
    private function montaResponsavelTecnicoXml(&$nfe)
    {
        $std = new \stdClass();
        $std->CNPJ = '11859876000104';
        $std->xContato = 'Responsável Teste Contato';
        $std->email = 'teste@gmail.com';
        $std->fone = '4430379500';
        $nfe->taginfRespTec($std);
    }

    public function consultaProtocolo($chave)
    {
        return $this->tools->sefazConsultaChave($chave);
    }

    public function inutilizacao($serie, $numeroInicial, $numeroFinal, $justificativa)
    {
        return $this->tools->sefazInutiliza($serie, $numeroInicial, $numeroFinal, $justificativa);
    }

    public function cancela($chave, $jutificativa, $protocolo)
    {
        return $this->tools->sefazCancela($chave, $jutificativa, $protocolo);
    }

    public function retAutorizacao($recibo)
    {
        return $this->tools->sefazConsultaRecibo($recibo);
    }

    public function statusServico()
    {
        return $this->tools->sefazStatus();
    }
}
