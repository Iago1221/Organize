<?php

namespace Libraries\Faturamento\Sefaz\App;

use Libraries\Faturamento\Entidade\App\EntidadeApp;
use Libraries\Faturamento\Sefaz\Dominio\ConfiguracaoSefaz;
use Libraries\Faturamento\Sefaz\Dominio\ConfiguracaoSefazRepository;
use Libraries\Public\UtilsPersistencia;

/**
 * @author Iago Oliveira <prog.iago.oliveira@gmail.com>
 * @since 03/11/2024
 */
class ConfiguracaoSefazApp
{
    private $repository;
    private $entidadeApp;

    public function __construct(ConfiguracaoSefazRepository $repository, EntidadeApp $entidadeApp)
    {
        $this->repository = $repository;
        $this->entidadeApp = $entidadeApp;
    }

    /** @return ConfiguracaoSefaz */
    public function buscar()
    {
        return $this->instancia($this->repository->buscar());
    }

    /**
     * @param ConfiguracaoSefazDto $dto
     * @return void
     */
    public function incluir($dto)
    {
        $this->repository->incluir($this->instancia($dto));
    }

    /**
     * @param ConfiguracaoSefazDto $dto
     * @param ConfiguracaoSefaz $configuracao
     * @return void
     */
    public function atualizar($dto, ConfiguracaoSefaz $configuracao)
    {
        $dto->entidade = $this->entidadeApp->buscar($dto->entidade);
        UtilsPersistencia::alterar($dto, $configuracao);
        $this->repository->atualizar($configuracao);
    }

    /**
     * @param ConfiguracaoSefazDto $dto
     * @return ConfiguracaoSefaz
     */
    private function instancia($dto)
    {
        return (new ConfiguracaoSefaz())->setDataAtualizacao($dto->dataAtualizacao)
            ->setTipoAmbiente($dto->tipoAmbiente)
            ->setEntidade($this->entidadeApp->buscar($dto->entidade));
    }
}
