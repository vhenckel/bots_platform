<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Classe responsável pela manipulação dos dados de atendentes do chat
 *
 * @package Model
 * @access public
 **/
class Atendentes_model extends MY_Model {
    public function __construct()
    {
        parent::__construct();
        $this->table   = 'atendentes';
        $this->tableID = 'atendenteID';
    }
}