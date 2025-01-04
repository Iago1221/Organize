<?php

namespace Libraries\Faturamento\Sefaz\App;

/**
 * @author Iago Oliveira <prog.iago.oliveira@gmail.com>
 * @since 03/11/2024
 */
class ConfiguracaoSefazDto
{
    public $dataAtualizacao;
    public $tipoAmbiente;
    public $entidade;

    public function __construct($tipoAmbiente, $entidade)
    {
        $this->dataAtualizacao = new \DateTime();
        $this->tipoAmbiente = $tipoAmbiente;
        $this->entidade = $entidade;
    }
}
