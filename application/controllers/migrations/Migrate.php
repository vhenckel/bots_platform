<?php
set_time_limit(300);
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Classe para criação das tabelas utilizadas na LP
 *
 * @package Migrations
 **/
class Migrate extends CI_Controller {

    /**
     * Função responsável pela criação das tabelas
     *
     * @return string
     **/
    public function index()
    {
        $sections = array(
                     'config'  => TRUE,
                     'queries' => TRUE
                     );
        $this->output->set_profiler_sections($sections);
        $this->output->enable_profiler(TRUE);

        $this->load->library('migration');
        if ($this->migration->current() === false) {
            show_error($this->migration->error_string());
        }
        else {
            echo 'Migrado';
        }
    }
}