<?php

namespace Libraries\Faturamento\NotaFiscal\Dominio;

use Libraries\Faturamento\Entidade\Dominio\Entidade;
use Libraries\Gerenciamento\Pedido\Dominio\Pedido;

class NotaFiscal
{
    CONST SITUACAO_DIGITADA = 1,
          SITUACAO_AUTORIZADA = 2,
          SITUACAO_REJEITADA = 3,
          SITUACAO_CANCELADA = 4,
          SITUACAO_INUTILIZADA = 5;

    private Pedido $pedido;
    private Entidade $rementente;
    private int $situacao;
    private string $numero;
    private string $recibo;
    private string $chave;
    private string $serie;
    private string $protocolo;

    public static function comPedidoERemetente($pedido, $rementete)
    {
        return new self($pedido, $rementete);
    }

    private function __construct($pedido, $rementente)
    {
        $this->pedido = $pedido;
        $this->rementente = $rementente;
    }

    public function getPedido()
    {
        return $this->pedido;
    }

    public function getRemetente()
    {
        return $this->rementente;
    }

    public function getRecibo()
    {
        return $this->recibo;
    }

    public function setRecibo($recibo)
    {
        $this->recibo = $recibo;
        return $this;
    }

    public function getNumero()
    {
        return $this->numero;
    }

    public function setNumero($numero)
    {
        $this->numero = $numero;
        return $this;
    }

    public function getSerie()
    {
        return $this->serie;
    }

    public function setSerie($serie)
    {
        $this->serie = $serie;
        return $this;
    }

    public function getChave()
    {
        return $this->chave;
    }

    public function setChave($chave)
    {
        $this->chave = $chave;
        return $this;
    }

    public function getProtocolo()
    {
        return $this->protocolo;
    }

    public function setProtocolo($protocolo)
    {
        $this->protocolo = $protocolo;
        return $this;
    }
}
