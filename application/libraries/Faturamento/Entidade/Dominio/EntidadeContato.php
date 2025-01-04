<?php

namespace Libraries\Faturamento\Entidade\Dominio;

use Libraries\Public\Contato;

/**
 * @author Iago Oliveira <prog.iago.oliveira@gmail.com>
 * @since 03/11/2024
 */
class EntidadeContato extends Contato
{
    private $emailContabilidade;


    /** @return string */
    public function getEmailContabilidade()
    {
        return $this->emailContabilidade;
    }

    /**
     * @param string $emailContabilidade
     * @return self
     */
    public function setEmailContabilidade($emailContabilidade)
    {
        $this->emailContabilidade = $emailContabilidade;
        return $this;
    }
}
