<?php

namespace Libraries\Faturamento\Sefaz\Dominio;

use Libraries\Faturamento\Entidade\Dominio\Entidade;

/**
 * @author Iago Oliveira <prog.iago.oliveira@gmail.com>
 * @since 03/11/2024
 */
class ConfiguracaoSefaz
{
    private $dataAtualizacao;
    private $tipoAmbiente;
    private Entidade $entidade;
    private $schema = 'PL_009_V4';
    private $versao = '4.00';

    /** @return \DateTime */
    public function getDataAtualizcao()
    {
        return $this->dataAtualizacao;
    }

    /**
     * @param \DateTime $dataAtualizacao
     * @return self
     */
    public function setDataAtualizacao(\DateTime $dataAtualizacao)
    {
        $this->dataAtualizacao = $dataAtualizacao;
        return $this;
    }

    /** @return int */
    public function getTipoAmbiente()
    {
        return $this->tipoAmbiente;
    }

    /**
     * @param int $tipoAmbiente
     * @return self
     */
    public function setTipoAmbiente($tipoAmbiente)
    {
        $this->tipoAmbiente = $tipoAmbiente;
        return $this;
    }

    /** @return Entidade */
    public function getEntidade()
    {
        return $this->entidade;
    }

    /**
     * @param Entidade $entidade
     * @return self
     */
    public function setEntidade($entidade)
    {
        $this->entidade = $entidade;
        return $this;
    }

    public function getVersao()
    {
        return $this->versao;
    }

    /** @return string */
    public function toJsonForTools()
    {
        $config =  [
            "atualizacao" => date_format($this->getDataAtualizcao(), 'Y-m-d H:i:s'),
            "tpAmb" => $this->getTipoAmbiente(),
            "razaosocial" => $this->getEntidade()->getRazaoSocial(),
            "cnpj" => $this->getEntidade()->getCnpj(),
            "siglaUF" => $this->getEntidade()->getEndereco()->getUf(),
            "schemes" => $this->schema,
            "versao" => $this->versao,
        ];
        return json_encode($config);
    }
}
