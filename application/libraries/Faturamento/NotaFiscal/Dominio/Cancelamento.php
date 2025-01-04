<?php

namespace Libraries\Faturamento\NotaFiscal\Dominio;

class Cancelamento
{
    private NotaFiscal $nota;
    private string $justificativa;

    public static function comNotaEJustificativa(NotaFiscal $nota, string $justificativa)
    {
        return new self($nota, $justificativa);
    }

    private function __construct($nota, $justificativa)
    {
        $this->nota = $nota;
        $this->justificativa = $justificativa;
    }

    public function getNota()
    {
        return $this->nota;
    }

    public function getJustificativa()
    {
        return $this->justificativa;
    }
}
