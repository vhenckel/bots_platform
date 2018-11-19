<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Classe para manipulação da dashboard
 *
 * @package Controller
 * @subpackage Manager
 * @access public
 **/
class Dashboard extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->menu = 'dashboard';
    }

     /**
     * Método para renderização da dashboard
     * @return void
     **/
    public function index()
    {
        $data['title'] = 'Dashboard';
        $data['page']  = 'dashboard';
        $this->render($data);
    }
}