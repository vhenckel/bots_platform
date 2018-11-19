<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Classe responsável pela manipulação dos segmentos
 *
 * @package Model
 * @access public
 **/
class Segmento_model extends MY_Model {
    public function __construct()
    {
        parent::__construct();
        $this->table   = 'segmentos';
        $this->tableID = 'segmentoID';
    }
}