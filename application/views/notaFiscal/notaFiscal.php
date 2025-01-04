<style>
  select {
    width: 70px;
  }
</style>
<div class="new122">
<div class="widget-title" style="margin: -20px 0 0">
<div class="widget-box">
    <h5 style="padding: 3px 0"></h5>
    <div class="widget-content nopadding tab-content">
        <table id="tabela" class="table table-bordered ">
            <thead>
                <tr>
                    <th>Nº</th>
                    <th>Serie</th>
                    <th>Chave</th>
                    <th>Protocolo</th>
                    <th>Situação</th>
                    <th>Cliente</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php

                    if (!$results) {
                        echo '<tr>
                                <td colspan="5">Nenhuma Nota Gerada</td>
                            </tr>';
                    }
                    foreach ($results as $r) {
                        switch ($r->situacao) {    
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

                        echo '<tr>';
                        echo '<td>' . $r->numeroNotaFiscal . '</td>';
                        echo '<td>' . $r->serieNotaFiscal . '</td>';
                        echo '<td>' . $r->chave . '</a></td>';
                        echo '<td>' . $r->protocolo . '</td>';
                        echo '<td>' . $situacao . '</td>';
                        echo '<td>' . $r->nomeCliente . '</td>';
                        echo '<td>';
                        if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vVenda')) {
                            echo '<a style="margin-right: 1%" href="' . base_url() . 'index.php/notaFiscal/visualizar/' . $r->numeroNotaFiscal . '" class="btn-nwe" title="Ver mais detalhes"><i class="bx bx-show bx-xs"></i></a>';
                            echo '<a style="margin-right: 1%" href="' . base_url() . 'index.php/notaFiscal/autorizar/' . $r->numeroNotaFiscal . '" class="btn-nwe" title="Autorizar no SEFAZ"><i class="bx bx-send bx-xs"></i></a>';
                            echo '<a style="margin-right: 1%" href="' . base_url() . 'index.php/notaFiscal/consultarAutorizacao/' . $r->numeroNotaFiscal . '" class="btn-nwe" title="Consultar envio"><i class="bx bx-show bx-xs"></i></a>';
                            echo '<a style="margin-right: 1%" href="' . base_url() . 'index.php/notaFiscal/imprimirDanfe/' . $r->numeroNotaFiscal . '" target="_blank" class="btn-nwe6" title="Imprimir Danfe"><i class="bx bx-printer bx-xs"></i></a>';
                            echo '<a href="#modal-cancelar" role="button" data-toggle="modal" notaFiscal="' . $r->numeroNotaFiscal . '" style="margin-right: 1%" class="btn-nwe4" title="Cancelar"><i class="bx bx-x bx-xs"></i></a>';
                            echo '<a href="#modal-inutilizar" role="button" data-toggle="modal" notaFiscal="' . $r->numeroNotaFiscal . '" style="margin-right: 1%" class="btn-nwe4" title="Inutilizar"><i class="bx bx-trash-alt bx-xs"></i></a>';
                        }
                        echo '</td>';
                        echo '</tr>';
                    } ?>
            </tbody>
        </table>
    </div>
</div>
</div>
<?php echo $this->pagination->create_links(); ?>

<!-- Modal -->
<div id="modal-cancelar" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form action="<?php echo base_url() ?>index.php/notaFiscal/cancelar" method="post">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 id="myModalLabel">Cancelar Nota</h5>
        </div>
        <div class="modal-body">
            <input type="hidden" id="numeroNotaFiscalCancelamento" name="numeroNotaFiscal" value="" />
            <h5 style="text-align: center">Deseja realmente cancelar esta nota?</h5>
            <label for="justificativa">Justificativa:</label>
            <input type="text" id="justificativaCancelamento" name="justificativa" palceholder="justificativa" style="width: 98%; height: 50px" required/>
        </div>
        <div class="modal-footer" style="display:flex;justify-content: center">
            <button class="button btn btn-warning" data-dismiss="modal" aria-hidden="true">
              <span class="button__icon"><i class="bx bx-x"></i></span><span class="button__text2">Voltar</span></button>
            <button class="button btn btn-danger"><span class="button__icon"><i class='bx bx-trash'></i></span> <span class="button__text2">Continuar</span></button>
        </div>
    </form>
</div>

<div id="modal-inutilizar" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form action="<?php echo base_url() ?>index.php/notaFiscal/inutilizar" method="post">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 id="myModalLabel">Inutilizar Nota</h5>
        </div>
        <div class="modal-body">
            <input type="hidden" id="numeroNotaFiscalInutilizacao" name="numeroNotaFiscal" value="" />
            <h5 style="text-align: center">Deseja realmente inutlizar esta nota?</h5>
            <label for="justificativa">Justificativa:</label>
            <input type="text" id="justificativaInutilizacao" name="justificativa" palceholder="justificativa" style="width: 98%; height: 50px" required/>
        </div>
        <div class="modal-footer" style="display:flex;justify-content: center">
            <button class="button btn btn-warning" data-dismiss="modal" aria-hidden="true">
              <span class="button__icon"><i class="bx bx-x"></i></span><span class="button__text2">Voltar</span></button>
            <button class="button btn btn-danger"><span class="button__icon"><i class='bx bx-trash'></i></span> <span class="button__text2">Continuar</span></button>
        </div>
    </form>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $(document).on('click', 'a', function(event) {
            var numeroNotaFiscal = $(this).attr('notaFiscal');
            $('#numeroNotaFiscalInutilizacao').val(numeroNotaFiscal);
            $('#numeroNotaFiscalCancelamento').val(numeroNotaFiscal);
        });
    });
</script>
