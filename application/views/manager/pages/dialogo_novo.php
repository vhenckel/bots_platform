
        <br>
        <div class="row">
            <div class="col-md-6">
                <form action="<?=base_url() . 'manager/dialogos/gravar';?>" method="post">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Novo Diálogo</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="nome">Nome</label>
                                <input type="text" class="form-control" placeholder="Nome" id="nome" name="nome" value="<?=(isset($dialogoEditar)) ? $dialogoEditar->nome : '';?>" required>
                            </div>
                            <div class="form-group">
                                <label for="descricao">Descrição</label>
                                <textarea class="" name="descricao" id="descricao" placeholder="Digite aqui a descrição do template" style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?=(isset($dialogoEditar)) ? $dialogoEditar->descricao : ''?></textarea>
                            </div>
                            <div class="form-group">
                                <label>Segmento</label>
                                <select id="segmentoID" name="segmentoID" class="form-control" required>
                                    <option>SELECIONE...</option>
                                     <?php foreach ($segmentos as $segmento) { ?>
                                    <option value="<?=$segmento->segmentoID;?>" <?=(isset($dialogoEditar) && $dialogoEditar->segmentoID == $segmento->segmentoID) ? 'selected' : '';?>><?=$segmento->nome;?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <?php if (isset($dialogoEditar)) { ?>
                            <input type="hidden" id="dialogoID" name="dialogoID" value="<?=$dialogoEditar->dialogoID;?>">
                            <?php } ?>
                            <button type="submit" class="btn btn-primary pull-right">Gravar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <br>
