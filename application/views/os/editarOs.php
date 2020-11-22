<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery.validate.js"></script>
<script src="<?php echo base_url() ?>assets/js/sweetalert2.all.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url() ?>assets/trumbowyg/ui/trumbowyg.css">
<script type="text/javascript" src="<?php echo base_url() ?>assets/trumbowyg/trumbowyg.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/trumbowyg/langs/pt_br.js"></script>

<style>
    .ui-datepicker {
        z-index: 99999 !important;
    }

    .trumbowyg-box {
        margin-top: 0;
        margin-bottom: 0;
    }
</style>
<nav class="modulos">
<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="fas fa-diagnoses"></i>
                </span>
                <h5>Editar Ordem de Serviço</h5>
            </div>
            <div class="widget-content nopadding">
                <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                    <ul class="nav nav-tabs">
                    <li id="tabDetalhes"><a href="#tab3" data-toggle="tab">Detalhes</a></li>
                        <li class="active" id="tabServicos"><a href="#tab1" data-toggle="tab">Serviços</a></li>
                        <li id="tabAnotacoes"><a href="#tab5" data-toggle="tab">Anotações</a></li>
                    </ul>
                    <div class="tab-content">
                        <!--Serviços-->
                        <div class="tab-pane active" id="tab1">
                            <div class="span12" style="padding: 1%; margin-left: 0">
                                <div class="span12 well" style="padding: 1%; margin-left: 0">
                                <?php echo form_hidden('idOs', $result->idOs) ?>
                                     <h5>Número da OS:
                                                <?php echo $result->idOs ?>
                                            </h5>
                                    <form id="formServicos" action="<?php echo base_url() ?>index.php/os/adicionarServico" method="post">
                                    
                                        <div class="span6">
                                           
                                            <input type="hidden" name="idServico" id="idServico" />
                                            <input type="hidden" name="idOsServico" id="idOsServico" value="<?php echo $result->idOs ?>" />
                                            <label for="">Serviço</label>
                                            <input type="text" class="span12" name="servico" id="servico" placeholder="Digite o nome do serviço" />
                                        </div>
                                        <div class="span2">
                                            <label for="">Preço</label>
                                            <input type="text" placeholder="Preço" id="preco_servico" name="preco" class="span12 money" />
                                        </div>
                                        <div class="span2">
                                            <label for="">Quantidade</label>
                                            <input type="text" placeholder="Quantidade" id="quantidade_servico" name="quantidade" class="span12" />
                                        </div>
                                        <div class="span2">
                                            <label for="">.</label>
                                            <button class="btn btn-success span12"><i class="fas fa-plus"></i> Adicionar</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="conteudoservicoos">
                                    <div class="span12" id="divServicos" style="margin-left: 0">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Serviço</th>
                                                    <th>Quantidade</th>
                                                    <th>Preço</th>
                                                    <th>Ações</th>
                                                    <th>Sub-total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $total = 0;
                                                foreach ($servicos as $s) {
                                                    $preco = $s->preco ?: $s->precoVenda;
                                                    $subtotal = $preco * ($s->quantidade ?: 1);
                                                    $total = $total + $subtotal;
                                                    echo '<tr>';
                                                    echo '<td>' . $s->nome . '</td>';
                                                    echo '<td>' . ($s->quantidade ?: 1) . '</td>';
                                                    echo '<td>' . $preco  . '</td>';
                                                    echo '<td><span idAcao="' . $s->idServicos_os . '" title="Excluir Serviço" class="btn btn-danger servico"><i class="fas fa-trash-alt"></i></span></td>';
                                                    echo '<td>R$ ' . number_format($subtotal, 2, ',', '.') . '</td>';
                                                    echo '</tr>';
                                                } ?>
                                                <tr>
                                                    <td colspan="4" style="text-align: right"><strong>Total:</strong></td>
                                                    <td><strong>R$
                                                            <?php echo number_format($total, 2, ',', '.'); ?><input type="hidden" id="total-servico" value="<?php echo number_format($total, 2); ?>"></strong></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                              </div>
                              <br>
                            
                            </div>
                            <form action="<?php echo current_url(); ?>" method="post" id="formOs">
                                <div class="span12" style="padding: 1%; margin-left: 0">
                                        <div class="span6 offset3" style="text-align: center">
                                       
                                                <a href="<?php echo base_url() ?>index.php/os" class="btn"> Cancelar</a>
                                        </div>
                                    </div>
                                </form>
                        </div>

                        <div class="tab-pane" id="tab3">
                            <div class="span12" id="divCadastrarOs">
                                <div class="conteudoos">
                                    <form action="<?php echo current_url(); ?>" method="post" id="formOs">
                                        <?php echo form_hidden('idOs', $result->idOs) ?>
                                        <div class="span12" style="padding: 1%; margin-left: 0">
                                            <h5>Número da OS:
                                                <?php echo $result->idOs ?>
                                            </h5>
                                            <div class="span6" style="margin-left: 0">
                                                <label for="cliente">Cliente<span class="required">*</span></label>
                                                <input id="cliente" class="span12" type="text" name="cliente" value="<?php echo $result->nomeCliente ?>" />
                                                <input id="clientes_id" class="span12" type="hidden" name="clientes_id" value="<?php echo $result->clientes_id ?>" />
                                                <input id="valorTotal" type="hidden" name="valorTotal" value="" />
                                            </div>
                                            <div class="span6">
                                                <label for="tecnico">Técnico / Responsável<span class="required">*</span></label>
                                                <input id="tecnico" class="span12" type="text" name="tecnico" value="<?php echo $result->nome ?>" />
                                                <input id="usuarios_id" class="span12" type="hidden" name="usuarios_id" value="<?php echo $result->usuarios_id ?>" />
                                            </div>
                                        </div>
                                        <div class="span12" style="padding: 1%; margin-left: 0">
                                            <div class="span3">
                                                <label for="status">Status<span class="required">*</span></label>
                                                <select class="span12" name="status" id="status" value="">
                                                    <option <?php if ($result->status == 'Orçamento') {
                                                                echo 'selected';
                                                            } ?> value="Orçamento">Orçamento</option>
                                                    <option <?php if ($result->status == 'Aberto') {
                                                                echo 'selected';
                                                            } ?> value="Aberto">Aberto</option>
                                                    <option <?php if ($result->status == 'Faturado') {
                                                                echo 'selected';
                                                            } ?> value="Faturado">Faturado</option>
                                                    <option <?php if ($result->status == 'Em Andamento') {
                                                                echo 'selected';
                                                            } ?> value="Em Andamento">Em Andamento</option>
                                                    <option <?php if ($result->status == 'Finalizado') {
                                                                echo 'selected';
                                                            } ?> value="Finalizado">Finalizado</option>
                                                    <option <?php if ($result->status == 'Cancelado') {
                                                                echo 'selected';
                                                            } ?> value="Cancelado">Cancelado</option>
                                                    <option <?php if ($result->status == 'Aguardando Peças') {
                                                                echo 'selected';
                                                            } ?> value="Aguardando Peças">Aguardando Peças</option>
                                                </select>
                                            </div>
                                            <div class="span3">
                                                <label for="dataInicial">Data Inicial<span class="required">*</span></label>
                                                <input id="dataInicial" autocomplete="off" class="span12 datepicker" type="text" name="dataInicial" value="<?php echo date('d/m/Y', strtotime($result->dataInicial)); ?>" />
                                            </div>
                                            <div class="span3">
                                                <label for="dataFinal">Data Final<span class="required">*</span></label>
                                                <input id="dataFinal" autocomplete="off" class="span12 datepicker" type="text" name="dataFinal" value="<?php echo date('d/m/Y', strtotime($result->dataFinal)); ?>" />
                                            </div>
                                            
                                        </div>
                                        <div class="span6" style="padding: 1%; margin-left: 0">
                                            <label for="descricaoProduto">
                                                <h4>Descrição Serviço</h4>
                                            </label>
                                            <textarea class="span 4" name="descricaoProduto" id="descricaoProduto" cols="10" rows="3"><?php echo $result->descricaoProduto ?></textarea>
                                        </div>
                                        <div class="span6" style="padding: 1%; margin-left: 0">
                                            <label for="defeito">
                                                <h4>Defeito</h4>
                                            </label>
                                            <textarea class="span 4" name="defeito" id="defeito" cols="10" rows="3"><?php echo $result->defeito ?></textarea>
                                        </div>
                                        <div class="span6" style="padding: 1%; margin-left: 0">
                                            <label for="observacoes">
                                                <h4>Observações</h4>
                                            </label>
                                            <textarea class="span 4" name="observacoes" id="observacoes" cols="10" rows="3"><?php echo $result->observacoes ?></textarea>
                                        </div>
                                        <div class="span6" style="padding: 1%; margin-left: 0">
                                            <label for="laudoTecnico">
                                                <h4>Laudo Técnico</h4>
                                            </label>
                                            <textarea class="span 4" name="laudoTecnico" id="laudoTecnico" cols="10" rows="3"><?php echo $result->laudoTecnico ?></textarea>
                                        </div>
                                 </div>
                           
                            <div class="span12" style="padding: 1%; margin-left: 0">
                                        <div class="span6 offset3" style="text-align: center">
                                            
                                            <button class="btn btn-primary" id="btnContinuar"><i class="fas fa-sync-alt"></i> Finalizar</button>
                                            <a target="_blank" title="Imprimir" class="btn btn-inverse" href="<?php echo site_url() ?>/os/imprimir/<?php echo $result->idOs; ?>"><i class="fas fa-print"></i> Imprimir</a>
                                            <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eOs')) {
                                                $zapnumber = preg_replace("/[^0-9]/", "", $result->celular_cliente);
                                                echo '<a title="Enviar Por WhatsApp" class="btn btn-success" id="enviarWhatsApp" target="_blank" href="https://web.whatsapp.com/send?phone=55' . $zapnumber . '&text=Prezado(a)%20*' . $result->nomeCliente . '*.%0d%0a%0d%0aSua%20*Ordem%20de%20Serviço%20' . $result->idOs . '*%20referente%20ao%20equipamento%20*' . strip_tags($result->descricaoProduto) . '*%20foi%20atualizada%20para%20*' . $result->status . '*.%0d%0aFavor%20entrar%20em%20contato%20para%20saber%20mais%20detalhes,%20ou%20acesse%20*http://localhost/master/index.php/mine*%20%0d%0a%0d%0aAtenciosamente,%20' . $emitente[0]->nome . '%20' . $emitente[0]->telefone . '"><i class="fab fa-whatsapp"></i> WhatsApp</a>';
                                            } ?>
                                                <a href="<?php echo base_url() ?>index.php/os" class="btn"><i class="fas fa-backward"></i> Cancelar</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>                        
                        
                        <!--Anotações-->
                        <div class="tab-pane" id="tab5">
                            <div class="span12" style="padding: 1%; margin-left: 0">

                                <div class="span12" id="divAnotacoes" style="margin-left: 0">

                                    <a href="#modal-anotacao" id="btn-anotacao" role="button" data-toggle="modal" class="btn btn-success"><i class="fas fa-plus"></i> Adicionar anotação</a>
                                    <hr>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Anotação</th>
                                                <th>Data/Hora</th>
                                                <th>Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($anotacoes as $a) {
                                                echo '<tr>';
                                                echo '<td>' . $a->anotacao . '</td>';
                                                echo '<td>' . date('d/m/Y H:i:s', strtotime($a->data_hora))  . '</td>';
                                                echo '<td><span idAcao="' . $a->idAnotacoes . '" title="Excluir Anotação" class="btn btn-danger anotacao"><i class="fas fa-trash-alt"></i></span></td>';
                                                echo '</tr>';
                                            }
                                            if (!$anotacoes) {
                                                echo '<tr><td colspan="2">Nenhuma anotação cadastrada</td></tr>';
                                            }

                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <form action="<?php echo current_url(); ?>" method="post" id="formOs">
                                <div class="span12" style="padding: 1%; margin-left: 0">
                                        <div class="span6 offset3" style="text-align: center">
                                                <a href="<?php echo base_url() ?>index.php/os" class="btn"> Cancelar</a>
                                        </div>
                                    </div>
                                </form>
                        </div>
                        <!-- Fim tab anotações -->
                    </div>
                </div>
                &nbsp
            </div>
        </div>
    </div>
</div>
</nav>

<!-- Modal visualizar anexo -->
<div id="modal-anexo" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Visualizar Anexo</h3>
    </div>
    <div class="modal-body">
        <div class="span12" id="div-visualizar-anexo" style="text-align: center">
            <div class='progress progress-info progress-striped active'>
                <div class='bar' style='width: 100%'></div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Fechar</button>
        <a href="" id-imagem="" class="btn btn-inverse" id="download">Download</a>
        <a href="" link="" class="btn btn-danger" id="excluir-anexo">Excluir Anexo</a>
    </div>
</div>

<!-- Modal cadastro anotações -->
<div id="modal-anotacao" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form action="#" method="POST" id="formAnotacao">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel">Adicionar Anotação</h3>
        </div>
        <div class="modal-body">
            <div class="span12" id="divFormAnotacoes" style="margin-left: 0"></div>
            <div class="span12" style="margin-left: 0">
                <label for="anotacao">Anotação</label>
                <textarea class="span12" name="anotacao" id="anotacao" cols="30" rows="3"></textarea>
                <input type="hidden" name="os_id" value="<?php echo $result->idOs; ?>">
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true" id="btn-close-anotacao">Fechar</button>
            <button class="btn btn-primary">Adicionar</button>
        </div>
    </form>
</div>

<script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery.validate.js"></script>
<script src="<?php echo base_url(); ?>assets/js/maskmoney.js"></script>

<script type="text/javascript">
    $(document).ready(function() {

        $(".money").maskMoney();

        $('#recebido').click(function(event) {
            var flag = $(this).is(':checked');
            if (flag == true) {
                $('#divRecebimento').show();
            } else {
                $('#divRecebimento').hide();
            }
        });

        $("#servico").autocomplete({
            source: "<?php echo base_url(); ?>index.php/os/autoCompleteServico",
            minLength: 2,
            select: function(event, ui) {
                $("#idServico").val(ui.item.id);
                $("#preco_servico").val(ui.item.preco);
                $("#quantidade_servico").focus();
            }
        });


        $("#cliente").autocomplete({
            source: "<?php echo base_url(); ?>index.php/os/autoCompleteCliente",
            minLength: 2,
            select: function(event, ui) {
                $("#clientes_id").val(ui.item.id);
            }
        });

        $("#tecnico").autocomplete({
            source: "<?php echo base_url(); ?>index.php/os/autoCompleteUsuario",
            minLength: 2,
            select: function(event, ui) {
                $("#usuarios_id").val(ui.item.id);
            }
        });

        $("#formOs").validate({
            rules: {
                cliente: {
                    required: true
                },
                tecnico: {
                    required: true
                },
                dataInicial: {
                    required: true
                },
                dataFinal: {
                    required: true
                }
            },
            messages: {
                cliente: {
                    required: 'Campo Requerido.'
                },
                tecnico: {
                    required: 'Campo Requerido.'
                },
                dataInicial: {
                    required: 'Campo Requerido.'
                },
                dataFinal: {
                    required: 'Campo Requerido.'
                }
            },
            errorClass: "help-inline",
            errorElement: "span",
            highlight: function(element, errorClass, validClass) {
                $(element).parents('.control-group').addClass('error');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).parents('.control-group').removeClass('error');
                $(element).parents('.control-group').addClass('success');
            }
        });

        $("#formServicos").validate({
            rules: {
                servico: {
                    required: true
                }
            },
            messages: {
                servico: {
                    required: 'Insira um serviço'
                }
            },
            submitHandler: function(form) {
                var dados = $(form).serialize();

                $("#divServicos").html("<div class='progress progress-info progress-striped active'><div class='bar' style='width: 100%'></div></div>");
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>index.php/os/adicionarServico",
                    data: dados,
                    dataType: 'json',
                    success: function(data) {
                        if (data.result == true) {
                            $("#divServicos").load("<?php echo current_url(); ?> #divServicos");
                            $("#quantidade_servico").val('');
                            $("#preco_servico").val('');
                            $("#servico").val('').focus();
                        } else {
                            Swal.fire({
                                type: "error",
                                title: "Atenção",
                                text: "Ocorreu um erro ao tentar adicionar serviço."
                            });
                        }
                    }
                });
                return false;
            }
        });

        $("#formAnotacao").validate({
            rules: {
                anotacao: {
                    required: true
                }
            },
            messages: {
                anotacao: {
                    required: 'Insira a anotação'
                }
            },
            submitHandler: function(form) {
                var dados = $(form).serialize();
                $("#divFormAnotacoes").html("<div class='progress progress-info progress-striped active'><div class='bar' style='width: 100%'></div></div>");

                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>index.php/os/adicionarAnotacao",
                    data: dados,
                    dataType: 'json',
                    success: function(data) {
                        if (data.result == true) {
                            $("#divAnotacoes").load("<?php echo current_url(); ?> #divAnotacoes");
                            $("#anotacao").val('');
                            $('#btn-close-anotacao').trigger('click');
                            $("#divFormAnotacoes").html('');
                        } else {
                            Swal.fire({
                                type: "error",
                                title: "Atenção",
                                text: "Ocorreu um erro ao tentar adicionar anotação."
                            });
                        }
                    }
                });
                return false;
            }
        });

        $(document).on('click', '.servico', function(event) {
            var idServico = $(this).attr('idAcao');
            if ((idServico % 1) == 0) {
                $("#divServicos").html("<div class='progress progress-info progress-striped active'><div class='bar' style='width: 100%'></div></div>");
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>index.php/os/excluirServico",
                    data: "idServico=" + idServico,
                    dataType: 'json',
                    success: function(data) {
                        if (data.result == true) {
                            $("#divServicos").load("<?php echo current_url(); ?> #divServicos");

                        } else {
                            Swal.fire({
                                type: "error",
                                title: "Atenção",
                                text: "Ocorreu um erro ao tentar excluir serviço."
                            });
                        }
                    }
                });
                return false;
            }
        });

        $(document).on('click', '.anotacao', function(event) {
            var idAnotacao = $(this).attr('idAcao');
            if ((idAnotacao % 1) == 0) {
                $("#divAnotacoes").html("<div class='progress progress-info progress-striped active'><div class='bar' style='width: 100%'></div></div>");
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>index.php/os/excluirAnotacao",
                    data: "idAnotacao=" + idAnotacao,
                    dataType: 'json',
                    success: function(data) {
                        if (data.result == true) {
                            $("#divAnotacoes").load("<?php echo current_url(); ?> #divAnotacoes");

                        } else {
                            Swal.fire({
                                type: "error",
                                title: "Atenção",
                                text: "Ocorreu um erro ao tentar excluir serviço."
                            });
                        }
                    }
                });
                return false;
            }
        });

        $(".datepicker").datepicker({
            dateFormat: 'dd/mm/yy'
        });

        $('.editor').trumbowyg({
            lang: 'pt_br'
        });
    });
</script>
