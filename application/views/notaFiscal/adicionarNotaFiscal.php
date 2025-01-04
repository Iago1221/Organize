<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery.validate.js"></script>
<script src="<?php echo base_url() ?>assets/js/sweetalert2.all.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url() ?>assets/trumbowyg/ui/trumbowyg.css">
<script type="text/javascript" src="<?php echo base_url() ?>assets/trumbowyg/trumbowyg.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/trumbowyg/langs/pt_br.js"></script>

<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title" style="margin: -20px 0 0">
                <span class="icon">
                    <i class="fas fa-cash-register"></i>
                </span>
                <h5>Inciar Nota Fiscal</h5>
            </div>
            <div class="widget-content nopadding tab-content">
                <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab1">
                            <div class="span12" id="divEditarNotaFiscal">
                                <form action="<?php echo base_url() ?>index.php/notaFiscal/adicionar " method="post" id="formNotaFiscal">
                                    <input type="hidden" name="serie" value="<?php echo $result->serie;  ?>">
                                    <input type="hidden" name="numero" value="<?php echo $result->numero;  ?>">
                                    <input type="hidden" name="venda" value="<?php echo $result->venda;  ?>">
                                    <table class="table table-bordered">
                                        <tbody>
                                        <tr>
                                            <td style="text-align: left"><strong>Série</strong></td>
                                            <td>
                                                <?php echo $result->serie;  ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: left"><strong>Número</strong></td>
                                            <td>
                                                <?php echo $result->numero; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: left"><strong>Venda</strong></td>
                                            <td>
                                                <?php echo $result->venda; ?>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>

                                    <div class="span12" style="padding: 1%; margin-left: 0">
                                        <div class="span8 offset2" style="text-align: center;display:flex; flex-wrap: wrap">
                                            <button class="button btn btn-primary" id="btnContinuar">
                                                <span class="button__icon"><i class="bx bx-sync"></i></span><span class="button__text2">Incluir</span></button>
                                            <a href="<?php echo base_url() ?>index.php/vendas" class="button btn btn-warning">
                                                <span class="button__icon"><i class="bx bx-undo"></i></span> <span class="button__text2">Voltar</span></a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                &nbsp
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url(); ?>assets/js/maskmoney.js"></script>
<script type="text/javascript">

        $(".datepicker").datepicker({
            dateFormat: 'dd/mm/yy'
        });
        $('.editor').trumbowyg({
            lang: 'pt_br'
        });
</script>
