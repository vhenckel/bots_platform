<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Classe Pai de todos os Models contém todo o CRUD
 *
 * @package Core
 * @access public
 **/
class MY_Model extends CI_Model{

    protected $table;
    protected $tableID;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Método responsável por setar a tabela e o campo ID
     * @return void
     **/
    public function set_table($table, $tableID)
    {
        $this->table   = $table;
        $this->tableID = $tableID;
    }

    /**
     * Método responsável por realizar busca pelo ID
     * @return object
     **/
    public function get_by_id($id)
    {
        #Method Chaining APENAS PHP >= 5
        $this->db->select('*')
                    ->from($this->table)
                    ->where($this->tableID, $id);

        $query = $this->db->get();

        if($query->num_rows() > 0):
            return $query->row();
        endif;

        return false;
    }

    /**
     * Método responsável por realizar busca por campo específico
     * @return object
     **/
    public function get_by_field($field, $value, $limit = null)
    {
        #Method Chaining APENAS PHP >= 5
        $this->db->select('*')
                    ->from($this->table)
                    ->where($field, $value);

        if(!$limit == null){
            $this->db->limit($limit);
        }

        $query = $this->db->get();

        if($limit == 1):
            return $query->row();
        endif;
        if ($query->num_rows() >= 1):
            return $query->result();
        endif;

        return false;
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

     /**
     * Método responsável por realizar busca total
     * @return object
     **/
    public function get_all()
    {
        #Method Chaining APENAS PHP >= 5
        $this->db->select('*')
                    ->from($this->table);

        $query = $this->db->get();
        return $query->result();
    }

     /**
     * Método responsável pela persistência na tabela
     * @return object
     **/
    public function insert($attributes)
    {
        if($this->db->insert($this->table, $attributes)):
            return $this->db->insert_id();
        endif;
        return false;
    }

     /**
     * Método responsável pela persistência em lote na tabela
     * @return object
     **/
    public function insert_batch($attributes)
    {
        if($this->db->insert_batch($this->table, $attributes)):
            return true;
        endif;
        return false;
    }

     /**
     * Método responsável pelos updates na tabela
     * @return object
     **/
    public function update($id, $attributes)
    {
        $this->db->where($this->tableID, $id)->limit(1);

        if($this->db->update($this->table, $attributes)):
            return $this->db->affected_rows();
        endif;
        return false;
    }

     /**
     * Método responsável pelos deletes por ID na tabela
     * @return object
     **/
    public function delete($id, $limit = null)
    {
        $this->db->where($this->tableID, $id);

        if(!$limit == null){
            $this->db->limit($limit);
        }

        if($this->db->delete($this->table)):
            return true;
        endif;
    }

     /**
     * Método responsável por deletar por campo escolhido
     * @return object
     **/
    public function delete_where($field, $value, $limit = null)
    {
        $this->db->where($field, $value);

        if(!$limit == null){
            $this->db->limit($limit);
        }

        if($this->db->delete($this->table)):
            return true;
        endif;
    }

     /**
     * Método responsável por criar se não existir ou atualizar se já existir o campo escolhido
     * @return object
     **/
    public function create_or_update($field, $value, $attributes)
    {
        $checkIfExists = $this->get_by_field($field, $value, 1);
        if ($checkIfExists == FALSE) {
            if($this->insert($attributes)) {
                return $this->db->insert_id();
            }
            return FALSE;
        }
        $update = $this->update($checkIfExists->{$this->tableID}, $attributes);
        if (count($update) > 0) {
            return $checkIfExists->{$this->tableID};
        }
        return FALSE;
    }

    /**
     * Método responsável por criar se não existir
     * @return object
     **/
    public function insert_if_not_exists($field, $value, $attributes)
    {
        $checkIfExists = $this->get_by_field($field, $value, 1);
        if ($checkIfExists == FALSE) {
            if($this->insert($attributes)) {
                return $this->db->insert_id();
            }
            return FALSE;
        }
        return $checkIfExists->{$this->tableID};
    }
}