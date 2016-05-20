<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Enviar
 *
 * @author desarrollo02
 */
class Enviar extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        /* $j=8;
          $inicio=$this->input->get('i');
          $rango=$this->input->get('r');
          $envio=1;
          set_time_limit(43200); */
        $this->load->model('enviar_model');
        $this->load->library('email');
        $envio = $this->enviar_model->envio();
        if ($envio == FALSE) {
            echo "No hay envio" . PHP_EOL;
        } else {
            echo $envio['env_id'] . PHP_EOL;
            
            $this->enviar_model->cambia_estado($envio['env_id']);
            
            $grupos = $this->enviar_model->grupos($envio['env_id']);
            
            if ($grupos == FALSE) {
                echo "No hay grupo" . PHP_EOL;
            } else {
                foreach ($grupos->result_array() as $row) {
                    echo $row['enet_etiqueta'] . PHP_EOL;
                }

                //Recupero los correos remitentes que utilizaré para el envío
                $remitentes = $this->enviar_model->remitentes($envio['env_id']);
                if ($remitentes == TRUE) {
                    // foreach ($remitentes->result_array() as $row) {
                    //  echo $rem['rem_correo'] . PHP_EOL;
                    //  } 
                }
                
                $cantidad = ($remitentes->num_rows) - 1; //Cantidad de correos remitentes
                $fila = 0;
                
                //Recupero la lista de destinatarios a quienes les enviaré el mensaje
                $destinatarios = $this->enviar_model->destinatarios($grupos);
                if ($destinatarios == TRUE) {
                    foreach ($destinatarios->result_array() as $row) {
                        echo $row['id_destinatario'] . '-' . $row['des_correo'] . PHP_EOL;

                        $rem = $remitentes->row_array($fila);
                        echo $rem['rem_correo'].'-'.$rem['rem_smtp'].'-'.$row['des_nombre']. PHP_EOL. PHP_EOL;

                        $this->email->clear(TRUE);
                        
                        $config = array(
                            'protocol' => 'smtp',
                            'smtp_host' => $rem['rem_smtp'],
                            'smtp_port' => $rem['rem_puerto'],
                            'smtp_user' => $rem['rem_correo'],
                            'smtp_pass' => $rem['rem_contrasena'],
                            'mailtype' => 'html',
                            'charset' => 'utf-8',
                            'newline' => "\r\n",
                            'crlf' => "\r\n"
                        );
                        
                        $this->email->initialize($config);
                        $this->email->from($rem['rem_correo']);
                        $this->email->to($row['des_correo']);
                        $this->email->subject($envio['env_asunto']);
                        $this->email->message('<!DOCTYPE html>'
                                . '<html>'
                                . '<head>'
                                . '<meta http-equiv="Content-Type" content="text/html;charset=utf-8" >'
                                . '<title>'.$envio['env_asunto'].'</title>'
                                . '</head>'
                                . '</body>'
                                . '<div style="background-image: url(\''.base_url().'rastreo/track/'.$row['id_destinatario'].'/'.$envio['env_id'].'\')">'
                                . '<p><strong class="color:#345">'.$row['dtit_nombre']. ' '. $row['des_nombre'] .' '. $row['des_apellidopaterno'] .' '. $row['des_apellidomaterno'] .'</strong></p>'
                                . '<p>'.$row['dcar_nombre'].'</p>'
                                . '<p>'.$row['emp_razon'].'</p>'
                                . '</div>'
                                . '<div id="contenido">'
                                . $envio['env_contenido']
                                . '<div style="text-align:center;width: 100%;">'
                                . '<a href="'.base_url().'rastreo/url/'.$row['id_destinatario'].'/'.$envio['env_id'].'" target="new">'
                                . '<img src="'.base_url().'img/'.$envio['env_img'].'" style="width: 90%;">'
                                . '</a>'
                                . '</div>'
                                . '</div>'
                                . '</body>'
                                . '</html>');

                        if ($this->email->send()) {
                            $Tenviado = date("Y-m-d H:i:s");
                            $this->enviar_model->registrar_envio($row['id_destinatario'], $envio['env_id']);
                            echo 'Correo enviado con éxito a ' . $row['des_correo'] . ' | hora: ' . $Tenviado. PHP_EOL;
                        } else {
                            show_error($this->email->print_debugger());
                            
                        }
                        
                        if ($fila < $cantidad) {
                            $fila++;
                        } else if ($fila == $cantidad) {
                            $fila = 0;
                        }
                        sleep(rand(5,10));
                    }
                }
            }
        }
    }
}
