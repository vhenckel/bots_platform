<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Classe para manipulação dos usuários
 *
 * @package Controller
 * @subpackage Manager
 * @access public
 **/
class Usuarios extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->menu = 'usuarios';
        $this->load->model('Usuarios_model', 'usuarios');
    }

    /**
     * Método para listagem e edição dos usuários
     * @param integer $id = ID do usuário a ser editado
     * @return void
     **/
    public function index($id=NULL)
    {
        $data['title'] = 'Usuários';
        $data['page']  = 'usuarios';
        $data['dataTable'] = TRUE;
        $data['usuarios'] = $this->usuarios->get_all();
        if ($id) {
            $data['usuarioEditar'] = $this->usuarios->get_by_id($id);
        }
        $this->render($data);
    }

    /**
     * Método para gravação dos usuários
     * @param array $_POST = dados do formulário de usuários
     * @return void
     **/
    public function gravar()
    {
        if ($_POST) {
            $nome    = strip_tags(trim($this->input->post('nome')));
            $usuario = strtolower(strip_tags(trim($this->input->post('usuario'))));
            $senha   = strip_tags(trim($this->input->post('senha')));

            // Caso seja uma edição de usuário
            $usuarioID = $this->input->post('usuarioID');

            $attributes = [
                'nome'    => $nome,
                'usuario' => $usuario,
                'senha'   => crypto($senha),
                'status'  => 1
            ];

            if ($usuarioID) {
                $update = $this->usuarios->update($usuarioID, $attributes);

                if ($update) {
                    $this->session->set_flashdata('success', 'Usuário editado com sucesso!');
                } else {
                    $this->session->set_flashdata('danger', "Usuário não pôde ser editado!");
                }
            } else {
                $insert = $this->usuarios->insert($attributes);

                if ($insert) {
                    $this->session->set_flashdata('success', 'Usuário criado com sucesso!');
                } else {
                    $this->session->set_flashdata('danger', "Usuário não pôde ser criado!");
                }
            }
        }
        redirect(base_url("manager/usuarios/"));
    }

    /**
     * Método para exclusão dos usuários
     * @param integer $id = id do usuário que deve ser excluído
     * @return void
     **/
    public function excluir($id)
    {
        $delete = $this->usuarios->delete($id);
        if ($delete) {
            $this->session->set_flashdata('success', 'Usuário excluído com sucesso!');
        } else {
            $this->session->set_flashdata('danger', "Usuário não pôde ser excluído!");
        }
        redirect(base_url("manager/usuarios/"));
    }
}