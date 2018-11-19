        <br>
        <div class="row">
            <div class="col-md-8">
                <form action="<?=base_url() . 'manager/chatbots/gravar';?>" enctype="multipart/form-data" method="post">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Cadastro de ChatBot</h4>
                        </div>
                        <div class="modal-body">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Título</label>
                                        <input type="text" class="form-control" placeholder="Título" id="titulo" name="titulo" value="<?php if(isset($chatEditar->titulo)) echo $chatEditar->titulo;?>" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Cliente</label>
                                        <select id="clienteID" name="clienteID" class="form-control" required>
                                            <option>SELECIONE...</option>
                                             <?php foreach ($clientes as $cliente) { ?>
                                            <option value="<?=$cliente['ID'];?>" <?=(isset($chatEditar) && $chatEditar->clienteID == $cliente['ID']) ? 'selected' : '';?>><?=$cliente['NOME'];?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Unidade</label>
                                        <select id="unidade" name="unidade" class="form-control" required>
                                            <?php
                                            if (isset($chatEditar)) {
                                                echo '<option value="Todas">Todas</option>';
                                                foreach ($unidades as $unidade) {
                                            ?>
                                            <option value="<?=$unidade->NOME;?>" <?=($unidade->NOME == $chatEditar->unidade) ? 'selected' : '';?>><?=$unidade->NOME;?></option>
                                            <?php
                                                }
                                            } else { ?>
                                            <option>SELECIONE O CLIENTE...</option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Diálogo</label>
                                        <select id="dialogoID" name="dialogoID" class="form-control" required>
                                            <option>SELECIONE...</option>
                                             <?php foreach ($dialogos as $dialogo) { ?>
                                            <option value="<?=$dialogo->dialogoID;?>" id="<?=$dialogo->dialogoID;?>" class="<?=$dialogo->segmentoID;?>" <?=(isset($chatEditar) && $chatEditar->dialogoID == $dialogo->dialogoID) ? 'selected' : '';?>><?=$dialogo->nome;?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div id="marca-veiculos" class="form-group <?=(isset($chatEditar) && $chatEditar->marcaVeiculos != NULL) ? '' : 'hidden';?>">
                                        <label>Marca dos veículos</label>
                                        <select id="marcaVeiculos" name="marcaVeiculos" class="form-control select2" multiple="marcaVeiculos" style="width: 100%;">
                                            <option>SELECIONE...</option>
                                             <?php foreach ($marcas as $marca) { ?>
                                            <option value="<?=$marca['ID'];?>" <?=(isset($chatEditar) && $chatEditar->marcaVeiculos == $marca['ID']) ? 'selected' : '';?>><?=strtoupper($marca['TITULO']);?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Cor Principal</label>
                                        <div class="input-group my-colorpicker2 colorpicker-element">
                                            <input type="text" class="form-control" id="bgPrincipal" name="bgPrincipal" value="<?=(isset($chatEditar->bgPrincipal)) ? $chatEditar->bgPrincipal : '#000';?>" required>
                                            <div class="input-group-addon"> <i style="background-color: <?=(isset($chatEditar->bgPrincipal)) ? isset($chatEditar->bgPrincipal) : '#000' ;?>;"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Posição do Chat</label>
                                        <select id="posicao" name="posicao" class="form-control select2" multiple="posicao" style="width: 100%;" required>
                                            <option>SELECIONE...</option>
                                            <option value="1" <?=(isset($chatEditar) && $chatEditar->posicao == 1) ? 'selected' : '';?>>Esquerda</option>
                                            <option value="2" <?=(isset($chatEditar) && $chatEditar->posicao == 2) ? 'selected' : '';?>>Direita</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Abertura do Chat</label>
                                        <input type="number" min="0" max="30" step="1" class="form-control" id="start" name="start" value="<?=(isset($chatEditar->start)) ? ($chatEditar->start / 1000) : '0';?>" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Cor Secundária</label>
                                        <div class="input-group my-colorpicker2 colorpicker-element">
                                            <input type="text" class="form-control" id="bgSecundario" name="bgSecundario" value="<?=(isset($chatEditar->bgSecundario)) ? $chatEditar->bgSecundario : '#000';?>" required>
                                            <div class="input-group-addon"> <i style="background-color: <?=(isset($chatEditar->bgSecundario)) ? isset($chatEditar->bgSecundario) : '#000' ;?>;"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Cor da Fonte Secundária</label>
                                        <div class="input-group my-colorpicker2 colorpicker-element">
                                            <input type="text" class="form-control" id="bgSecundarioFonte" name="bgSecundarioFonte" value="<?=(isset($chatEditar->bgSecundarioFonte)) ? $chatEditar->bgSecundarioFonte : '#000';?>" required>
                                            <div class="input-group-addon"> <i style="background-color: <?=(isset($chatEditar->bgSecundarioFonte)) ? isset($chatEditar->bgSecundarioFonte) : '#000' ;?>;"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Cor do CTA (botões)</label>
                                        <div class="input-group my-colorpicker2 colorpicker-element">
                                            <input type="text" class="form-control" id="bgCTA" name="bgCTA" value="<?=(isset($chatEditar->bgCTA)) ? $chatEditar->bgCTA : '#000';?>" required>
                                            <div class="input-group-addon"> <i style="background-color: <?=(isset($chatEditar->bgCTA)) ? isset($chatEditar->bgCTA) : '#000' ;?>;"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Cor da Fonte do CTA (botões)</label>
                                        <div class="input-group my-colorpicker2 colorpicker-element">
                                            <input type="text" class="form-control" id="bgCTAFonte" name="bgCTAFonte" value="<?=(isset($chatEditar->bgCTAFonte)) ? $chatEditar->bgCTAFonte : '#000';?>" required>
                                            <div class="input-group-addon"> <i style="background-color: <?=(isset($chatEditar->bgCTAFonte)) ? isset($chatEditar->bgCTAFonte) : '#000' ;?>;"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>5 - Cor dos ícones</label>
                                        <div class="input-group my-colorpicker2 colorpicker-element">
                                            <input type="text" class="form-control" id="bgIcones" name="bgIcones" value="<?=(isset($chatEditar->bgIcones)) ? $chatEditar->bgIcones : '#000';?>" required>
                                            <div class="input-group-addon"> <i style="background-color: <?=(isset($chatEditar->bgIcones)) ? isset($chatEditar->bgIcones) : '#000' ;?>;"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <?php if(!isset($chatEditar->logoCliente) || $chatEditar->logoCliente == '') { ?>
                                    <div class="form-group">
                                        <label for="logoCliente">6 - Logo do cliente</label>
                                        <input type="file" id="logoCliente" name="logoCliente">
                                    </div>
                                    <?php } else { ?>
                                    <div class="form-group">
                                        <label for="files">6 - Logo do cliente</label>
                                        <a href="<?=base_url() . 'manager/chatbots/excluirImg/1/' . $chatEditar->chatbotID;?>" onclick="return confirma_exclusao('<?=$chatEditar->logoCliente;?>')">
                                            <img class="img-responsive pad" src="<?=base_url() . 'assets/chat-' . $chatEditar->hash . '/' . $chatEditar->logoCliente . '?' . date('im');?>" alt="Photo" width="150">
                                        </a>
                                        <p class="help-block">Clique na imagem para deletar</p>
                                        <input type="hidden" id="logoCliente" name="logoCliente" value="<?=$chatEditar->logoCliente;?>">

                                    </div>
                                    <?php } ?>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <?php if(!isset($chatEditar->imgIniciar) || $chatEditar->imgIniciar == '') { ?>
                                    <div class="form-group">
                                        <label for="imgIniciar">Imagem Iniciar</label>
                                        <input type="file" id="imgIniciar" name="imgIniciar">
                                    </div>
                                    <?php } else { ?>
                                    <div class="form-group">
                                        <label for="files">Imagem Iniciar</label>
                                        <a href="<?=base_url() . 'manager/chatbots/excluirImg/2/' . $chatEditar->chatbotID;?>" onclick="return confirma_exclusao('<?=$chatEditar->imgIniciar;?>')">
                                            <img class="img-responsive pad" src="<?=base_url() . 'assets/chat-' . $chatEditar->hash . '/' . $chatEditar->imgIniciar . '?' . date('im');?>" alt="Photo" width="150">
                                        </a>
                                        <p class="help-block">Clique na imagem para deletar</p>
                                        <input type="hidden" id="imgIniciar" name="imgIniciar" value="<?=$chatEditar->imgIniciar;?>">

                                    </div>
                                    <?php } ?>
                                </div>

                                <div class="col-md-6">
                                    <?php if(!isset($chatEditar->imgIniciarMobile) || $chatEditar->imgIniciarMobile == '') { ?>
                                    <div class="form-group">
                                        <label for="imgIniciarMobile">Imagem Iniciar Mobile</label>
                                        <input type="file" id="imgIniciarMobile" name="imgIniciarMobile">
                                    </div>
                                    <?php } else { ?>
                                    <div class="form-group">
                                        <label for="files">Imagem Iniciar Mobile</label>
                                        <a href="<?=base_url() . 'manager/chatbots/excluirImg/3/' . $chatEditar->chatbotID;?>" onclick="return confirma_exclusao('<?=$chatEditar->imgIniciarMobile;?>')">
                                            <img class="img-responsive pad" src="<?=base_url() . 'assets/chat-' . $chatEditar->hash . '/' . $chatEditar->imgIniciarMobile . '?' . date('im');?>" alt="Photo" width="150">
                                        </a>
                                        <p class="help-block">Clique na imagem para deletar</p>
                                        <input type="hidden" id="imgIniciarMobile" name="imgIniciarMobile" value="<?=$chatEditar->imgIniciarMobile;?>">

                                    </div>
                                    <?php } ?>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <label>Formulário do Lead</label>
                                    <select id="formulario" name="formulario" class="form-control" required>
                                        <option>SELECIONE...</option>
                                        <option value="0" <?=(isset($chatEditar) && $chatEditar->formulario == 0) ? 'selected' : '';?>>NÃO</option>
                                        <option value="1" <?=(isset($chatEditar) && $chatEditar->formulario == 1) ? 'selected' : '';?>>SIM</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Token da Captação</label>
                                        <input type="text" class="form-control" placeholder="Token" id="token" name="token" value="<?php if(isset($chatEditar->token)) echo $chatEditar->token;?>" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="chamada" class="form-group <?=(isset($chatEditar) && $chatEditar->formulario != 0) ? '' : 'hidden';?>">
                                        <label>7 - Chamada principal</label>
                                        <input type="text" class="form-control" placeholder="Chamada principal" id="chamadaPrincipal" name="chamadaPrincipal" value="<?php if(isset($chatEditar->chamadaPrincipal)) echo $chatEditar->chamadaPrincipal;?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <?php if (isset($chatEditar->chatbotID)) { ?>
                            <input type="hidden" id="chatbotID" name="chatbotID" value="<?=$chatEditar->chatbotID;?>">
                            <a href="<?=base_url() . 'manager/chatbots/';?>" class="btn btn-default  pull-left">Voltar</a>
                            <?php } ?>
                            <button type="submit" class="btn btn-primary pull-right">Gravar</button>
                        </div>
                    </div>
                </form>
            </div>


            <div class="col-md-4">
                <img src="<?=base_url() . 'assetsAdmin/dist/img/chat-template.png';?>">
            </div>
        </div>
<script>
    function confirma_exclusao(nome) {
        if (!confirm("Você deseja excluir a imagem: '" + nome + "'.")) {
            return false;
        }
        return true;
    }
</script>