<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->session->sess_destroy();
        $this->load->view('manager/login');
    }

    public function logar()
    {
        if($_POST){

            $user     = strip_tags(trim($this->input->post('user')));
            $password = strip_tags(trim($this->input->post('password')));

            $this->load->model('Login_model', 'login');

            $dadosLogin = $this->login->logar($user, $password);

            if(count($dadosLogin) == 1){

                $dadosUsuario = array(
                        'logado'    => true,
                        'usuarioID' => $dadosLogin->usuarioID,
                        'nome'      => $dadosLogin->nome,
                        'usuario'   => $dadosLogin->usuario,
                        'email'     => $dadosLogin->email,
                        'date'      => date('H:i:s d/m/Y'),
                        );
                $this->session->set_userdata($dadosUsuario);
                redirect('manager/dashboard');

            } else {
                $this->session->set_flashdata('danger', "Dados de acesso inválidos!");
                redirect(base_url() . 'manager/login');
            }
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect(base_url() . 'manager/login', 'refresh');
    }
}