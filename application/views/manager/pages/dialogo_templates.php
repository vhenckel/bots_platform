         <br>
           <?php if(isset($templates) && count($templates) > 0){ ?>

                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">Lista de Templates</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <table id="listaDataTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th width="65%">Descrição</th>
                                        <th width="20%" class="text-right">Opções</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($templates as $template) { ?>
                                    <tr>
                                        <td class="text-left"><?=$template->nome;?></td>
                                        <td class="text-left"><?=$template->descricao;?></td>
                                        <td class="text-right">
                                            <a href="<?=base_url() . 'manager/dialogos/clonar/' . $template->dialogoID;?>" class="btn btn-warning" title="Clonar diálogo"><i class="fa fa-fw fa-clone"></i></a>
                                            <a href="<?=base_url() . 'manager/dialogos/configurar/' . $template->dialogoID;?>" class="btn btn-success" title="Configurar diálogo"><i class="fa fa-fw fa-gears"></i></a>
                                            <a href="<?=base_url() . 'manager/dialogos/novo/' . $template->dialogoID;?>" class="btn btn-info" title="Editar nome/categoria diálogo"><i class="fa fa-fw fa-edit"></i></a>
                                            <a href="<?=base_url() . 'manager/dialogos/excluirTemplate/' . $template->dialogoID;?>" onclick="return confirma_exclusao('<?=$template->nome;?>')" class="btn btn-danger <?=($template->dialogoID == 5) ? 'disabled' : '';?>" title="Excluir diálogo"><i class="fa fa-fw fa-close"></i></a></td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Nome</th>
                                        <th>Descrição</th>
                                        <th class="text-right">Opções</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

            <?php } ?>
        <br>
<!-- FIM CONTEUDO -->
<script>
    function confirma_exclusao(nome) {
        if (!confirm("Você deseja excluir este template: '" + nome + "'.")) {
            return false;
        }
        return true;
    }
</script>