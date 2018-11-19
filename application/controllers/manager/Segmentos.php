<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Classe para manipulação dos Segmentos
 *
 * @package Controller
 * @subpackage Manager
 * @access public
 **/
class Segmentos extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->menu    = 'segmentos';
        $this->submenu = 'novo';
        $this->load->model('Segmento_model', 'segmentos');
    }

     /**
     * Método para listagem e edição do segmento
     *
     * @param array $id = ID do segmento a ser editado
     * @return void
     **/
    public function index($id=NULL)
    {
        $data['title'] = 'Novo Segmento';
        $data['page']  = 'segmento_novo';
        $data['segmentos'] = $this->segmentos->get_all();
        if ($id) {
            $data['segmentoEditar'] = $this->segmentos->get_by_id($id);
        }
        $data['dataTable'] = TRUE;
        $this->render($data);
    }

    /**
     * Método para gravação do segmento
     *
     * @param array $_POST = array com todos o nome do segmento
     * @return void
     **/
    public function gravar()
    {
        $attributes['nome'] = strip_tags(trim($this->input->post('nome')));

        if ($this->input->post('segmentoID')) {
            $update = $this->segmentos->update($this->input->post('segmentoID'), $attributes);
            if ($update) {
                $this->session->set_flashdata('success', 'Segmento editado com sucesso!');
            } else {
                $this->session->set_flashdata('danger', "Segmento não pôde ser editado!");
            }
        } else {
            $insert = $this->segmentos->insert($attributes);
            if ($insert) {
                $this->session->set_flashdata('success', 'Segmento criado com sucesso!');
            } else {
                $this->session->set_flashdata('danger', "Segmento não pôde ser criado!");
            }
        }
        redirect(base_url("manager/segmentos/"));
    }

    /**
     * Método para excluir o segmento
     *
     * @param integer $id = ID do segmento
     * @return void
     **/
    public function excluir($id)
    {
        // Necessário ainda verificar se existem diálogos vinculados a este segmento
        $excluir = $this->segmentos->delete($id);
        if ($excluir) {
            $this->session->set_flashdata('success', 'Segmento excluído com sucesso!');
        } else {
            $this->session->set_flashdata('danger', "Segmento não pôde ser excluído!");
        }
        redirect(base_url("manager/segmentos/"));
    }
}