<script src="<?php echo base_url() ?>assets/js/jquery.mask.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/funcoes.js"></script>
<script src="<?php echo base_url()?>assets/js/sweetalert2.all.min.js"></script>

<style>
    .modal-body {
    padding   : 20px;
    overflow-y: inherit !important;
    }

    .form-horizontal .controls {
    margin-left: 20px;
    }

    .form-horizontal .control-label {
    padding-top: 6px;
    width      : 160px;
    }

    h5 {
    padding-bottom :15px;
    font-size      : 1.5em;
    font-weight    : 500;
    }

    .form-horizontal .control-group {
    border-top   : 0 solid #ffffff;
    border-bottom: 0 solid #eeeeee;
    margin-bottom: 0;
    }

    .widget-content {
    padding: 0 16px 15px;
    }

    @media (max-width: 480px) {
        .modal-body {
                padding              : 20px;
                overflow-x           : hidden !important;
                grid-template-columns: 1fr !important;
            }
            form {
                display: block !important;
            }
        
            .form-horizontal .control-label {
                margin-bottom: -6px;
            }
            .btn-xs {
                position: initial !important;
            }
        }
</style>

<?php if (!isset($dados) || $dados == null) { ?>
    <div class="row-fluid" style="margin-top:0">
        <div class="span12">
            <div class="widget-box">
                <div class="widget-title">
                    <h5>Dados do Emitente</h5>
                </div>
                <div class="widget-content ">
                    <div class="alert alert-danger">Nenhum dado foi cadastrado até o momento. Essas informações
                        estarão disponíveis na tela de impressão de OS.</div>
                    <a href="#modalCadastrar" data-toggle="modal" role="button" class="button btn btn-success" style="max-width: 150px">
                    <span class="button__icon"><i class='bx bx-plus-circle'></i></span><span class="button__text2">Cadastrar Dados</span></a>
                </div>
            </div>
        </div>
    </div>

    <div id="modalCadastrar" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <form action="<?= site_url('Organize/cadastrarEmitente'); ?>" id="formCadastrar" enctype="multipart/form-data" method="post" class="form-horizontal">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h5 id="myModalLabel" style="text-align-last:center">Organize - Cadastrar Dados do Emitente</h5>
            </div>
            <div class="modal-body" style="display: grid;grid-template-columns: 1fr 1fr">
                <div class="control-group">
                    <label for="nome" class="control-label"><span class="required"></span></label>
                    <div class="controls">
                        <input id="nomeEmitente" placeholder="Razão Social*" type="text" name="nome" value="" />
                    </div>
                </div>
                <div class="control-group">
                    <label for="cnpj" class="control-label"><span class="required"></span></label>
                    <div class="controls">
                        <input class="cnpjEmitente" placeholder="CNPJ*" id="documento" type="text" name="cnpj" value="" />
                        <button style="top:31px;right:40px;position:absolute" id="buscar_info_cnpj" class="btn btn-xs" type="button"><i class="fas fa-search"></i></button>
                    </div>
                </div>
                <div class="control-group">
                    <label for="ie" class="control-label"><span class="required"></span></label>
                    <div class="controls">
                        <input type="text" placeholder="IE*" name="ie" value="" />
                    </div>
                </div>
                <div class="control-group">
                    <label for="cnae" class="control-label"><span class="required"></span></label>
                    <div class="controls">
                        <input type="text" placeholder="CNAE*" name="cnae" value="" />
                    </div>
                </div>
                <div class="control-group">
                    <label for="cep" class="control-label"><span class="required"></span></label>
                    <div class="controls">
                        <input id="cep" type="text" placeholder="CEP*" name="cep" value="" />
                    </div>
                </div>
                <div class="control-group">
                    <label for="logradouro" class="control-label"><span class="required"></span></label>
                    <div class="controls">
                        <input id="rua" type="text" placeholder="Logradouro*" name="logradouro" value="" />
                    </div>
                </div>
                <div class="control-group">
                    <label for="numero" class="control-label"><span class="required"></span></label>
                    <div class="controls">
                        <input type="text" id="numero" placeholder="Número*" name="numero" value="" />
                    </div>
                </div>
                <div class="control-group">
                    <label for="bairro" class="control-label"><span class="required"></span></label>
                    <div class="controls">
                        <input id="bairro" type="text" placeholder="Bairro*" name="bairro" value="" />
                    </div>
                </div>
                <div class="control-group">
                    <label for="cidade" class="control-label"><span class="required"></span></label>
                    <div class="controls">
                        <input id="cidade" type="text" placeholder="Cidade*" name="cidade" value="" />
                    </div>
                </div>
                <div class="control-group">
                    <label for="ibge" class="control-label"><span class="required"></span></label>
                    <div class="controls">
                        <input id="ibge" type="text" placeholder="ibge*" name="ibge" value="" />
                    </div>
                </div>
                <div class="control-group">
                    <label for="uf" class="control-label"><span class="required"></span></label>
                    <div class="controls">
                        <input id="estado" type="text" placeholder="UF*" name="uf" value="" />
                    </div>
                </div>
                <div class="control-group">
                    <label for="telefone" class="control-label"><span class="required"></span></label>
                    <div class="controls">
                        <input id="telefone" type="text" placeholder="Telefone*" name="telefone" value="" />
                    </div>
                </div>
                <div class="control-group">
                    <label for="email" class="control-label"><span class="required"></span></label>
                    <div class="controls">
                        <input id="email" type="text" placeholder="E-mail*" name="email" value="" />
                    </div>
                </div>

                <div class="control-group">
                    <label for="logo" class="control-label"><span class="required">Logotipo*</span></label>
                    <div class="controls">
                        <input type="file" name="userfile" value="" />
                    </div>
                </div>

                <div class="control-group">
                    <label for="regimeTributario" class="control-label"><span class="required"></span></label>
                    <div class="controls">
                        <select name="regimeTributario" id="regimeTributario" value="">
                            <option value="1">Simples Nacional</option>
                        </select>
                    </div>
                </div>

            </div>
            <div class="modal-footer" style="display:flex;justify-content: center">
                <button class="button btn btn-warning" data-dismiss="modal" aria-hidden="true" id="btnCancelExcluir"><span class="button__icon"><i class="bx bx-x"></i></span><span class="button__text2">Cancelar</span></button>
                <button class="button btn btn-success"><span class="button__icon"><i class='bx bx-plus-circle'></i></span><span class="button__text2">Cadastrar</span></button>
            </div>
        </form>
    </div>

<?php
} else { ?>

    <div class="row-fluid" style="margin-top:0">
        <div class="span12">
            <div class="widget-box">
                <div class="widget-title" style="margin: -20px 0 0">
                    <span class="icon">
                        <i class="fas fa-align-justify"></i>
                    </span>
                    <h5>Dados do Emitente</h5>
                </div>
                <div class="widget-content ">
                    <div class="alert alert-info">Os dados abaixo serão utilizados no cabeçalho das telas de impressão.</div>
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td style="width: 25%"><img src=" <?= $dados->url_logo; ?> "></td>
                                <td> <span style="font-size: 20px; ">
                                        <?= $dados->nome; ?> </span> </br><span>
                                        <?= $dados->cnpj; ?> </br>
                                        <?= $dados->rua . ', nº: ' . $dados->numero . ', ' . $dados->bairro . ' - ' . $dados->cidade . ' - ' . $dados->uf; ?><br />
                                        <?= 'CEP: ' . $dados->cep; ?>
                                    </span> </br>
                                    <span> E-mail: <?= $dados->email . ' - Fone: ' . $dados->telefone; ?></span></td>
                            </tr>
                        </tbody>
                    </table>

                    <div style="display:flex">
                      <a href="#modalAlterar" data-toggle="modal" role="button" class="button btn btn-success"><span class="button__icon"><i class='bx bx-edit' ></i></span><span class="button__text2">Atualizar Dados</span></a>
                      <a href="#modalLogo" data-toggle="modal" role="button" class="button btn btn-inverse"><span class="button__icon"><i class='bx bx-upload' ></i></span> <span class="button__text2">Alterar Logo</span></a>
                      <a href="#modalCertificado" data-toggle="modal" role="button" class="button btn btn-inverse"><span class="button__icon"><i class='bx bx-upload' ></i></span> <span class="button__text2">Alterar Certificado</span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="modalAlterar" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <form action="<?= site_url('Organize/editarEmitente'); ?>" id="formAlterar" enctype="multipart/form-data" method="post" class="form-horizontal">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="">Organize - Editar Dados do Emitente</h3>
            </div>
            <div class="modal-body" style="display: grid;grid-template-columns: 1fr 1fr">
                <div class="control-group">
                    <label for="nome" class="control-label"><span class="required"></span></label>
                    <div class="controls">
                        <input id="nomeEmitente" type="text" name="nome" value="<?= $dados->nome; ?>" placeholder="Razão Social*" />
                        <input id="nome" type="hidden" name="id" value="<?= $dados->id; ?>" />
                    </div>
                </div>
                <div class="control-group">
                    <label for="cnpj" class="control-label"><span class="required"></span></label>
                    <div class="controls">
                        <input class="cnpjEmitente" type="text" id="documento" name="cnpj" value="<?= $dados->cnpj; ?>" placeholder="CNPJ*"/>
                        <button style="top:34px;right:40px;position:absolute" id="buscar_info_cnpj" class="btn btn-xs" type="button"><i class="fas fa-search"></i></button>
                    </div>
                </div>
                <div class="control-group">
                    <label for="descricao" class="control-label"><span class="required"></span></label>
                    <div class="controls">
                        <input type="text" name="ie" value="<?= $dados->ie; ?>" placeholder="IE*"/>
                    </div>
                </div>
                <div class="control-group">
                    <label for="cep" class="control-label"><span class="required"></span></label>
                    <div class="controls">
                        <input id="cep" type="text" name="cep" value="<?= $dados->cep; ?>" placeholder="CEP*"/>
                    </div>
                </div>
                <div class="control-group">
                    <label for="descricao" class="control-label"><span class="required"></span></label>
                    <div class="controls">
                        <input type="text" id="rua" name="logradouro" value="<?= $dados->rua; ?>" placeholder="Logradouro*"/>
                    </div>
                </div>
                <div class="control-group">
                    <label for="descricao" class="control-label"><span class="required"></span></label>
                    <div class="controls">
                        <input type="text" id="numero" name="numero" value="<?= $dados->numero; ?>" placeholder="Número*"/>
                    </div>
                </div>
                <div class="control-group">
                    <label for="descricao" class="control-label"><span class="required"></span></label>
                    <div class="controls">
                        <input type="text" id="bairro" name="bairro" value="<?= $dados->bairro; ?>" placeholder="Bairro*"/>
                    </div>
                </div>
                <div class="control-group">
                    <label for="descricao" class="control-label"><span class="required"></span></label>
                    <div class="controls">
                        <input type="text" id="cidade" name="cidade" value="<?= $dados->cidade; ?>" placeholder="Cidade*"/>
                    </div>
                </div>
                <div class="control-group">
                    <label for="ibge" class="control-label"><span class="required"></span></label>
                    <div class="controls">
                        <input type="text" id="ibge" name="ibge" value="<?= $dados->ibge; ?>" placeholder="ibge*"/>
                    </div>
                </div>
                <div class="control-group">
                    <label for="descricao" class="control-label"><span class="required"></span></label>
                    <div class="controls">
                        <input type="text" id="estado" name="uf" value="<?= $dados->uf; ?>" placeholder="UF*"/>
                    </div>
                </div>
                <div class="control-group">
                    <label for="descricao" class="control-label"><span class="required"></span></label>
                    <div class="controls">
                        <input type="text" id="telefone" name="telefone" value="<?= $dados->telefone; ?>" placeholder="Telefone*"/>
                    </div>
                </div>
                <div class="control-group">
                    <label for="descricao" class="control-label"><span class="required"></span></label>
                    <div class="controls">
                        <input id="email" type="text" name="email" value="<?= $dados->email; ?>" placeholder="E-mail*"/>
                    </div>
                </div>
                <div class="control-group">
                    <label for="regimeTributario" class="control-label"><span class="required"></span></label>
                    <div class="controls">
                        <select name="regimeTributario" id="regimeTributario" value="<?= $dados->regime_tributario; ?>">
                            <option value="1">Simples Nacional</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="display:flex;justify-content: center">
                <button class="button btn btn-mini btn-danger" data-dismiss="modal" aria-hidden="true" id="btnCancelExcluir"><span class="button__icon"><i class='bx bx-x' ></i></span> <span class="button__text2">Cancelar</span></button>
                <button class="button btn btn-primary"><span class="button__icon"><i class="bx bx-sync"></i></span><span class="button__text2">Atualizar</span></button>
            </div>
        </form>
    </div>

    <div id="modalLogo" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <form action="<?= site_url('Organize/editarLogo'); ?>" id="formLogo" enctype="multipart/form-data" method="post" class="form-horizontal">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="">Organize - Atualizar Logotipo</h3>
            </div>
            <div class="modal-body">
                <div class="span12 alert alert-info">Selecione uma nova imagem da logotipo. Tamanho indicado (130 X 130).</div>
                <div class="control-group">
                    <label for="logo" class="control-label"><span class="required">Logotipo*</span></label>
                    <div class="controls">
                        <input type="file" name="userfile" value="" />
                        <input id="nome" type="hidden" name="id" value="<?= $dados->id; ?>" />
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="display:flex;justify-content: center">
              <button class="button btn btn-mini btn-danger" data-dismiss="modal" aria-hidden="true" id="btnCancelExcluir"><span class="button__icon"><i class='bx bx-x' ></i></span> <span class="button__text2">Cancelar</span></button>
              <button class="button btn btn-primary"><span class="button__icon"><i class="bx bx-sync"></i></span><span class="button__text2">Atualizar</span></button>
            </div>
        </form>
    </div>

    <div id="modalCertificado" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <form action="<?= site_url('Organize/editarCertificado'); ?>" id="formCertificado" enctype="multipart/form-data" method="post" class="form-horizontal">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="">Organize - Atualizar Certificado</h3>
            </div>
            <div class="modal-body">
                <div class="span12 alert alert-info">Selecione um novo certificado.</div>
                <div class="control-group">
                    <label for="certificado" class="control-label"><span class="required"></span></label>
                    <div class="controls">
                        <input type="file" name="certfile" value="<?= $dados->path_certificado; ?>" />
                        <input id="nome" type="hidden" name="id" value="<?= $dados->id; ?>" />
                    </div>
                </div>
                <div class="control-group">
                    <label for="senhaCertificado" class="control-label"><span class="required"></span></label>
                    <div class="controls">
                        <input id="senhaCertificado" type="password" placeholder="Senha do Certificado*" name="senhaCertificado" value="<?= $dados->senha_certificado; ?>" />
                </div>
            </div>
            <div class="modal-footer" style="display:flex;justify-content: center">
              <button class="button btn btn-mini btn-danger" data-dismiss="modal" aria-hidden="true" id="btnCancelExcluir"><span class="button__icon"><i class='bx bx-x' ></i></span> <span class="button__text2">Cancelar</span></button>
              <button class="button btn btn-primary"><span class="button__icon"><i class="bx bx-sync"></i></span><span class="button__text2">Atualizar</span></button>
            </div>
        </form>
    </div>

<?php } ?>


<script type="text/javascript" src="<?= base_url() ?>assets/js/jquery.validate.js"></script>
<script type="text/javascript">
    $(document).ready(function() {

        $("#formLogo").validate({
            rules: {
                userfile: {
                    required: true
                }
            },
            messages: {
                userfile: {
                    required: 'Campo Requerido.'
                }
            },

            errorClass: "help-inline",
            errorElement: "span",
            highlight: function(element, errorClass, validClass) {
                $(element).parents('.control-group').addClass('error');
                $(element).parents('.control-group').removeClass('success');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).parents('.control-group').removeClass('error');
                $(element).parents('.control-group').addClass('success');
            }
        });

        $("#formCertificado").validate({
            rules: {
                certifile: {
                    required: true
                }
            },
            messages: {
                certifile: {
                    required: 'Campo Requerido.'
                }
            },

            errorClass: "help-inline",
            errorElement: "span",
            highlight: function(element, errorClass, validClass) {
                $(element).parents('.control-group').addClass('error');
                $(element).parents('.control-group').removeClass('success');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).parents('.control-group').removeClass('error');
                $(element).parents('.control-group').addClass('success');
            }
        });


        $("#formCadastrar").validate({
            rules: {
                userfile: {
                    required: true
                },
                nome: {
                    required: true
                },
                cnpj: {
                    required: true
                },
                ie: {
                    required: true
                },
                logradouro: {
                    required: true
                },
                numero: {
                    required: true
                },
                bairro: {
                    required: true
                },
                cidade: {
                    required: true
                },
                uf: {
                    required: true
                },
                telefone: {
                    required: true
                },
                email: {
                    required: true
                }
            },
            messages: {
                userfile: {
                    required: 'Campo Requerido.'
                },
                nome: {
                    required: 'Campo Requerido.'
                },
                cnpj: {
                    required: 'Campo Requerido.'
                },
                ie: {
                    required: 'Campo Requerido.'
                },
                logradouro: {
                    required: 'Campo Requerido.'
                },
                numero: {
                    required: 'Campo Requerido.'
                },
                bairro: {
                    required: 'Campo Requerido.'
                },
                cidade: {
                    required: 'Campo Requerido.'
                },
                uf: {
                    required: 'Campo Requerido.'
                },
                telefone: {
                    required: 'Campo Requerido.'
                },
                email: {
                    required: 'Campo Requerido.'
                }
            },

            errorClass: "help-inline",
            errorElement: "span",
            highlight: function(element, errorClass, validClass) {
                $(element).parents('.control-group').addClass('error');
                $(element).parents('.control-group').removeClass('success');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).parents('.control-group').removeClass('error');
                $(element).parents('.control-group').addClass('success');
            }
        });


        $("#formAlterar").validate({
            rules: {
                userfile: {
                    required: true
                },
                nome: {
                    required: true
                },
                cnpj: {
                    required: true
                },
                ie: {
                    required: true
                },
                logradouro: {
                    required: true
                },
                numero: {
                    required: true
                },
                bairro: {
                    required: true
                },
                cidade: {
                    required: true
                },
                uf: {
                    required: true
                },
                telefone: {
                    required: true
                },
                email: {
                    required: true
                }
            },
            messages: {
                userfile: {
                    required: 'Campo Requerido.'
                },
                nome: {
                    required: 'Campo Requerido.'
                },
                cnpj: {
                    required: 'Campo Requerido.'
                },
                ie: {
                    required: 'Campo Requerido.'
                },
                logradouro: {
                    required: 'Campo Requerido.'
                },
                numero: {
                    required: 'Campo Requerido.'
                },
                bairro: {
                    required: 'Campo Requerido.'
                },
                cidade: {
                    required: 'Campo Requerido.'
                },
                uf: {
                    required: 'Campo Requerido.'
                },
                telefone: {
                    required: 'Campo Requerido.'
                },
                email: {
                    required: 'Campo Requerido.'
                }
            },

            errorClass: "help-inline",
            errorElement: "span",
            highlight: function(element, errorClass, validClass) {
                $(element).parents('.control-group').addClass('error');
                $(element).parents('.control-group').removeClass('success');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).parents('.control-group').removeClass('error');
                $(element).parents('.control-group').addClass('success');
            }
        });

    });
</script>
