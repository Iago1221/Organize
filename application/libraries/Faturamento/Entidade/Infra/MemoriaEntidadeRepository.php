<?php

namespace Libraries\Faturamento\Entidade\Infra;

use Libraries\Faturamento\Entidade\App\EntidadeDto;
use Libraries\Faturamento\Entidade\Dominio\Entidade;
use Libraries\Faturamento\Entidade\Dominio\EntidadeRepository;

/**
 * @author Iago Oliveira <prog.iago.oliveira@gmail.com>
 * @since 03/11/2024
 */
class MemoriaEntidadeRepository implements EntidadeRepository
{
    function buscar($codigo)
    {
        return new EntidadeDto(
            1,
            'NOME TESTE LTDA',
            'NOME FANTASIA',
            '42022181000105',
            '261092375',
            null,
            '4798877-6655',
            '4798877-6655',
            'teste@teste.com',
            'testeContabilidade@teste.com',
            '88410000',
            'rua',
            140,
            'Centro',
            'casa',
            'SC',
            'Atalanta',
            4201802,
            null,
            null,
        );
    }

    function incluir(Entidade $entidade)
    {
        // TODO: Implement incluir() method.
    }

    function atualizar(Entidade $entidade)
    {
        // TODO: Implement alterar() method.
    }

    function excluir($codigo)
    {
        // TODO: Implement excluir() method.
    }
}