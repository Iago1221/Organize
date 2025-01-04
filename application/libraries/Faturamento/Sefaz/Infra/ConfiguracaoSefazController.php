<?php

namespace Libraries\Faturamento\Sefaz\Infra;

use src\Framework\Base\Controller;
use Libraries\Faturamento\Entidade\App\EntidadeApp;
use Libraries\Faturamento\Entidade\Infra\MemoriaEntidadeRepository;
use Libraries\Faturamento\Sefaz\App\ConfiguracaoSefazApp;
use Libraries\Faturamento\Sefaz\App\ConfiguracaoSefazDto;

class ConfiguracaoSefazController extends Controller
{
    private $app;

    public function __construct()
    {
        $this->app = new ConfiguracaoSefazApp(new MemoriaConfiguracaoSefazRepository(), new EntidadeApp(new MemoriaEntidadeRepository()));
    }

    /** @return ConfiguracaoSefazApp */
    protected function getApp()
    {
        return $this->app;
    }

    public function incluir()
    {
        if ($this->getApp()->buscar()) {
            $this->atualizar(null);
            return;
        }

        parent::incluir();
    }

    protected function montaDto($dados)
    {
        return new ConfiguracaoSefazDto(
            $dados->tipoAmbiente,
            $dados->entidade
        );
    }

    protected function validaDados($dados)
    {
        foreach ($dados as $key => $dado) {
            if ($key != 'tipoAmbiente' || $key != 'entidade') {
                throw new \InvalidArgumentException('Dados inválidos!');
            }
        }
    }
}
