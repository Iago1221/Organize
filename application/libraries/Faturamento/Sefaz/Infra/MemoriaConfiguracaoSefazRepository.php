<?php

namespace Libraries\Faturamento\Sefaz\Infra;

use Libraries\Faturamento\Sefaz\App\ConfiguracaoSefazDto;
use Libraries\Faturamento\Sefaz\Dominio\ConfiguracaoSefaz;
use Libraries\Faturamento\Sefaz\Dominio\ConfiguracaoSefazRepository;

/**
 * @author Iago Oliveira <prog.iago.oliveira@gmail.com>
 * @since 03/11/2024
 */
class MemoriaConfiguracaoSefazRepository implements ConfiguracaoSefazRepository
{
    function buscar()
    {
        return new ConfiguracaoSefazDto(2, 1);
    }

    function incluir(ConfiguracaoSefaz $configuracao)
    {
        // TODO: Implement incluir() method.
    }

    function atualizar(ConfiguracaoSefaz $configuracao)
    {
        // TODO: Implement atualizar() method.
    }
}
