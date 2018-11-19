         <br>
        <div class="row">
            <div class="col-md-6">
                <form action="<?=base_url() . 'manager/segmentos/gravar';?>" method="post">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Cadastro de Segmentos</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="nome">Nome</label>
                                <input type="text" class="form-control" placeholder="Nome" id="nome" name="nome" value="<?php if(isset($segmentoEditar->nome)) echo $segmentoEditar->nome;?>" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <?php if (isset($segmentoEditar)) { ?>
                            <input type="hidden" id="segmentoID" name="segmentoID" value="<?=$segmentoEditar->segmentoID;?>">
                            <a href="<?=base_url() . 'manager/segmentos/novo';?>" class="btn btn-default pull-left"">Cancelar</a>
                            <?php } ?>
                            <button type="submit" class="btn btn-primary pull-right">Gravar</button>
                        </div>
                    </div>
                </form>
            </div>

            <?php if($segmentos && count($segmentos) > 0){ ?>
            <div class="col-md-6">
                <div class="row">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">Listagem de Segmentos</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <table id="listaDataTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th width="20%" class="text-right">Opções</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($segmentos as $segmento) { ?>
                                    <tr>
                                        <td class="text-left"><?=$segmento->nome;?></td>
                                        <td class="text-right">
                                            <a href="<?=base_url() . 'manager/segmentos/' . $segmento->segmentoID;?>" class="btn btn-info"><i class="fa fa-fw fa-edit"></i></a>
                                            <a href="<?=base_url() . 'manager/segmentos/excluir/' . $segmento->segmentoID;?>" onclick="return confirma_exclusao('<?=$segmento->nome;?>')" class="btn btn-danger"><i class="fa fa-fw fa-close"></i></a></td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Nome</th>
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
        if (!confirm("Você deseja excluir este segmento: '" + nome + "'.")) {
            return false;
        }
        return true;
    }
</script>