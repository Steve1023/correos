<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Rastreo_model
 *
 * @author desarrollo04
 */
class Rastreo_model extends CI_Model {

    //put your code here
    public function __construct() {
        parent::__construct();
    }

    public function track($destinatario, $envio, $tipo) {
        if ($tipo == 0) {
            $data = array(
                'enje_abierto' => date("Y-m-d H:i:s")
            );
            $this->db->where('enje_abierto', NULL);
        } elseif ($tipo == 1) {
            $data = array(
                'enje_enlace' => 1,
                'enje_abierto' => date("Y-m-d H:i:s")
            );
            $this->db->where('enje_enlace', 0);
        }

        $this->db->where('enje_destinatario', $destinatario);
        $this->db->where('enje_envio', $envio);

        $this->db->update('mail_env_ejecutados', $data);
    }
    public function url($envio) {
        $this->db->select('env_url');
        $this->db->where('env_id', $envio);
        $query = $this->db->get('mail_envios');
        if ($query->num_rows() == 1) {
            return $query->row();
        }else{
            return FALSE;
        }
    }

    

    /*
      private function track_revision($destinatario, $envio) {
      $this->db->select();
      $this->db->where('enje_abierto',NULL);
      } */
}
