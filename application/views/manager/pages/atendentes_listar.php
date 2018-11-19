         <br>
        <div class="row">
            <div class="col-md-6">
                <form action="<?=base_url() . 'manager/atendentes/gravar';?>" enctype="multipart/form-data" method="post">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Cadastro de Atendentes</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="nome">Nome</label>
                                <input type="text" class="form-control" placeholder="Nome" id="nome" name="nome" value="<?php if(isset($atendenteEditar->nome)) echo $atendenteEditar->nome;?>" required>
                            </div>

                            <div class="form-group">
                                <label for="funcao">Função</label>
                                <input type="text" class="form-control" placeholder="Função" id="funcao" name="funcao" value="<?php if(isset($atendenteEditar->funcao)) echo $atendenteEditar->funcao;?>" required>
                            </div>

                            <div class="form-group">
                                <?php if(!isset($atendenteEditar->avatar) || $atendenteEditar->avatar == '') { ?>
                                <div class="form-group">
                                    <label for="avatar">Avatar</label>
                                    <input type="file" id="avatar" name="avatar">
                                </div>
                                <?php } else { ?>
                                <div class="form-group">
                                    <label for="files">Avatar</label>
                                    <a href="<?=base_url() . 'manager/atendentes/excluiravatar/' . $atendenteEditar->atendenteID . '/' . $atendenteEditar->chatbotID;?>" onclick="return confirma_exclusao('<?=$atendenteEditar->avatar;?>')">
                                        <img class="img-responsive pad" src="<?=base_url() . 'assets/chat-' . $hash . '/' . $atendenteEditar->avatar;?>" alt="Photo" width="150">
                                    </a>
                                    <p class="help-block">Clique na imagem para deletar</p>
                                    <input type="hidden" id="avatar" name="avatar" value="<?=$atendenteEditar->avatar;?>">

                                </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" id="chatbotID" name="chatbotID" value="<?=$chatbotID;?>">
                            <input type="hidden" id="hash" name="hash" value="<?=$hash;?>">
                            <?php if (isset($atendenteEditar)) { ?>
                            <input type="hidden" id="atendenteID" name="atendenteID" value="<?=$atendenteEditar->atendenteID;?>">
                            <a href="<?=base_url() . 'manager/atendentes/' . $chatbotID;?>" class="btn btn-default pull-left"">Cancelar</a>
                            <?php } ?>
                            <button type="submit" class="btn btn-primary pull-right">Gravar</button>
                        </div>
                    </div>
                </form>
            </div>

            <?php if($atendentes && count($atendentes) > 0){ ?>
            <div class="col-md-6">
                <div class="row">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">Listagem de Atendentes</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <table id="listaDataTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th width="10%">Avatar</th>
                                        <th>Nome</th>
                                        <th>Função</th>
                                        <th width="25%" class="text-right">Opções</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($atendentes as $atendente) { ?>
                                    <tr>
                                        <td class="text-center">
                                            <?php if (isset($atendente->avatar) && $atendente->avatar != '') { ?>
                                            <img src="<?=base_url() . 'assets/chat-' . $hash . '/' . $atendente->avatar;?>" height="40px">
                                            <?php } else { echo ' - ';} ?>
                                        </td>
                                        <td class="text-left"><?=$atendente->nome;?></td>
                                        <td class="text-left"><?=$atendente->funcao;?></td>
                                        <td class="text-right">
                                            <a href="<?=base_url() . 'manager/atendentes/' . $chatbotID . '/' . $atendente->atendenteID;?>" class="btn btn-info"><i class="fa fa-fw fa-edit"></i></a>
                                            <a href="<?=base_url() . 'manager/atendentes/excluir/' . $chatbotID . '/' . $atendente->atendenteID;?>" onclick="return confirma_exclusao('<?=$atendente->nome;?>')" class="btn btn-danger"><i class="fa fa-fw fa-close"></i></a></td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Avatar</th>
                                        <th>Nome</th>
                                        <th>Função</th>
                                        <th class="text-right">Opções</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
        <br>
<!-- FIM CONTEUDO -->
<script>
    function confirma_exclusao(nome) {
        if (!confirm("Você deseja excluir este atendente: '" + nome + "'.")) {
            return false;
        }
        return true;
    }
</script>