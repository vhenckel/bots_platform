<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Classe responsável pela manipulação dos usuários do sistema de chat
 *
 * @package Model
 * @access public
 **/
class Usuarios_model extends MY_Model {
    public function __construct()
    {
        parent::__construct();
        $this->table   = 'usuarios';
        $this->tableID = 'usuarioID';
    }
}