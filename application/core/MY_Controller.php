<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Classe Pai de todos os controllers
 *
 * @package Core
 * @access public
 **/
class MY_Controller extends CI_Controller {

    protected $menu    = NULL;
    protected $submenu = NULL;

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('logado')) {
            redirect('manager/login');
        }
        // $sections = array(
        //              'config'  => TRUE,
        //              'queries' => TRUE
        //              );
        // $this->output->set_profiler_sections($sections);
        // $this->output->enable_profiler(TRUE);
    }

    /**
     * Método para buscar todas as marcas dos carros do MKT da LeadForce
     * @return array
     * @access private
     **/
    protected function buscar_marcas() {
        $r = json_decode(file_get_contents('http://rel.leadforce.com.br/ws/marcas_json'), 1);

        if(count($r)){
            return $r;
        }
        return array('0' => null);
    }

    /**
     * Método para buscar os veículos
     * @param array $marcas
     * @return array
     **/
    protected function buscar_veiculos($marcas)
    {
        $contador = 0;
        $qs = null;
        foreach ($marcas as $marca) {
            $qs .= 'mrc[' . $contador . ']=' . $marca->marcaID . '&';
            $contador++;
        }
        $r = json_decode(file_get_contents('http://rel.leadforce.com.br/ws/modelos_json?' . $qs), 1);

        if(count($r)){
            return $r;
        }
        return array('0' => null);
    }

    /**
     * Método para renderização de todas as telas do sistema
     * @return array
     * @access protected
     **/
    protected function render($data)
    {
        $data['menu'] = $this->menu;
        $data['submenu'] = $this->submenu;

        $this->load->view('manager/includes/header', $data, FALSE);
        $this->load->view('manager/includes/menu', $data, FALSE);
        $this->load->view('manager/includes/body-top', $data, FALSE);
        $this->load->view('manager/pages/' . $data['page'], $data, FALSE);
        $this->load->view('manager/includes/footer', $data, FALSE);
    }

     /**
     * Método para renderização da tela de 404 do sistema
     * @return array
     * @access protected
     **/
    protected function not_found($url, $message=null)
    {
        if ($message == null) {
            $message = 'Dados incorretos, favor verificar!';
        }
        $this->session->set_flashdata('danger', $message);
        redirect(base_url($url));
        die();
    }
}