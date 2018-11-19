<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Classe responsável pela manipulação dos chats
 *
 * @package Model
 * @access public
 **/
class Chatbots_model extends MY_Model {
    public function __construct()
    {
        parent::__construct();
        $this->table   = 'chatbots';
        $this->tableID = 'chatbotID';
    }

    /**
     * Método responsável por pegar todos os chats
     * @return object
     **/
    public function buscar_todos()
    {
        $this->db->select('cb.chatbotID, cb.titulo, cb.unidade, cb.clienteID, cb.hash, s.nome as segmento')
                    ->from($this->table . ' cb')
                    ->join('dialogos d', 'd.dialogoID = cb.dialogoID', 'left')
                    ->join('segmentos s', 's.segmentoID = d.segmentoID', 'left');

        $query = $this->db->get();
        return $query->result();
    }
}