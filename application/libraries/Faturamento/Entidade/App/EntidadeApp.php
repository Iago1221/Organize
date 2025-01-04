<?php

namespace Libraries\Faturamento\Entidade\App;

use Libraries\Faturamento\Entidade\Dominio\Entidade;
use Libraries\Faturamento\Entidade\Dominio\EntidadeContato;
use Libraries\Faturamento\Entidade\Dominio\EntidadeRepository;
use Libraries\Public\UtilsInformacoes;
use Libraries\Public\UtilsPersistencia;

/**
 * @author Iago Oliveira <prog.iago.oliveira@gmail.com>
 * @since 03/11/2024
 */
class EntidadeApp
{
    /** @var EntidadeRepository */
    private $repository;

    public function __construct($repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param int $codigo
     * @return Entidade
     */
    public function buscar($codigo)
    {
        return $this->instanciaEntidade($this->repository->buscar($codigo));
    }

    /**
     * @param EntidadeDto $dto
     * @return void
     */
    public function incluir(EntidadeDto $dto)
    {
        $this->repository->incluir($this->instanciaEntidade($dto));
    }

    /**
     * @param EntidadeDto $dto
     * @param Entidade $entidade
     * @return void
     */
    public function atualizar(EntidadeDto $dto, Entidade $entidade)
    {
        /** @var Entidade $entidade */
        UtilsPersistencia::alterar($dto, $entidade);

        $contato = $entidade->getContato();
        $contatoNovo = (new EntidadeContato())->setFone($dto->fone ?? $contato->getFone())->setCelular($dto->celular ?? $contato->getCelular())->setEmail($dto->email ?? $contato->getEmail())->setEmailContabilidade($dto->emailContabilidade ?? $contato->getEmailContabilidade());
        $entidade->setContato($contatoNovo);

        $endereco = $entidade->getEndereco();
        $enderecoNovo = UtilsInformacoes::instanciaEndereco(
            $dto->cep ?? $endereco->getCep(),
            $dto->logradouro ?? $endereco->getLogradouro(),
            $dto->numero ?? $endereco->getNumero(),
            $dto->bairro ?? $endereco->getBairro(),
            $dto->complemento ?? $endereco->getComplemento(),
            $dto->uf ?? $endereco->getUf(),
            $dto->cidade ?? $endereco->getCidade(),
            $dto->ibge ?? $endereco->getIbge()
        );
        $entidade->setEndereco($enderecoNovo);

        $this->repository->atualizar($entidade);
    }

    /**
     * @param int $codigo
     * @return void
     */
    public function excluir($codigo)
    {
        $this->repository->excluir($codigo);
    }

    /**
     * @param EntidadeDto $dto
     * @return Entidade
     */
    private function instanciaEntidade($dto)
    {
        $entidade = new Entidade();

        $entidade->setCodigo($dto->codigo)
            ->setRazaoSocial($dto->razaoSocial)
            ->setNomeFantasia($dto->nomeFantasia)
            ->setCnpj($dto->cnpj)
            ->setInscricaoEstadual($dto->inscricaoEstadual)
            ->setInscricaoMunicipal($dto->inscricaoMunicipal)
            ->setContato((new EntidadeContato())->setFone($dto->fone)->setCelular($dto->celular)->setEmail($dto->email)->setEmailContabilidade($dto->emailContabilidade))
            ->setEndereco(UtilsInformacoes::instanciaEndereco($dto->cep, $dto->logradouro, $dto->numero, $dto->bairro, $dto->complemento, $dto->uf, $dto->cidade, $dto->ibge))
            ->setCnae($dto->cnae)
            ->setRegimeTributario($dto->regimeTributario);

        return $entidade;
    }
}
