         <br>
           <?php if(isset($chatbots) && count($chatbots) > 0){ ?>

                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">Lista de Chatbots</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <table id="listaDataTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th width="20%">Cliente</th>
                                        <th width="20%">Unidade</th>
                                        <th width="10%">Setor</th>
                                        <th width="25%" class="text-right">Opções</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($chatbots as $bot) { ?>
                                    <tr>
                                        <td class="text-left"><?=$bot->titulo;?></td>
                                        <td class="text-left"><?=$bot->cliente;?></td>
                                        <td class="text-left"><?=$bot->unidade;?></td>
                                        <td class="text-left"><?=$bot->segmento;?></td>
                                        <td class="text-right">
                                            <?php //if ($bot->atendentes !== 0) { ?>
                                            <a href="<?=base_url() . 'p/' . $bot->hash;?>" target="_blank" title="Preview do Chat" type="button" class="btn btn-default <?=($bot->atendentes === 0) ? 'disabled' : '';?>"><i class="fa fa-fw fa-eye"></i></a>
                                            <?php //} ?>
                                            <a title="Pegar Script" type="button" class="btn btn-warning <?=($bot->atendentes === 0) ? 'disabled' : '';?>" data-toggle="modal" data-target="#myModal" onclick="return carregar('<?=$bot->titulo;?>','<?=$bot->hash;?>')"><i class="fa fa-fw fa-code"></i></a>
                                            <a href="<?=base_url() . 'manager/atendentes/' . $bot->chatbotID;?>" class="btn btn-<?=($bot->atendentes === 0) ? 'danger' : 'success';?>" title="Configurar atendentes"><i class="fa fa-fw fa-group"></i></a>
                                            <a href="<?=base_url() . 'manager/chatbots/adicionar/' . $bot->chatbotID;?>" class="btn btn-info" title="Editar Chatbot"><i class="fa fa-fw fa-edit"></i></a>
                                            <a href="<?=base_url() . 'manager/chatbots/excluir/' . $bot->chatbotID;?>" onclick="return confirma_exclusao('<?=$bot->titulo;?>')" class="btn btn-danger" title="Excluir Chatbot"><i class="fa fa-fw fa-close"></i></a></td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Nome</th>
                                        <th>Cliente</th>
                                        <th>Unidade</th>
                                        <th>Setor</th>
                                        <th class="text-right">Opções</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

            <?php } ?>
        <br>


        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel"></h4>
                    </div>
                    <div class="modal-body">
                        <div id="resposta">

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
<!-- FIM CONTEUDO -->
<script>
    function confirma_exclusao(nome) {
        if (!confirm("Você deseja excluir este chatbot: '" + nome + "'.")) {
            return false;
        }
        return true;
    }

    function carregar(titulo, hash) {
        $('#myModalLabel').html('Script do ChatBot: <strong>' + titulo + '</strong>');
        $('#resposta').html(
            '<textarea class="form-control" name="texto" rows="3"><script async src="https://chat.leadforce.com.br/ws/load/' + hash + '"><\/script></textarea>');
    }
</script>