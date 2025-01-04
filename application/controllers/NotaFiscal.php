<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class NotaFiscal extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->helper('form');
        $this->load->model('notaFiscal_model');
        $this->data['menuNotaFiscal'] = 'Nota Fiscal';
    }

    public function index()
    {
        $this->gerenciar();
    }

    public function adicionar()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'aVenda')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para adicionar Vendas.');
            redirect(base_url());
        }

        $data = [
            'numero' => $this->input->post('numero'),
            'serie' =>  $this->input->post('serie'),
            'venda' =>  $this->input->post('venda'),
            'situacao' => 1
        ];

        $result = (object) $data;

        if (is_numeric($id = $this->notaFiscal_model->add('nota_fiscal', $data, true))) {
            $this->session->set_flashdata('success', 'nota fiscal incluida com sucesso.');
            log_info('Adicionou uma nota fiscal.');
            redirect(base_url() . 'notaFiscal/visualizar/' . $id);
        } else {
            $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
        }

        $this->data['result'] = $result;
        $this->data['view'] = 'notaFiscal/adicionarNotaFiscal';
        return $this->layout();
    }

    public function gerenciar($start = true)
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'vProduto')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para visualizar notas fiscais.');
            redirect(base_url());
        }

        $this->load->library('pagination');

        $this->data['configuration']['base_url'] = site_url('notaFiscal/gerenciar/');
        $this->data['configuration']['total_rows'] = $this->notaFiscal_model->count('nota_fiscal');

        $this->pagination->initialize($this->data['configuration']);

        $registroInicio = $start ? $this->uri->segment(3) : null;
        $this->data['results'] = $this->notaFiscal_model->get('', $this->data['configuration']['per_page'], $registroInicio);

        $this->data['view'] = 'notaFiscal/notaFiscal';
        return $this->layout();
    }

    public function visualizar()
    {
        if (!$this->uri->segment(3) || !is_numeric($this->uri->segment(3))) {
            $this->session->set_flashdata('error', 'Item não pode ser encontrado, parâmetro não foi passado corretamente.');
            redirect('Organize');
        }

        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'vProduto')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para visualizar nota fiscal.');
            redirect(base_url());
        }

        $this->data['result'] = $this->notaFiscal_model->getById($this->uri->segment(3));

        $this->data['view'] = 'notaFiscal/visualizarNotaFiscal';
        return $this->layout();
    }

    public function imprimirDanfe()
    {
        $notaFiscal = $this->notaFiscal_model->getById($this->uri->segment(3));
        
        if (!in_array($notaFiscal->situacao, [2])) {
            $this->session->set_flashdata('error', 'A nota fiscal precisa estar autorizada para imprimir a DANFE.');
            redirect(('notaFiscal/gerenciar/'));
        }

        $pdfDanfe = FCPATH . "application\\files\\pdf\\notaFiscal\\$notaFiscal->chave.pdf";
        $xml = file_get_contents($notaFiscal->xml_path);
        $danfe = new NFePHP\DA\NFe\DanfeEtiqueta($xml);
        $pdf = $danfe->render();

        @file_put_contents($pdfDanfe, $pdf);
        @chmod($filename, 0777);
    }

    public function cancelar() 
    {
        $notaFiscal = $this->notaFiscal_model->getById($_POST['numeroNotaFiscal']);
        
        if ($notaFiscal->situacao != 2) {
            $this->session->set_flashdata('error', 'A nota fiscal precisa estar autorizada para ser cancelada.');
            redirect(('notaFiscal/gerenciar/'));
        }

        $justificativa = $_POST['justificativa'];

        try {
            $tools = $this->getTools();
            $tools->sefazCancela($notaFiscal->chave, $justificativa, $notaFiscal->protocolo);
            $this->notaFiscal_model->edit('nota_fiscal', ['situacao' => 4], 'numero', $notaFiscal->nfid);
        } catch (Exception $e) {
            $this->session->set_flashdata('error', 'Ocorreu um errro ao cancelar a nota fiscal.');
        }

        return $this->gerenciar();
    }

    public function inutilizar()
    {
        $notaFiscal = $this->notaFiscal_model->getById($_POST['numeroNotaFiscal']);
        $justificativa = $_POST['justificativa'];

        try {
            $tools = $this->getTools();
            $tools->sefazInutiliza($notaFiscal->serie, $notaFiscal->numeroNotaFiscal, $notaFiscal->numeroNotaFiscal, $justificativa);

            $this->notaFiscal_model->edit('nota_fiscal', ['situacao' => 5], 'numero', $notaFiscal->nfid);
        } catch (Exception $e) {
            $this->session->set_flashdata('error', 'Ocorreu um errro ao inutilizar a nota fiscal.');
        }

        return $this->gerenciar();
    }

    public function autorizar()
    {
        $tools = $this->getTools();

        if (!$tools) {
            return;
        }

        try {
            $nota = $this->notaFiscal_model->getById($this->uri->segment(3));

            if ($nota->situacao != 1) {
                $this->session->set_flashdata('error', 'A nota fiscal precisa estar digitada para ser autorizada.');
            redirect(('notaFiscal/gerenciar/'));
            }

            $emitente = $this->getDadosEmitente();
            $sefaz = $this->getDadosSefaz();
            $ano = date('y');
            $mes = date('m');
            $randoInt = random_int('8000000', '9000000');
            $chave = $this->gerarChaveAcesso($sefaz->uf, $ano, $mes, $emitente->cnpj, 55, $nota->serieNotaFiscal, $nota->numeroNotaFiscal, $randoInt);
            
            $xmlEnvio = $tools->signNFe($this->montaXml($nota, $chave));
            $idLote = str_pad($nota->nfid, 15, '0', STR_PAD_LEFT);
            $recibo = $tools->sefazEnviaLote([$xmlEnvio], $idLote);
            $st = new \NFePHP\NFe\Common\Standardize();
            $dados = $st->toStd($recibo);

            $this->insereEnvioAutorizacao($nota->nfid, $dados);

            if ($dados->cStat == 103) {
                $xml_path = $this->guardaXml($chave, $xmlEnvio);
                $this->notaFiscal_model->edit('nota_fiscal', ['situacao' => 6, 'recibo' => $dados->infRec->nRec, 'chave' => $chave, 'xml_path' => $xml_path], 'numero', $nota->nfid);
            }
        } catch (Exception $e) {
            die(var_dump($e));
            $this->notaFiscal_model->edit('nota_fiscal', ['situacao' => 5], 'numero', $nota->nfid);
        }

        return $this->gerenciar(false);
    }

    public function montaXml($nota, $chave)
    {
        $emitente = $this->getDadosEmitente();
        $sefaz = $this->getDadosSefaz();

        $nfe = new \NFePHP\NFe\Make();
        $this->montaDadosGeraisXml($nfe, $nota, $sefaz, $emitente, $chave);
        $this->montaEmitenteXml($nfe, $emitente);
        $this->montaDestinatarioXml($nfe, $nota);
        $this->montaProdutosXml($nfe, $nota);
        $this->montaImpostosXml($nfe, $nota);
        $this->montaTransporteXml($nfe);
        $this->montaResponsavelTecnicoXml($nfe);

        return $nfe->getXML();
    }

    /** @param \NFePHP\NFe\Make $nfe */
    private function montaDadosGeraisXml(&$nfe, $nota, $sefaz, $emitente, $chave)
    {
        $std = new \stdClass();
        $std->versao = '4.00';
        $nfe->taginfNFe($std);

        $std = new \stdClass();
        $std->vTroco = '0';
        $nfe->tagpag($std);

        $std = new \stdClass();
        $std->indPag = '0';
        $std->tPag = '01';
        $std->vPag = '00';
        $std->dPag = $nota->dataVenda;
        $nfe->tagdetPag($std);

        $dataEmissao = date('Y-m-d\TH:i:sP');
        $std = new \stdClass();
        $std->cUF = $sefaz->uf;
        $std->cNF = substr($chave, -8);
        $std->natOp = 'VENDA';
        $std->indPag = 0;
        $std->mod = 55;
        $std->serie = $nota->serie;
        $std->nNF = $nota->nfid;
        $std->dhEmi = $dataEmissao;
        $std->dhSaiEnt =$dataEmissao;
        $std->tpNF = 1;
        $std->idDest = 1;
        $std->cMunFG = $emitente->ibge;
        $std->tpImp = 1;
        $std->tpEmis = 1;
        $std->cDV = 2;
        $std->tpAmb = $sefaz->ambiente;
        $std->finNFe = 1;
        $std->indFinal = 0;
        $std->indPres = 0;
        $std->procEmi = '3';
        $std->verProc = 1;
        $nfe->tagide($std);
    }

    /** @param \NFePHP\NFe\Make $nfe */
    private function montaEmitenteXml(&$nfe, $emitente)
    {
        $std = new \stdClass();
        $std->xNome = $emitente->nome;
        $std->IE = $emitente->ie;
        $std->CRT = 3;
        $std->CNPJ = $emitente->cnpj;
        $nfe->tagemit($std);

        $std = new \stdClass();
        $std->xLgr = $emitente->rua;
        $std->nro = $emitente->numero;
        $std->xBairro = $emitente->bairro;
        $std->cMun = $emitente->ibge;
        $std->xMun = $emitente->cidade;
        $std->UF = $emitente->uf;
        $std->CEP = preg_replace('/[.\-\/]/', '', $emitente->cep);
        $std->cPais = '1058';
        $std->xPais = 'BRASIL';
        $nfe->tagenderEmit($std);
    }

    /** @param \NFePHP\NFe\Make $nfe */
    private function montaDestinatarioXml(&$nfe, $nota)
    {
        $std = new \stdClass();
        $std->xNome = $nota->nomeCliente;
        $std->indIEDest = 1;

        if ($nota->pessoa_fisica != 1) {
            //$std->IE =  $destinatario->getInscricaoEstadual();
            $std->CNPJ = $nota->documento;
        } else {
            $std->CPF =$nota->documento;
        }

        $nfe->tagdest($std);

        $std = new \stdClass();
        $std->xLgr = $nota->rua;
        $std->nro = $nota->numero;
        $std->xBairro = $nota->bairro;
        $std->cMun = $nota->cliente_ibge;
        $std->xMun = $nota->cidade;
        $std->UF = $nota->estado;
        $std->CEP = preg_replace('/[.\-\/]/', '', $nota->cep);
        $std->cPais = '1058';
        $std->xPais = 'BRASIL';
        $nfe->tagenderDest($std);
    }

    /** @param \NFePHP\NFe\Make $nfe */
    private function montaProdutosXml(&$nfe, $nota)
    {
        $itens = $this->notaFiscal_model->getItens($nota->idVendas);
        $i = 0;
        foreach ($itens as $item) {
            $i++;
            $std = new \stdClass();
            $std->item = $i;
            $std->cProd = $item->produtos_id;
            $std->cEAN = $item->produto_ean;
            $std->cEANTrib = $item->produto_ean;
            $std->xProd = $item->descricao;
            $std->NCM = $item->ncm;
            $std->CFOP = $item->cfop;
            $std->uCom = $item->unidade;
            $std->qCom = $item->quantidade;
            $std->vUnCom = $item->preco;
            $std->vProd = $item->preco;
            $std->uTrib = $item->unidade;
            $std->qTrib = $item->quantidade;
            $std->vUnTrib = $item->preco;
            $std->indTot = 1;
            $nfe->tagprod($std);
    
            $std = new \stdClass();
            $std->item = 1;
            $std->vTotTrib = $item->preco;
            $nfe->tagimposto($std);
    
            $std = new \stdClass();
            $std->item = 1;
            $std->orig = 0;
            $std->CST = '00';
            $std->modBC = 0;
            $std->vBC = 0.00;
            $std->pICMS = '00.0000';
            $std->vICMS ='0.00';
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
    }

    /** @param \NFePHP\NFe\Make $nfe */
    private function montaImpostosXml(&$nfe, $nota)
    {
        $std = new \stdClass();
        $std->vBC = 0.00;
        $std->vICMS = 0.00;
        $std->vICMSDeson = 0.00;
        $std->vBCST = 0.00;
        $std->vST = 0.00;
        $std->vProd = $nota->valorTotal;
        $std->vFrete = 0.00;
        $std->vSeg = 0.00;
        $std->vDesc = 0.00;
        $std->vII = 0.00;
        $std->vIPI = 0.00;
        $std->vPIS = 0.00;
        $std->vCOFINS = 0.00;
        $std->vOutro = 0.00;
        $std->vNF = $nota->valorTotal;
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

    public function consultarAutorizacao()
    {
        $notaFiscal = $this->notaFiscal_model->getById($this->uri->segment(3));

        if ($notaFiscal->situacao != 6) {
            $this->session->set_flashdata('error', 'A nota fiscal precisa estar enviada para consultar o envio.');
            redirect(('notaFiscal/gerenciar/'));
        }

        $tools = $this->getTools();
        $response = $tools->sefazConsultaRecibo($notaFiscal->recibo);
        $st = new \NFePHP\NFe\Common\Standardize();
        $std = $st->toStd($response);

        if ($std->cStat != 103) {
            $this->notaFiscal_model->edit('nota_fiscal', ['situacao' => 3, 'protocolo' => $std->nPro], 'numero', $notaFiscal->nfid);
            $this->insereConsultaAutorizacao($notaFiscal->nfid, $std);
            return $this->gerenciar(false);
        }

        $this->notaFiscal_model->edit('nota_fiscal', ['situacao' => 2], 'numero', $notaFiscal->nfid);
        $this->insereConsultaAutorizacao($notaFiscal->nfid, $std);
        return $this->gerenciar(false);
    }

    private function guardaXml($chave, $xml)
    {
        $path = FCPATH . "application\\files\xml\\notaFiscal\\$chave.xml";
        file_put_contents($path, $xml);
        return $path;
    }

    private function insereEnvioAutorizacao($numero, $dados)
    {
        $envio = [
            'numero' => $numero,
            'codigo_retorno' => $dados->cStat,
        ];

        if ($dados->cStat != 103) {
            $envio['motivo'] = $dados->xMotivo;
        } else {
            $envio['recibo'] = $dados->infRec->nRec;
        }

        $this->notaFiscal_model->add('nota_fiscal_envio', $envio);
    }

    private function insereConsultaAutorizacao($numero, $dados)
    {
        $envio = [
            'numero' => $numero,
            'codigo_retorno' => $dados->cStat,
        ];

        if ($dados->cStat != 103) {
            $envio['motivo'] = $dados->xMotivo;
        }

        $this->notaFiscal_model->add('nota_fiscal_envio', $envio);
    }

    private function getTools()
    {
        $emitente = $this->getDadosEmitente();

        if (!$emitente) {
            return;
        }

        $sefaz = $this->getDadosSefaz();

        $config =  [
            "atualizacao" => date_format($sefaz->data_alteracao, 'Y-m-d H:i:s'),
            "tpAmb" => intval($sefaz->ambiente),
            "razaosocial" => $emitente->nome,
            "cnpj" => $emitente->cnpj,
            "siglaUF" => $this->getSiglaUf(intval($sefaz->uf)),
            "schemes" => 'PL_009_V4',
            "versao" => '4.00',
        ];

        $certificado = \NFePHP\Common\Certificate::readPfx(file_get_contents($emitente->path_certificado), $emitente->senha_certificado);

        return new \NFePHP\NFe\Tools(json_encode($config), $certificado);
    }

    public function getDadosEmitente()
    {
        $this->load->model('organize_model');
        $emitente = $this->organize_model->getEmitente();
        $emitente->cnpj = preg_replace('/[.\-\/]/', '', $emitente->cnpj);
        return $emitente;
    }

    public function getDadosSefaz()
    {
        return $this->organize_model->getSefaz();
    }

    public function getSiglaUf($uf)
    {
        switch ($uf) {
            case 11: return 'RO';
            case 12: return 'AC';
            case 13: return 'AM';
            case 14: return 'RR';
            case 15: return 'PA';
            case 16: return 'AP';
            case 17: return 'TO';
            case 21: return 'MA';
            case 22: return 'PI';
            case 23: return 'CE';
            case 24: return 'RN';
            case 25: return 'PB';
            case 26: return 'PE';
            case 27: return 'AL';
            case 28: return 'SE';
            case 29: return 'BA';
            case 31: return 'MG';
            case 32: return 'ES';
            case 33: return 'RJ';
            case 35: return 'SP';
            case 41: return 'PR';
            case 42: return 'SC';
            case 43: return 'RS';
            case 50: return 'MS';
            case 51: return 'MT';
            case 52: return 'GO';
            case 53: return 'DF';
            default: return 'SC';
        }
    }

    public function calcularDV($chave) {
        $peso = [4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
        $soma = 0;
        for ($i = 0; $i < strlen($chave); $i++) {
            $soma += $chave[$i] * $peso[$i % count($peso)];
        }
        $resto = $soma % 11;
        return ($resto == 0 || $resto == 1) ? 0 : (11 - $resto);
    }
    
    public function gerarChaveAcesso($uf, $ano, $mes, $cnpj, $modelo, $serie, $numero, $codigoNumerico) {
        $chaveSemDV = sprintf(
            "%02d%04d%s%02d%02d%09d%08d",
            $uf,
            $ano * 100 + $mes,
            $cnpj,
            $modelo,
            $serie,
            $numero,
            $codigoNumerico
        );
        $dv = $this->calcularDV($chaveSemDV);
        return $chaveSemDV . $dv;
    }
    
}
