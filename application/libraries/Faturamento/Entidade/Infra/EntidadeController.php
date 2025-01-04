<?php

namespace Libraries\Faturamento\Entidade\Infra;

use src\Framework\Base\Controller;
use Libraries\Faturamento\Entidade\App\EntidadeApp;
use Libraries\Faturamento\Entidade\App\EntidadeDto;

class EntidadeController extends Controller
{
    private $app;

    public function __construct()
    {
        $this->app = new EntidadeApp(new MemoriaEntidadeRepository());
    }

    /** @return EntidadeApp */
    protected function getApp()
    {
        return $this->app;
    }

    protected function montaDto($dados)
    {
        return new EntidadeDto(
            $dados,
            $dados,
            $dados,
            $dados,
            $dados,
            $dados,
            $dados,
            $dados,
            $dados,
            $dados,
            $dados,
            $dados,
            $dados,
            $dados,
            $dados,
            $dados,
            $dados,
            $dados,
            $dados,
            $dados
        );
    }

    protected function validaDados($dados)
    {
        if (!$dados) {
            throw new \InvalidArgumentException('Dados inválidos!');
        }
    }
}
