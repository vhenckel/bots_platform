         <br>
        <div class="row">
            <div class="col-md-6">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Blocos do Fluxo: <strong><?=$dialogo->nome;?></strong></h4>
                    </div>
                    <div class="modal-body" id="blocks">
                        <?php
                        $existe_bloco_veiculos = FALSE;
                        $existe_bloco_lojas    = FALSE;
                        foreach ($blocos as $bloco) {
                            if ($bloco->tipoID == 5) {
                                $existe_bloco_veiculos = TRUE;
                            } else if ($bloco->tipoID == 4) {
                                $existe_bloco_lojas = TRUE;
                            }
                        ?>
                        <button type="button" class="btn btn-<?=(isset($bloco->erro)) ? 'danger' : 'primary';?> btn-chatblock" id="<?=$bloco->nome;?>" style="margin:3px;"><?=$bloco->nome;?></button>
                        <?php } // Fecha Foreach ?>
                        <button type="button" class="btn btn-default" id="add_block" style="margin:3px;">+ Adicionar Bloco</button>
                        <?php if ($dialogo->segmentoID == 1) { ?>
                            <?php if (!$existe_bloco_veiculos) { ?>
                            <button type="button" class="btn btn-info" id="add_block_model" style="margin:3px;"><i class="fa fa-car"></i> Bloco Modelos</button>
                            <?php } // Fecha IF $existe_bloco_veiculos s?>
                            <?php if (!$existe_bloco_lojas) { ?>
                            <button type="button" class="btn btn-info" id="add_block_shop" style="margin:3px;"><i class="fa fa-shopping-cart"></i> Bloco Lojas</button>
                            <?php } // Fecha IF $existe_bloco_lojas ?>
                        <?php } // Fecha IF $dialogo->segmentoID ?>
                    </div>
                </div>
            </div>
            <div class="col-md-6" id="block-full">
                <?php foreach ($blocos as $bloco) { ?>
                <div id="block-<?=$bloco->nome;?>" class="hidden">
                    <div class="modal-content">
                        <div class="modal-header">
                            <span class="h4 modal-title"><?=$bloco->nome;?></span>
                            <?php if ($bloco->nome !== 'MensagemInicial') { ?>
                            <span class="pull-right"><a href="<?=base_url() . 'manager/dialogos/deletaBloco/' . $dialogoID . '/' . $bloco->blocoID;?>" title="Deletar bloco"><i class="fa fa-trash"></i></a></span>
                            <?php } ?>
                        </div>
                        <div class="modal-body">
                            <?php if ($bloco->tipoID == 4) { ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <form action="<?=base_url() . 'manager/dialogos/gravarFluxo';?>" method="post">
                                       <?php
                                         if ($bloco->tipoID == 4 && $bloco->bloco_conteudo != '') {
                                            $conteudo = json_decode($bloco->bloco_conteudo);
                                            $texto = $conteudo->texto;
                                            $proximo_bloco = $conteudo->proximo_bloco;
                                        }
                                        ?>
                                        <input type="hidden" id="blocoID" name="blocoID" value="<?=$bloco->blocoID;?>">
                                        <input type="hidden" id="tipoID" name="tipoID" value="<?=$bloco->tipoID;?>">
                                        <input type="hidden" id="dialogoID" name="dialogoID" value="<?=$dialogoID;?>">
                                        <input type="hidden" id="identificador" name="identificador" value="unidade">
                                        <div class="form-group">
                                            <label>Texto:</label>
                                            <textarea class="form-control" name="texto" rows="3" placeholder="Digite aqui seu texto..."><?=(isset($texto)) ? $texto : '';?></textarea>
                                        </div>
                                        <div class="form-group">

                                            <label>Próximo bloco:</label>
                                            <select id="bloco_posterior" name="bloco_posterior" class="form-control select2" multiple="bloco_posterior" style="width: 100%;" >
                                                <option>SELECIONE...</option>
                                                <?php
                                                foreach ($blocos_posteriores as $bloco_posterior) {
                                                    if ($bloco_posterior->blocoID != $bloco->blocoID) {
                                                ?>
                                                <option value="<?=$bloco_posterior->blocoID;?>" <?=(isset($proximo_bloco) && $proximo_bloco == $bloco_posterior->blocoID) ? 'selected' : '';?>><?=$bloco_posterior->nome;?></option>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </select>

                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary pull-right">Gravar</button>
                                        </div>
                                        <br>
                                        <hr>
                                        <h6><b>O que é:</b></h6>
                                        <h6>Nesta opção o sistema envia seu texto e todas as lojas cadastradas em uma lista, o campo de digitação ficará desabilitado e o usuário será forçado a selecionar uma opção para continuar.</h6>
                                        <?php
                                        unset($texto);
                                        unset($proximo_bloco);
                                        ?>
                                    </form>
                                </div>
                            </div>
                            <?php } else if ($bloco->tipoID == 5) { ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <form action="<?=base_url() . 'manager/dialogos/gravarFluxo';?>" method="post">
                                       <?php
                                         if ($bloco->tipoID == 5 && $bloco->bloco_conteudo != '') {
                                            $conteudo = json_decode($bloco->bloco_conteudo);
                                            $texto = $conteudo->texto;
                                            // $marca_veiculos = $conteudo->marca;
                                            $proximo_bloco = $conteudo->proximo_bloco;
                                        }
                                        ?>
                                        <input type="hidden" id="blocoID" name="blocoID" value="<?=$bloco->blocoID;?>">
                                        <input type="hidden" id="tipoID" name="tipoID" value="<?=$bloco->tipoID;?>">
                                        <input type="hidden" id="dialogoID" name="dialogoID" value="<?=$dialogoID;?>">
                                        <input type="hidden" id="identificador" name="identificador" value="modelo">
                                        <div class="form-group">
                                            <label>Texto:</label>
                                            <textarea class="form-control" name="texto" rows="3" placeholder="Digite aqui seu texto..."><?=(isset($texto)) ? $texto : '';?></textarea>
                                        </div>
                                        <div class="form-group">

                                            <label>Próximo bloco:</label>
                                            <select id="bloco_posterior" name="bloco_posterior" class="form-control select2" multiple="bloco_posterior" style="width: 100%;" >
                                                <option>SELECIONE...</option>
                                                <?php
                                                foreach ($blocos_posteriores as $bloco_posterior) {
                                                    if ($bloco_posterior->blocoID != $bloco->blocoID) {
                                                ?>
                                                <option value="<?=$bloco_posterior->blocoID;?>" <?=(isset($proximo_bloco) && $proximo_bloco == $bloco_posterior->blocoID) ? 'selected' : '';?>><?=$bloco_posterior->nome;?></option>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </select>

                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary pull-right">Gravar</button>
                                        </div>
                                        <br>
                                        <hr>
                                        <h6><b>O que é:</b></h6>
                                        <h6>Nesta opção o sistema envia seu texto e todos os veículos da marca escolhida em uma lista, o campo de digitação ficará desabilitado e o usuário será forçado a selecionar uma opção para continuar.</h6>
                                        <?php
                                        unset($texto);
                                        unset($proximo_bloco);
                                        ?>
                                    </form>
                                </div>
                            </div>
                            <?php } else { ?>
                            <div class="nav-tabs-custom">
                                <ul class="nav nav-tabs pull-right">
                                    <?php if ($bloco->nome != 'MensagemInicial') { ?>
                                    <li <?=($bloco->tipoID == 3) ? 'class="active"' : '';?>>
                                        <a href="#tab_1-1-<?=$bloco->blocoID;?>" data-toggle="tab">Enviar opções</a>
                                    </li>
                                    <li <?=($bloco->tipoID == 2) ? 'class="active"' : '';?>>
                                        <a href="#tab_2-2-<?=$bloco->blocoID;?>" data-toggle="tab">Resposta Livre</a>
                                    </li>
                                    <?php } ?>
                                    <li <?=($bloco->tipoID == 1 || !isset($bloco->tipoID)) ? 'class="active"' : '';?>>
                                        <a href="#tab_3-2-<?=$bloco->blocoID;?>" data-toggle="tab">Texto</a>
                                    </li>
                                    <li class="pull-left header"> <i class="fa fa-commenting-o"></i>
                                        Escolha o tipo:
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane <?=($bloco->tipoID == 3) ? 'active' : '';?>" id="tab_1-1-<?=$bloco->blocoID;?>">
                                        <form action="<?=base_url() . 'manager/dialogos/gravarFluxo';?>" method="post">
                                            <?php
                                             if ($bloco->tipoID == 3 && $bloco->bloco_conteudo != '') {
                                                $conteudo      = json_decode($bloco->bloco_conteudo);
                                                $texto_opcoes  = $conteudo->texto;
                                                $opcoes        = $conteudo->respostas;
                                            }
                                            ?>
                                            <input type="hidden" id="blocoID" name="blocoID" value="<?=$bloco->blocoID;?>">
                                            <input type="hidden" id="tipoID" name="tipoID" value="3">
                                            <input type="hidden" id="dialogoID" name="dialogoID" value="<?=$dialogoID;?>">
                                            <div class="form-group">
                                                <label>Texto:</label>
                                                <textarea class="form-control" name="texto_opcoes" rows="3" placeholder="Digite aqui seu texto..."><?=(isset($texto_opcoes)) ? $texto_opcoes : '';?></textarea>
                                                <p class="text-muted"><h6>* Personalizar: {nome_atendente}</h6></p>
                                            </div>
                                            <div class="form-group">
                                                <label>Identificador do Bloco:</label>
                                                <select id="identificador" name="identificador" class="form-control select2" multiple="identificador" style="width: 100%;" >
                                                    <option>SELECIONE...</option>
                                                    <option value="email" <?=(isset($conteudo->identificador) && $conteudo->identificador == 'email') ? 'selected' : '';?>>Email</option>
                                                    <option value="modelo" <?=(isset($conteudo->identificador) && $conteudo->identificador == 'modelo') ? 'selected' : '';?>>Modelo</option>
                                                    <option value="nome" <?=(isset($conteudo->identificador) && $conteudo->identificador == 'nome') ? 'selected' : '';?>>Nome</option>
                                                    <option value="setor" <?=(isset($conteudo->identificador) && $conteudo->identificador == 'setor') ? 'selected' : '';?>>Setor</option>
                                                    <option value="telefone" <?=(isset($conteudo->identificador) && $conteudo->identificador == 'telefone') ? 'selected' : '';?>>Telefone</option>
                                                    <option value="unidade" <?=(isset($conteudo->identificador) && $conteudo->identificador == 'unidade') ? 'selected' : '';?>>Unidade</option>
                                                </select>
                                            </div>
                                            <span class="linhas">
                                                <div class="row linha_opcoes">
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <label>Opção:</label>
                                                            <input type="text" class="form-control" placeholder="Opção" id="opcoes[]" name="opcoes[]" required value="<?=(isset($opcoes[0]->texto)) ? $opcoes[0]->texto : '';?>">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label>Próximo bloco:</label>
                                                        <select name="bloco_posterior[]" class="form-control select2" multiple="bloco_posterior[]" style="width: 100%;" >
                                                            <option>SELECIONE...</option>
                                                            <?php
                                                            foreach ($blocos_posteriores as $bloco_posterior) {
                                                                if ($bloco_posterior->blocoID != $bloco->blocoID) {
                                                            ?>
                                                            <option value="<?=$bloco_posterior->blocoID;?>" <?=(isset($opcoes[0]->proximo_bloco) && $opcoes[0]->proximo_bloco == $bloco_posterior->blocoID) ? 'selected' : '';?>><?=$bloco_posterior->nome;?></option>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row conteudo">
                                                    <?php
                                                    if (isset($opcoes)) {
                                                        foreach ($opcoes as $opcao) {
                                                            if ($opcao->texto != $opcoes[0]->texto) {
                                                    ?>
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <label>Opção:</label>
                                                            <input type="text" class="form-control" placeholder="Opção" id="opcoes[]" name="opcoes[]"  value="<?=(isset($opcao->texto)) ? $opcao->texto : '';?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Próximo bloco:</label>
                                                        <select name="bloco_posterior[]" class="form-control select2" multiple="bloco_posterior[]" style="width: 100%;" >
                                                            <option>SELECIONE...</option>
                                                            <?php
                                                            foreach ($blocos_posteriores as $bloco_posterior) {
                                                                if ($bloco_posterior->blocoID != $bloco->blocoID) {
                                                            ?>
                                                            <option value="<?=$bloco_posterior->blocoID;?>" <?=(isset($opcao->proximo_bloco) && $opcao->proximo_bloco == $bloco_posterior->blocoID) ? 'selected' : '';?>><?=$bloco_posterior->nome;?></option>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <?php
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <button type="button" class="btn btn-success btn_opcoes pull-left" > <i class="fa fa-plus"></i> Adicionar opções</button>
                                                    </div>
                                                </div>
                                            </span>
                                            <div class="form-group">

                                                <button type="submit" class="btn btn-primary pull-right">Gravar</button>
                                            </div>
                                            <br>
                                            <hr>
                                            <h6><b>O que é:</b></h6>
                                            <h6>Nesta opção o sistema envia seu texto e as opções de resposta em uma lista, o campo de digitação ficará desabilitado e o usuário será forçado a selecionar uma opção para continuar.</h6>
                                            <?php
                                            unset($texto_opcoes);
                                            unset($proximo_bloco);
                                            unset($opcoes);
                                            unset($conteudo->identificador);
                                            unset($opcao->texto);
                                            ?>
                                        </form>
                                    </div>
                                    <div class="tab-pane <?=($bloco->tipoID == 2) ? 'active' : '';?>" id="tab_2-2-<?=$bloco->blocoID;?>">
                                        <form action="<?=base_url() . 'manager/dialogos/gravarFluxo';?>" method="post">
                                            <?php
                                             if ($bloco->tipoID == 2 && $bloco->bloco_conteudo != '') {
                                                $conteudo = json_decode($bloco->bloco_conteudo);
                                                $texto_livre = $conteudo->texto;
                                                $proximo_bloco = $conteudo->proximo_bloco;
                                            }
                                            ?>
                                            <input type="hidden" id="blocoID" name="blocoID" value="<?=$bloco->blocoID;?>">
                                            <input type="hidden" id="tipoID" name="tipoID" value="2">
                                            <input type="hidden" id="dialogoID" name="dialogoID" value="<?=$dialogoID;?>">
                                            <div class="form-group">
                                                <label>Texto:</label>
                                                <textarea class="form-control" name="texto_livre" rows="3" placeholder="Digite aqui seu texto..."><?=(isset($texto_livre)) ? $texto_livre : '';?></textarea>
                                                <p class="text-muted"><h6>* Personalizar: {nome_atendente}</h6></p>
                                            </div>
                                            <div class="form-group">
                                                <label>Identificador do Bloco:</label>
                                                <select id="identificador" name="identificador" class="form-control select2" multiple="identificador" style="width: 100%;" >
                                                    <option>SELECIONE...</option>
                                                    <option value="email" <?=(isset($conteudo->identificador) && $conteudo->identificador == 'email') ? 'selected' : '';?>>Email</option>
                                                    <option value="modelo" <?=(isset($conteudo->identificador) && $conteudo->identificador == 'modelo') ? 'selected' : '';?>>Modelo</option>
                                                    <option value="nome" <?=(isset($conteudo->identificador) && $conteudo->identificador == 'nome') ? 'selected' : '';?>>Nome</option>
                                                    <option value="telefone" <?=(isset($conteudo->identificador) && $conteudo->identificador == 'telefone') ? 'selected' : '';?>>Telefone</option>
                                                    <option value="unidade" <?=(isset($conteudo->identificador) && $conteudo->identificador == 'unidade') ? 'selected' : '';?>>Unidade</option>
                                                </select>
                                            </div>
                                            <div class="form-group">

                                                <label>Próximo bloco:</label>
                                                <select id="bloco_posterior" name="bloco_posterior" class="form-control select2" multiple="bloco_posterior" style="width: 100%;" >
                                                    <option>SELECIONE...</option>
                                                    <?php
                                                    foreach ($blocos_posteriores as $bloco_posterior) {
                                                        if ($bloco_posterior->blocoID != $bloco->blocoID) {
                                                    ?>
                                                    <option value="<?=$bloco_posterior->blocoID;?>" <?=(isset($proximo_bloco) && $proximo_bloco == $bloco_posterior->blocoID) ? 'selected' : '';?>><?=$bloco_posterior->nome;?></option>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>

                                            </div>
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary pull-right">Gravar</button>
                                            </div>
                                            <br>
                                            <hr>
                                            <h6><b>O que é:</b></h6>
                                            <h6>Nesta opção o sistema envia seu texto e habilita o campo de digitação para que o usuário o preencha com o que for pedido.</h6>
                                            <?php
                                            unset($texto_livre);
                                            unset($proximo_bloco);
                                            ?>
                                        </form>
                                    </div>
                                    <div class="tab-pane <?=($bloco->tipoID == 1 || !isset($bloco->tipoID)) ? 'active' : '';?>" id="tab_3-2-<?=$bloco->blocoID;?>">
                                        <form action="<?=base_url() . 'manager/dialogos/gravarFluxo';?>" method="post">
                                           <?php
                                             if ($bloco->tipoID == 1 && $bloco->bloco_conteudo != '') {
                                                $conteudo = json_decode($bloco->bloco_conteudo);
                                                $texto = $conteudo->texto;
                                                $proximo_bloco = $conteudo->proximo_bloco;
                                            }
                                            ?>
                                            <input type="hidden" id="blocoID" name="blocoID" value="<?=$bloco->blocoID;?>">
                                            <input type="hidden" id="tipoID" name="tipoID" value="1">
                                            <input type="hidden" id="dialogoID" name="dialogoID" value="<?=$dialogoID;?>">
                                            <div class="form-group">
                                                <label>Texto:</label>
                                                <textarea class="form-control" name="texto" rows="3" placeholder="Digite aqui seu texto..."><?=(isset($texto)) ? $texto : '';?></textarea>
                                                <p class="text-muted"><h6>* Personalizar: {nome_atendente}</h6></p>
                                            </div>
                                            <div class="form-group">
                                                <label>Identificador do Bloco:</label>
                                                <select id="identificador" name="identificador" class="form-control select2" multiple="identificador" style="width: 100%;" >
                                                    <option>SELECIONE...</option>
                                                    <option value="email" <?=(isset($conteudo->identificador) && $conteudo->identificador == 'email') ? 'selected' : '';?>>Email</option>
                                                    <option value="modelo" <?=(isset($conteudo->identificador) && $conteudo->identificador == 'modelo') ? 'selected' : '';?>>Modelo</option>
                                                    <option value="nome" <?=(isset($conteudo->identificador) && $conteudo->identificador == 'nome') ? 'selected' : '';?>>Nome</option>
                                                    <option value="setor" <?=(isset($conteudo->identificador) && $conteudo->identificador == 'setor') ? 'selected' : '';?>>Setor</option>
                                                    <option value="telefone" <?=(isset($conteudo->identificador) && $conteudo->identificador == 'telefone') ? 'selected' : '';?>>Telefone</option>
                                                    <option value="unidade" <?=(isset($conteudo->identificador) && $conteudo->identificador == 'unidade') ? 'selected' : '';?>>Unidade</option>
                                                </select>
                                            </div>
                                            <div class="form-group">

                                                <label>Próximo bloco:</label>
                                                <select id="bloco_posterior" name="bloco_posterior" class="form-control select2" multiple="bloco_posterior" style="width: 100%;" >
                                                    <option>SELECIONE...</option>
                                                    <?php
                                                    foreach ($blocos_posteriores as $bloco_posterior) {
                                                        if ($bloco_posterior->blocoID != $bloco->blocoID) {
                                                    ?>
                                                    <option value="<?=$bloco_posterior->blocoID;?>" <?=(isset($proximo_bloco) && $proximo_bloco == $bloco_posterior->blocoID) ? 'selected' : '';?>><?=$bloco_posterior->nome;?></option>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>

                                            </div>
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary pull-right">Gravar</button>
                                            </div>
                                            <br>
                                            <hr>
                                            <h6><b>O que é:</b></h6>
                                            <h6>Nesta opção o sistema apenas envia seu texto e desabilita o campo de digitação do usuário. Utilizado para saudação inicial ou textos entre as perguntas.</h6>
                                            <?php
                                            unset($texto);
                                            unset($proximo_bloco);
                                            ?>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>

                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>

            <div class="col-md-6">
                <div id="gravar_bloco" class="hidden">
                    <form action="<?=base_url() . 'manager/dialogos/gravarBloco';?>" method="post">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Cadastro de bloco</h4>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="nome">Nome</label>
                                    <input type="text" class="form-control" placeholder="Nome" id="nome" name="nome" required>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <input type="hidden" id="dialogoID" name="dialogoID" value="<?=$dialogoID;?>">
                                <button type="submit" class="btn btn-primary pull-right">Gravar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-md-6">
                <div id="gravar_bloco_shop" class="hidden">
                    <form action="<?=base_url() . 'manager/dialogos/gravarBloco';?>" method="post">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Cadastro de bloco de lojas</h4>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="nome">Nome</label>
                                    <input type="text" class="form-control" placeholder="Nome" id="nome" name="nome" required>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <input type="hidden" id="dialogoID" name="dialogoID" value="<?=$dialogoID;?>">
                                <input type="hidden" id="tipoID" name="tipoID" value="4">
                                <button type="submit" class="btn btn-primary pull-right">Gravar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-md-6">
                <div id="gravar_bloco_model" class="hidden">
                    <form action="<?=base_url() . 'manager/dialogos/gravarBloco';?>" method="post">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Cadastro de bloco de modelos</h4>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="nome">Nome</label>
                                    <input type="text" class="form-control" placeholder="Nome" id="nome" name="nome" required>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <input type="hidden" id="dialogoID" name="dialogoID" value="<?=$dialogoID;?>">
                                <input type="hidden" id="tipoID" name="tipoID" value="5">
                                <button type="submit" class="btn btn-primary pull-right">Gravar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>


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