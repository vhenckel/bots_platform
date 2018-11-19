<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Classe responsável pela manipulação dos blocos do chat
 *
 * @package Model
 * @access public
 **/
class Blocos_model extends MY_Model {
    public function __construct()
    {
        parent::__construct();
        $this->table   = 'blocos';
        $this->tableID = 'blocoID';
    }

    /**
     * Método responsável por pegar os blocos por diálogo
     * @return object
     **/
    public function get_blocks_by_dialog($value)
    {
        $this->db->select('*')
                    ->from($this->table)
                    ->where('dialogoID', $value)
                    ->order_by('nome', 'ASC');

        $query = $this->db->get();

        if ($query->num_rows() >= 1):
            return $query->result();
        endif;

        return false;
    }

    /**
     * Método responsável por buscar o bloco inicial do chat por hash
     * @return object
     **/
    public function buscar_inicial($hash)
    {
        $this->db->select('bl.*')
                    ->from($this->table . ' bl')
                    ->join('chatbots cb', 'cb.dialogoID = bl.dialogoID')
                    ->where('cb.hash', $hash)
                    ->where('bl.nome', 'MensagemInicial');

        $query = $this->db->get();

        return $query->row();
    }
}