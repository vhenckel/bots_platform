<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Classe para previews dos bots
 *
 * @package Controller
 * @subpackage Manager
 * @access public
 **/
class Preview extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Método para listagem dos atendentes do chat
     * @return void
     **/
    public function index($token)
    {
        if (!$token) {
            redirect(base_url("manager/chatbots/"));
        }
        $data['chatbot_token'] = $token;
        $this->load->view('preview/index', $data);
    }
}