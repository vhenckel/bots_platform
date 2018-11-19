<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Classe para manipulação dos diálogos
 *
 * @package Controller
 * @subpackage Manager
 * @access public
 **/
class Dialogos extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->menu = 'dialogos';

        $this->load->model('Dialogo_model', 'dialogos');
        $this->load->model('Segmento_model', 'segmentos');
        $this->load->model('Blocos_model', 'blocos');
    }

    /**
     * Método para criação de um novo diálogo
     * @return void
     **/
    public function novo($id=NULL)
    {
        $this->submenu  = 'novo';

        $data['title'] = 'Novo Diálogo';
        $data['page']  = 'dialogo_novo';
        $data['segmentos'] = $this->segmentos->get_all();
        if ($id) {
            $data['dialogoEditar'] = $this->dialogos->get_by_id($id);
        }
        $this->render($data);
    }

    /**
     * Método para gravação e edição dos diálogos
     * @param array $_POST = dados do formulário de diálogo
     * @return void
     **/
    public function gravar()
    {
        if ($_POST) {
            $nome       = strip_tags(trim($this->input->post('nome')));
            $descricao  = strip_tags(trim($this->input->post('descricao')));
            $segmentoID = strip_tags(trim($this->input->post('segmentoID')));

            $attributes = [
                'nome'       => $nome,
                'descricao'  => $descricao,
                'segmentoID' => $segmentoID
            ];

            if ($this->input->post('dialogoID')) {
                $update = $this->dialogos->update($this->input->post('dialogoID'), $attributes);

                if ($update) {
                    $this->session->set_flashdata('success', 'Diálogo editado com sucesso!');
                    redirect(base_url("manager/dialogos/configurar/" . $this->input->post('dialogoID')));
                } else {
                    $this->session->set_flashdata('danger', "Diálogo não pôde ser editado!");
                }
            } else {
                $insert = $this->dialogos->insert($attributes);

                if ($insert) {
                    $cadastra_bloco_inicial = $this->blocos->insert(['nome' => 'MensagemInicial', 'dialogoID' => $insert]);
                    $this->session->set_flashdata('success', 'Diálogo criado com sucesso!');
                    redirect(base_url("manager/dialogos/configurar/" . $insert));
                } else {
                    $this->session->set_flashdata('danger', "Diálogo não pôde ser criado!");
                }
            }
        }
        redirect(base_url("manager/dialogos/novos/"));
    }

    /**
     * Método para listagem dos templates de diálogos
     * @return void
     **/
    public function templates()
    {
        $this->submenu  = 'templates';

        $data['title'] = 'lista de diálogos';
        $data['page']  = 'dialogo_templates';
        $data['dataTable'] = TRUE;
        $data['templates'] = $this->dialogos->get_all();
        $this->render($data);
    }

    /**
     * Método para configuração do diálogo
     * @param int $dialogoID = ID do diálogo
     * @return void
     **/
    public function configurar($dialogoID=null)
    {
        $this->submenu = 'templates';
        $data['title'] = 'Configurar Diálogo';
        $data['page']  = 'criar_perguntas';
        $data['dialogoID'] = $dialogoID;
        $data['dialogo']   = $this->dialogos->get_by_id($dialogoID);

        // if ($data['dialogo']->segmentoID == 1) {
        //     $data['marcas'] = $this->buscar_marcas();
        // }

        $data['blocos']    = $this->blocos->get_by_field('dialogoID', $dialogoID);
        $contador_blocos = 0;
        foreach ($data['blocos'] as $bloco) {
            $conteudo = json_decode($bloco->bloco_conteudo);

            if ($bloco->tipoID != 3) {
                if (!isset($conteudo) || $conteudo->proximo_bloco == '') {
                    $data['blocos'][$contador_blocos]->erro = TRUE;
                }
            } else {
                $respostas = $conteudo->respostas;
                if ($respostas) {
                    foreach ($respostas as $resposta) {
                        if ($resposta->proximo_bloco == '') {
                            $data['blocos'][$contador_blocos]->erro = TRUE;
                        }
                    }
                } else {
                    $data['blocos'][$contador_blocos]->erro = TRUE;
                }
            }
        $contador_blocos++;
        }
        $data['blocos_posteriores'] = $this->blocos->get_blocks_by_dialog($dialogoID);
        $this->render($data);
    }

    /**
     * Função responsável pela persistência dos nomes dos blocos
     * @param array $_POST = dados do bloco
     * @return void
     **/
    public function gravarBloco()
    {
        $nomes = explode(' ', $this->input->post('nome'));

        if ($nomes > 1) {
            $nomes = implode('_', $nomes);
        }

        $attributes = [
            'nome' => $nomes,
            'dialogoID' => $this->input->post('dialogoID')
        ];

        if ($this->input->post('tipoID')) {
            $attributes['tipoID'] = $this->input->post('tipoID');
        }

        $insert = $this->blocos->insert($attributes);

        if ($insert) {
            $this->session->set_flashdata('success', 'Bloco criado com sucesso!');
        } else {
            $this->session->set_flashdata('danger', "Bloco não pôde ser criado!");
        }
        redirect(base_url("manager/dialogos/configurar/" . $this->input->post('dialogoID')));
    }

    /**
     * Método para gravação dos dados do fluxo
     * @param  array $_POST = Dados do fluxo
     * @return void
     **/
    public function gravarFluxo()
    {
        if ($_POST) {

            if ($this->input->post('texto') || $this->input->post('texto_livre')) {
                if ($this->input->post('texto')) {
                    $conteudo_bloco = [
                        'texto' => $this->input->post('texto'),
                        'proximo_bloco' => $this->input->post('bloco_posterior')
                    ];
                    if ($this->input->post('marca')) {
                        $conteudo_bloco['marca'] = $this->input->post('marca');
                    }
                } else {
                    $conteudo_bloco = [
                        'texto' => $this->input->post('texto_livre'),
                        'proximo_bloco' => $this->input->post('bloco_posterior')
                    ];
                }

                if ($this->input->post('identificador')) {
                    $conteudo_bloco['identificador'] = $this->input->post('identificador');
                }
                $json = json_encode($conteudo_bloco);

                $attributes = [
                    'bloco_conteudo' => $json,
                    'tipoID'         => $this->input->post('tipoID')
                ];

                $update = $this->blocos->update($this->input->post('blocoID'), $attributes);
                if ($update) {
                    $this->session->set_flashdata('success', 'Bloco editado com sucesso!');
                } else {
                    $this->session->set_flashdata('danger', "Bloco não pôde ser editado!");
                }
                redirect(base_url("manager/dialogos/configurar/" . $this->input->post('dialogoID')));
            }
            if ($this->input->post('texto_opcoes')) {

                $respostas = array_combine($this->input->post('opcoes'), $this->input->post('bloco_posterior'));

                foreach ($respostas as $key => $value) {
                    $opcoes[] = [
                        'texto' => $key,
                        'proximo_bloco' => $value
                    ];
                }

                $conteudo_bloco = [
                        'texto'         => $this->input->post('texto_opcoes'),
                        'respostas'     => $opcoes,
                        'proximo_bloco' => NULL
                    ];
                if ($this->input->post('identificador')) {
                    $conteudo_bloco['identificador'] = $this->input->post('identificador');
                }
                $json = json_encode($conteudo_bloco);

                $attributes = [
                    'bloco_conteudo' => $json,
                    'tipoID' => $this->input->post('tipoID')
                ];

                $update = $this->blocos->update($this->input->post('blocoID'), $attributes);

                if ($update) {
                    $this->session->set_flashdata('success', 'Bloco editado com sucesso!');
                } else {
                    $this->session->set_flashdata('danger', "Bloco não pôde ser editado!");
                }
                redirect(base_url("manager/dialogos/configurar/" . $this->input->post('dialogoID')));
            }
        }
    }

    /**
     * Método para deletar bloco
     * @param  int $blocoID = ID do bloco
     * @param  int $dialogoID = ID do diálogo
     * @return void
     **/
    public function deletaBloco($dialogoID, $blocoID)
    {
        $delete = $this->blocos->delete($blocoID);
        if ($delete) {
            $this->session->set_flashdata('success', 'Bloco deletado com sucesso!');
        } else {
            $this->session->set_flashdata('danger', "Bloco não pôde ser deletado!");
        }
        redirect(base_url("manager/dialogos/configurar/" . $dialogoID));
    }

    /**
     * Método para deletar blocos e diálogo
     * @param  int $dialogoID = ID do diálogo
     * @return void
     **/
    public function excluirTemplate($dialogoID)
    {
        $deleta_blocos = $this->blocos->delete_where('dialogoID', $dialogoID);
        $delete = $this->dialogos->delete($dialogoID);
        if ($delete) {
            $this->session->set_flashdata('success', 'Diálogo deletado com sucesso!');
        } else {
            $this->session->set_flashdata('danger', "Diálogo não pôde ser deletado!");
        }
        redirect(base_url("manager/dialogos/templates/"));
    }

    /**
     * Método para clonar diálogo
     * @param  int $dialogoID = ID do diálogo
     * @return void
     **/
    public function clonar($dialogoID)
    {
        $dialogo = $this->dialogos->get_by_id($dialogoID);
        $blocos  = $this->blocos->get_by_field('dialogoID', $dialogoID);
        $novo_dialogo = [
            'nome'       => $dialogo->nome . ' - CÓPIA',
            'descricao'  => $dialogo->descricao,
            'segmentoID' => $dialogo->segmentoID
        ];
        $insert_novo_dialogo = $this->dialogos->insert($novo_dialogo);
        foreach ($blocos as $bloco) {
            $conteudo = json_decode($bloco->bloco_conteudo);

            if ($bloco->tipoID != 3) {
                $conteudo->proximo_bloco = NULL;
            } else {
                foreach ($conteudo->respostas as $resposta) {
                    $nova_resposta[] = [
                        'texto'         => $resposta->texto,
                        'proximo_bloco' => NULL
                    ];
                }
                $conteudo->respostas = $nova_resposta;
                unset($nova_resposta);
            }
            unset($bloco->blocoID);
            $bloco->dialogoID = $insert_novo_dialogo;
            $bloco->bloco_conteudo = json_encode($conteudo);

            $novos_blocos[] = $bloco;
        }

        $blocos_inseridos = $this->blocos->insert_batch($novos_blocos);
        if ($blocos_inseridos) {
            $this->session->set_flashdata('success', 'Diálogo clonado com sucesso!');
            redirect(base_url("manager/dialogos/configurar/" . $insert_novo_dialogo));
        } else {
            $this->session->set_flashdata('danger', "Diálogo não pôde ser clonado!");
            $this->dialogo->delete($insert_novo_dialogo);
        }
        redirect(base_url("manager/dialogos/templates/"));
    }
}