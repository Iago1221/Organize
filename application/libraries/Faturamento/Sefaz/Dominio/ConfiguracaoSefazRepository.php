<?php

namespace Libraries\Faturamento\Sefaz\Dominio;

use Libraries\Faturamento\Sefaz\App\ConfiguracaoSefazDto;

/**
 * @author Iago Oliveira <prog.iago.oliveira@gmail.com>
 * @since 03/11/2024
 */
interface ConfiguracaoSefazRepository
{
    /** @return ConfiguracaoSefazDto */
    function buscar();
    function incluir(ConfiguracaoSefaz $configuracao);
    function atualizar(ConfiguracaoSefaz $configuracao);
}
