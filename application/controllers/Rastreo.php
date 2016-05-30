<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Rastreo
 *
 * @author desarrollo04
 */
class Rastreo extends My_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();
    }

    public function index() {
        
    }

    public function track($destinatario, $envio) {
        $this->load->model('rastreo_model');
        $this->rastreo_model->track($destinatario, $envio, 0);
        header('Content-Type: image/jpg');
        readfile('blank.jpg');
    }

    function url($destinatario, $envio) {
        $this->load->model('rastreo_model');

        $this->rastreo_model->track($destinatario, $envio, 1);
        $url = $this->rastreo_model->url($envio);
        if ($url == TRUE) {
            redirect($url['env_url']);
        }
    }

    function desactivar() {
        $this->load->model('rastreo_model');
        $correo = $this->input->get('correo');
        $this->rastreo_model->desactivar($correo);
        echo "El correo electrónico " . $correo . " ha sido desactivado.";
    }

    function mensaje($usuario, $mensaje) {

        $this->load->model('enviar_model');
        $row = $this->enviar_model->destinatario($usuario, $mensaje);
        if ($row['id_emp'] != NULL) {
            $empresa = $this->enviar_model->empresa($row['id_emp']);
        } else {
            $empresa['emp_razon'] = NULL;
        }
        if ($row['id_dcar'] != NULL) {
            $cargo = $this->enviar_model->cargo($row['id_dcar']);
        } else {
            $cargo['dcar_nombre'] = NULL;
        }
        if ($row == TRUE) {
            $cuerpo = '<!DOCTYPE html>'
                    . '<html>'
                    . '<head>'
                    . '<meta http-equiv="Content-Type" content="text/html;charset=utf-8" >'
                    . '<title>' . $row['env_asunto'] . '</title>'
                    . '</head>'
                    . '<body style="font-family: sans serif;">'
                    . '<div style="background-image: url(\'' . base_url() . 'rastreo/track/' . $usuario . '/' . $row['env_id'] . '\')">'
                    . '<p><strong class="color:#345">' . $row['dtit_nombre'] . ' ' . $row['des_nombre'] . ' ' . $row['des_apellidopaterno'] . ' ' . $row['des_apellidomaterno'] . '</strong><br />'
                    . $cargo['dcar_nombre'] . '<br/>'
                    . $empresa['emp_razon'] . '<br/></p>'
                    . '</div>'
                    . '<div id="contenido" style="font-size:0px">'
                    . $row['env_contenido']
                    . '</div>'
                    . '<div style="text-align:center;width: 100%;">'
                    . '<a href="' . base_url() . 'rastreo/url/' . $usuario . '/' . $row['env_id'] . '" target="new">'
                    . '<img src="' . base_url() . 'img/' . $row['env_img'] . '" style="width: 90%;">'
                    . '</a>'
                    . '</div>'
                    . '<div style="text-align:center;width: 100%;">'
                    . '<p style="font-size:12px">Si ya no desea recibir nuestro boletín '
                    . '<a href="' . base_url() . 'rastreo/desactivar/?correo=' . $row['des_correo'] . '" target="new">haga clic aquí</a>'
                    . ' y le daremos de baja en nuestra base de datos.</p>'
                    . '</div>'
                    . '</body>'
                    . '</html>';
            echo $cuerpo;
        } else {
            echo 'nada';
        }
    }

}
