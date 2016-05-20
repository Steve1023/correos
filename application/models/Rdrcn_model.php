<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Rdrcn_model
 *
 * @author desarrollo04
 */
class Rdrcn_model extends CI_Model  {
    //put your code here
    public function __construct() {
        parent::__construct();
    }
    public function nlc($envio) {
        $this->db->select('env_url');
        $this->db->where('env_id', $envio);
        $query = $this->db->get('mail_envios');
        if ($query->num_rows() == 1) {
            return $query->row();
        }else{
            return FALSE;
        }
    }
}
