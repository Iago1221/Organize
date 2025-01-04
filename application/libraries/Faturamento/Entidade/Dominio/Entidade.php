<?php

namespace Libraries\Faturamento\Entidade\Dominio;

use Libraries\Public\Endereco;

/**
 * @author Iago Oliveira <prog.iago.oliveira@gmail.com>
 * @since 03/11/2024
 */
class Entidade
{
    private $codigo;
    private $razaoSocial;
    private $nomeFantasia;
    private $cnpj;
    private $inscricaoEstadual;
    private $inscricaoMunicipal;
    private EntidadeContato $contato;
    private Endereco $endereco;
    private $cnae;
    private $regimeTributario;

    /** @return int */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * @param int $codigo
     * @return self
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
        return $this;
    }

    /** @return string */
    public function getRazaoSocial()
    {
        return $this->razaoSocial;
    }

    /**
     * @param string $razaoSocial
     * @return self
     */
    public function setRazaoSocial($razaoSocial)
    {
        $this->razaoSocial = $razaoSocial;
        return $this;
    }

    /** @return string */
    public function getNomeFantasia()
    {
        return $this->nomeFantasia;
    }

    /**
     * @param string $nomeFantasia
     * @return self
     */
    public function setNomeFantasia($nomeFantasia)
    {
        $this->nomeFantasia = $nomeFantasia;
        return $this;
    }

    /** @return string */
    public function getCnpj()
    {
        return $this->cnpj;
    }

    /**
     * @param string $cnpj
     * @return self
     */
    public function setCnpj($cnpj)
    {
        $this->cnpj = $cnpj;
        return $this;
    }

    /** @return string */
    public function getInscricaoEstadual()
    {
        return $this->inscricaoEstadual;
    }

    /**
     * @param string $inscricaoEstadual
     * @return self
     */
    public function setInscricaoEstadual($inscricaoEstadual)
    {
        $this->inscricaoEstadual = $inscricaoEstadual;
        return $this;
    }

    /** @return string */
    public function getInscricaoMunicipal()
    {
        return $this->inscricaoMunicipal;
    }

    /**
     * @param string $inscricaoMunicipal
     * @return self
     */
    public function setInscricaoMunicipal($inscricaoMunicipal)
    {
        $this->inscricaoMunicipal = $inscricaoMunicipal;
        return $this;
    }

    /** @return EntidadeContato */
    public function getContato()
    {
        return $this->contato;
    }

    /**
     * @param EntidadeContato $contato
     * @return self
     */
    public function setContato(EntidadeContato $contato)
    {
        $this->contato = $contato;
        return $this;
    }

    /** @return Endereco */
    public function getEndereco()
    {
        return $this->endereco;
    }

    /**
     * @param Endereco $endereco
     * @return self
     */
    public function setEndereco(Endereco $endereco)
    {
        $this->endereco = $endereco;
        return $this;
    }

    /** @return string */
    public function getCnae()
    {
        return $this->cnae;
    }

    /**
     * @param string $cnae
     * @return self
     */
    public function setCnae($cnae)
    {
        $this->cnae = $cnae;
        return $this;
    }

    /** @return mixed */
    public function getRegimeTributario()
    {
        return $this->regimeTributario;
    }

    /**
     * @param mixed $regimeTributario
     * @return self
     */
    public function setRegimeTributario($regimeTributario)
    {
        $this->regimeTributario = $regimeTributario;
        return $this;
    }
}
