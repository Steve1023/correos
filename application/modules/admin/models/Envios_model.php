<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Envios_model
 *
 * @author desarrollo04
 */
class Envios_model extends CI_Model {
    public function __construct() {
        parent::__construct();
    }
    public function envio($id){
        $this->db->select('env_asunto');
        $this->db->where('env_id', $id);
        $this->db->limit(1);
        $query = $this->db->get('mail_envios');
        if ($query->num_rows() == 1) {
            return $query->row_array();
        } else {
            return FALSE;
        }
    }
}
