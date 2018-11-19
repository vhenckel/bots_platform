         <br>
        <div class="row">
            <div class="col-md-6">
                <form action="<?=base_url() . 'manager/usuarios/gravar';?>" method="post" autocomplete="false">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Cadastro de Usuários</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="nome">Nome</label>
                                <input type="text" class="form-control" placeholder="Nome" id="nome" name="nome" value="<?php if(isset($usuarioEditar->nome)) echo $usuarioEditar->nome;?>" required>
                            </div>
                            <div class="form-group">
                                <label for="usuario">Usuário</label>
                                <input type="text" class="form-control" placeholder="Usuário" id="usuario" name="usuario" value="<?php if(isset($usuarioEditar->usuario)) echo $usuarioEditar->usuario;?>" required>
                            </div>
                            <div class="form-group">
                                <label for="senha">Senha</label>
                                <input type="password" class="form-control" placeholder="Senha" id="senha" name="senha" value="" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <?php if (isset($usuarioEditar)) { ?>
                            <input type="hidden" id="usuarioID" name="usuarioID" value="<?=$usuarioEditar->usuarioID;?>">
                            <a href="<?=base_url() . 'manager/usuarios/';?>" class="btn btn-default pull-left"">Cancelar</a>
                            <?php } ?>
                            <button type="submit" class="btn btn-primary pull-right">Gravar</button>
                        </div>
                    </div>
                </form>
            </div>

            <?php if($usuarios && count($usuarios) > 0){ ?>
            <div class="col-md-6">
                <div class="row">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">Listagem de usuários</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <table id="listaDataTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th>Usuário</th>
                                        <th width="20%" class="text-right">Opções</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($usuarios as $usuario) { ?>
                                    <tr>
                                        <td class="text-left"><?=$usuario->nome;?></td>
                                        <td class="text-left"><?=$usuario->usuario;?></td>
                                        <td class="text-right">
                                            <a href="<?=base_url() . 'manager/usuarios/' . $usuario->usuarioID;?>" class="btn btn-info"><i class="fa fa-fw fa-edit"></i></a>
                                            <a href="<?=base_url() . 'manager/usuarios/excluir/' . $usuario->usuarioID;?>" onclick="return confirma_exclusao('<?=$usuario->nome;?>')" class="btn btn-danger"><i class="fa fa-fw fa-close"></i></a></td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Nome</th>
                                        <th>Usuário</th>
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
        if (!confirm("Você deseja excluir este usuário: '" + nome + "'.")) {
            return false;
        }
        return true;
    }
</script>