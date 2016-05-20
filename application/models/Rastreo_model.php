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

    public function track($destinatario, $envio) {
        $data = array(
            'enje_abierto' => date("Y-m-d H:i:s")
        );
        $this->db->where('enje_destinatario', $destinatario);
        $this->db->where('enje_envio', $envio);
        $this->db->where('enje_abierto', NULL);
        $this->db->update('mail_env_ejecutados', $data);
    }

}
