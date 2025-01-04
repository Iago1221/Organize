<div class="accordion" id="collapse-group">
    <div class="accordion-group widget-box">
        <div class="accordion-heading">
            <div class="widget-title" style="margin: -20px 0 0">
                <a data-parent="#collapse-group" href="#collapseGOne" data-toggle="collapse">
                    <span class="icon"><i class="fas fa-shopping-bag"></i></span>
                    <h5>Dados da Nota Fiscal</h5>
                </a>
            </div>
        </div>
        <div class="collapse in accordion-body">
            <div class="widget-content">
                <table class="table table-bordered">
                    
                    <tbody>
                        <tr>
                            <td style="text-align: right;"><strong>Numero</strong></td>
                            <td>
                                <?php echo $result->numeroNotaFiscal ?>
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: right;"><strong>Série</strong></td>
                            <td>
                                <?php echo $result->serieNotaFiscal ?>
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: right"><strong>Venda</strong></td>
                            <td>
                                <?php echo $result->venda ?>
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: right"><strong>Cliente</strong></td>
                            <td>
                                <?php echo $result->nomeCliente; ?>
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: right"><strong>Situação</strong></td>
                            <td>
                                <?php
                                    switch ( $result->situacao) {    
                                        case 2: 
                                            $situacao = 'Autorizada';
                                            break;
                                        case 3: 
                                            $situacao = 'Rejeitada';
                                            break;
                                        case 4: 
                                            $situacao = 'Cancelada';
                                            break;
                                        case 5: 
                                            $situacao = 'Inutilizada';
                                            break;
                                        case 6: 
                                            $situacao = 'Enviada';
                                            break;
                                        default:
                                            $situacao = 'Digitada';
                                            break;
                                    }  
                                    echo $situacao; 
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: right"><strong>Recibo</strong></td>
                            <td>
                                <?php echo $result->recibo; ?>
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: right"><strong>Chave</strong></td>
                            <td>
                                <?php echo $result->chave; ?>
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: right"><strong>Protocolo</strong></td>
                            <td>
                                <?php echo $result->protocolo; ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
