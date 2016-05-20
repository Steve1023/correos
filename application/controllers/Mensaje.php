<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Mensaje
 *
 * @author desarrollo04
 */
class Mensaje extends My_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();
    }
    
    function contenido($destinatario, $envio){
        $this->load->model('rastreo_model');
        $this->rastreo_model->track($destinatario, $envio);
    }

}
