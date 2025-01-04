<?php

namespace Libraries\Faturamento\Entidade\Dominio;

use Libraries\Faturamento\Entidade\App\EntidadeDto;

/**
 * @author Iago Oliveira <prog.iago.oliveira@gmail.com>
 * @since 03/11/2024
 */
interface EntidadeRepository
{
    /** @return EntidadeDto */
    function buscar($codigo);
    function incluir(Entidade $entidade);
    function atualizar(Entidade $entidade);
    function excluir($codigo);
}
