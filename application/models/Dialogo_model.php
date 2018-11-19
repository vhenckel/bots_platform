<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Classe responsável pela manipulação dos diálogos
 *
 * @package Model
 * @access public
 **/
class Dialogo_model extends MY_Model {
    public function __construct()
    {
        parent::__construct();
        $this->table   = 'dialogos';
        $this->tableID = 'dialogoID';
    }
}