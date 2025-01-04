<?php

namespace Libraries\Faturamento\NotaFiscal\Dominio;

class Inutilizacao
{
    private array $notas;
    private string $justificativa;

    public function getNotas()
    {
        return $this->notas;
    }

    public function addNota($nota)
    {
        $this->notas = $nota;
    }

    public function getJustificativa()
    {
        return $this->justificativa;
    }

    public function setJustificativa($justificativa)
    {
        $this->justificativa = $justificativa;
    }
}
