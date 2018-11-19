<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Classe responsável pela manipulação das conversas
 *
 * @package Model
 * @access public
 **/
class Conversas_model extends MY_Model {
    public function __construct()
    {
        parent::__construct();
        $this->table   = 'conversas';
        $this->tableID = 'conversaID';
    }

     /**
     * Método responsável por realizar busca por campos específicos
     * @return object
     **/
    public function get_by_fields(array $fields, $limit = null)
    {
        #Method Chaining APENAS PHP >= 5
        $this->db->select('*')
                    ->from($this->table);

        foreach ($fields as $key => $value) {
            $this->db->where($key, $value);
        }

        if(!$limit == null){
            $this->db->limit($limit);
        }

        $query = $this->db->get();

        if ($query->num_rows() >= 1):
            return $query->result();
        endif;

        return false;
    }
}