<?php

namespace Libraries\Faturamento\Entidade\App;

/**
 * @author Iago Oliveira <prog.iago.oliveira@gmail.com>
 * @since 03/11/2024
 */
class EntidadeDto
{
    public $codigo;
    public $razaoSocial;
    public $nomeFantasia;
    public $cnpj;
    public $inscricaoEstadual;
    public $inscricaoMunicipal;
    public $fone;
    public $celular;
    public $email;
    public $emailContabilidade;
    public $cep;
    public $logradouro;
    public $numero;
    public $bairro;
    public $complemento;
    public $uf;
    public $cidade;
    public $ibge;
    public $cnae;
    public $regimeTributario;

    public function __construct($codigo, $razaoSocial, $nomeFantasia, $cnpj, $inscricaoEstadual, $inscricaoMunicipal, $fone, $celular, $email, $emailContabilidade, $cep, $logradouro, $numero, $bairro, $complemento, $uf, $cidade, $ibge, $cnae, $regimeTributario)
    {
        $this->codigo = $codigo;
        $this->razaoSocial = $razaoSocial;
        $this->nomeFantasia = $nomeFantasia;
        $this->cnpj = $cnpj;
        $this->inscricaoEstadual = $inscricaoEstadual;
        $this->inscricaoMunicipal = $inscricaoMunicipal;
        $this->fone = $fone;
        $this->celular = $celular;
        $this->email = $email;
        $this->emailContabilidade = $emailContabilidade;
        $this->cep = $cep;
        $this->logradouro = $logradouro;
        $this->numero = $numero;
        $this->bairro = $bairro;
        $this->complemento = $complemento;
        $this->uf = $uf;
        $this->cidade = $cidade;
        $this->ibge = $ibge;
        $this->cnae = $cnae;
        $this->regimeTributario = $regimeTributario;
    }
}