<?php $permissoes = unserialize($result->permissoes);?>
<div class="span12" style="margin-left: 0">
    <form action="<?php echo base_url();?>index.php/permissoes/editar" id="formPermissao" method="post">

    <div class="span12" style="margin-left: 0">
        
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="fas fa-lock"></i>
                </span>
                <h5>Editar Permissão</h5>
            </div>
            <div class="widget-content">
                
                <div class="span4">
                    <label>Nome da Permissão</label>
                    <input name="nome" type="text" id="nome" class="span12" value="<?php echo $result->nome; ?>" />
                    <input type="hidden" name="idPermissao" value="<?php echo $result->idPermissao; ?>">

                </div>

                <div class="span3">
                    <label>Situação</label>
                    
                    <select name="situacao" id="situacao" class="span12">
                        <?php if ($result->situacao == 1) {
                            $sim = 'selected';
                            $nao ='';

} else {
    $sim = '';
    $nao ='selected';
}?>
                        <option value="1" <?php echo $sim;?>>Ativo</option>
                        <option value="0" <?php echo $nao;?>>Inativo</option>
                    </select>

                </div>
                <div class="span4">
                    <br/>
                    <label>
                        <input name="" type="checkbox" value="1" id="marcarTodos" />
                        <span class="lbl"> Marcar Todos</span>

                    </label>
                    <br/>
                </div>

                <div class="control-group">
                    <label for="documento" class="control-label"></label>
                    <div class="controls">

                        <table class="table table-bordered">
                            <tbody>
                                <tr>

                                    <td>
                                        <label>
                                            <input <?php if (isset($permissoes['vCliente'])) {
                                                if ($permissoes['vCliente'] == '1') {
                                                    echo 'checked';
                                                }
}?> name="vCliente" class="marcar" type="checkbox" value="1" />
                                            <span class="lbl"> Visualizar Cliente</span>
                                        </label>
                                    </td>

                                    <td>
                                        <label>
                                            <input <?php if (isset($permissoes['aCliente'])) {
                                                if ($permissoes['aCliente'] == '1') {
                                                    echo 'checked';
                                                }
}?> name="aCliente" class="marcar" type="checkbox" value="1" />
                                            <span class="lbl"> Adicionar Cliente</span>
                                        </label>
                                    </td>

                                    <td>
                                        <label>
                                            <input <?php if (isset($permissoes['eCliente'])) {
                                                if ($permissoes['eCliente'] == '1') {
                                                    echo 'checked';
                                                }
}?> name="eCliente" class="marcar" type="checkbox" value="1" />
                                            <span class="lbl"> Editar Cliente</span>
                                        </label>
                                    </td>
                                    <td>
                                        <label>
                                            <input <?php if (isset($permissoes['dCliente'])) {
                                                if ($permissoes['dCliente'] == '1') {
                                                    echo 'checked';
                                                }
}?> name="dCliente" class="marcar" type="checkbox" value="1" />
                                            <span class="lbl"> Excluir Cliente</span>
                                        </label>
                                    </td>
                                 
                                </tr>

                                <tr><td colspan="4"></td></tr>
                                
                                <tr>

                                    <td>
                                        <label>
                                            <input <?php if (isset($permissoes['vServico'])) {
                                                if ($permissoes['vServico'] == '1') {
                                                    echo 'checked';
                                                }
}?> name="vServico" class="marcar" type="checkbox" value="1" />
                                            <span class="lbl"> Visualizar Serviço</span>
                                        </label>
                                    </td>

                                    <td>
                                        <label>
                                            <input <?php if (isset($permissoes['aServico'])) {
                                                if ($permissoes['aServico'] == '1') {
                                                    echo 'checked';
                                                }
}?> name="aServico" class="marcar" type="checkbox" value="1" />
                                            <span class="lbl"> Adicionar Serviço</span>
                                        </label>
                                    </td>

                                    <td>
                                        <label>
                                            <input <?php if (isset($permissoes['eServico'])) {
                                                if ($permissoes['eServico'] == '1') {
                                                    echo 'checked';
                                                }
}?> name="eServico" class="marcar" type="checkbox" value="1" />
                                            <span class="lbl"> Editar Serviço</span>
                                        </label>
                                    </td>

                                    <td>
                                        <label>
                                            <input <?php if (isset($permissoes['dServico'])) {
                                                if ($permissoes['dServico'] == '1') {
                                                    echo 'checked';
                                                }
}?> name="dServico" class="marcar" type="checkbox" value="1" />
                                            <span class="lbl"> Excluir Serviço</span>
                                        </label>
                                    </td>
                                 
                                </tr>
                                
                                <tr><td colspan="4"></td></tr>
                                <tr>

                                    <td>
                                        <label>
                                            <input <?php if (isset($permissoes['vOs'])) {
                                                if ($permissoes['vOs'] == '1') {
                                                    echo 'checked';
                                                }
}?> name="vOs" class="marcar" type="checkbox" value="1" />
                                            <span class="lbl"> Visualizar  Ordem de Serviço</span>
                                        </label>
                                    </td>

                                    <td>
                                        <label>
                                            <input <?php if (isset($permissoes['aOs'])) {
                                                if ($permissoes['aOs'] == '1') {
                                                    echo 'checked';
                                                }
}?> name="aOs" class="marcar" type="checkbox" value="1" />
                                            <span class="lbl"> Adicionar  Ordem de Serviço</span>
                                        </label>
                                    </td>

                                    <td>
                                        <label>
                                            <input <?php if (isset($permissoes['eOs'])) {
                                                if ($permissoes['eOs'] == '1') {
                                                    echo 'checked';
                                                }
}?> name="eOs" class="marcar" type="checkbox" value="1" />
                                            <span class="lbl"> Editar  Ordem de Serviço</span>
                                        </label>
                                    </td>

                                    <td>
                                        <label>
                                            <input <?php if (isset($permissoes['dOs'])) {
                                                if ($permissoes['dOs'] == '1') {
                                                    echo 'checked';
                                                }
}?> name="dOs" class="marcar" type="checkbox" value="1" />
                                            <span class="lbl"> Excluir  Ordem de Serviço</span>
                                        </label>
                                    </td>
                                 
                                </tr>
                                <tr><td colspan="4"></td></tr>

                                <tr>

                                    <td>
                                        <label>
                                            <input <?php if (isset($permissoes['rCliente'])) {
                                                if ($permissoes['rCliente'] == '1') {
                                                    echo 'checked';
                                                }
}?> name="rCliente" class="marcar" type="checkbox" value="1" />
                                            <span class="lbl"> Relatório Cliente</span>
                                        </label>
                                    </td>

                                    <td>
                                        <label>
                                            <input <?php if (isset($permissoes['rServico'])) {
                                                if ($permissoes['rServico'] == '1') {
                                                    echo 'checked';
                                                }
}?> name="rServico" class="marcar" type="checkbox" value="1" />
                                            <span class="lbl"> Relatório Serviço</span>
                                        </label>
                                    </td>

                                    <td>
                                        <label>
                                            <input <?php if (isset($permissoes['rOs'])) {
                                                if ($permissoes['rOs'] == '1') {
                                                    echo 'checked';
                                                }
}?> name="rOs" class="marcar" type="checkbox" value="1" />
                                            <span class="lbl"> Relatório Ordem de Serviço</span>
                                        </label>
                                    </td>
                                 
                                </tr>

                                <tr><td colspan="4"></td></tr>

                                <tr>

                                    <td>
                                        <label>
                                            <input <?php if (isset($permissoes['cUsuario'])) {
                                                if ($permissoes['cUsuario'] == '1') {
                                                    echo 'checked';
                                                }
}?> name="cUsuario" class="marcar" type="checkbox" value="1" />
                                            <span class="lbl"> Configurar Usuário</span>
                                        </label>
                                    </td>

                                    <td>
                                        <label>
                                            <input <?php if (isset($permissoes['cEmitente'])) {
                                                if ($permissoes['cEmitente'] == '1') {
                                                    echo 'checked';
                                                }
}?> name="cEmitente" class="marcar" type="checkbox" value="1" />
                                            <span class="lbl"> Configurar Emitente</span>
                                        </label>
                                    </td>

                                    <td>
                                        <label>
                                            <input <?php if (isset($permissoes['cPermissao'])) {
                                                if ($permissoes['cPermissao'] == '1') {
                                                    echo 'checked';
                                                }
}?> name="cPermissao" class="marcar" type="checkbox" value="1" />
                                            <span class="lbl"> Configurar Permissão</span>
                                        </label>
                                    </td>

                                    <td>
                                        <label>
                                            <input <?php if (isset($permissoes['cBackup'])) { if ($permissoes['cBackup'] == '1') { echo 'checked'; } }?> name="cBackup" class="marcar" type="checkbox" value="1" />
                                            <span class="lbl"> Backup</span>
                                        </label>
                                    </td>
                                 
                                </tr>

                                <tr>
                                    <td colspan="2"></td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>

              
    
            <div class="form-actions">
                <div class="span12">
                    <div class="span6 offset3">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-sync-alt"></i> Atualizar</button>
                        <a href="<?php echo base_url() ?>index.php/permissoes" id="" class="btn"><i class="fas fa-backward"></i> Voltar</a>
                    </div>
                </div>
            </div>
           
            </div>
        </div>

                   
    </div>

</form>

</div>


<script type="text/javascript" src="<?php echo base_url()?>assets/js/validate.js"></script>
<script type="text/javascript">
    $(document).ready(function(){

    $("#marcarTodos").change(function () {
        $("input:checkbox").prop('checked', $(this).prop("checked"));
    });   

 
    $("#formPermissao").validate({
        rules :{
            nome: {required: true}
        },
        messages:{
            nome: {required: 'Campo obrigatório'}
        }
    });     

        

    });
</script>
