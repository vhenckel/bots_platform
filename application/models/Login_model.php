<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Classe responsável pela manipulação do login no sistema
 *
 * @package Model
 * @access public
 **/
class Login_model extends MY_Model {
    public function __construct()
    {
        parent::__construct();
        $this->table   = 'usuarios';
        $this->tableID = 'usuarioID';
    }

    public function setSenha($senha)
    {
        return $senha = sha1('lead@' . $senha . '@force');
    }

    /**
     * Método responsável por verificar os dados de login
     * @return object
     **/
    public function logar($email, $senha)
    {
        $this->db->where('usuario', $email);
        $this->db->where('senha', $this->setSenha($senha));

        $query = $this->db->get($this->table);
        return $query->row();
    }
}