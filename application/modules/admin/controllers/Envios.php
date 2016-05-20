<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Envios extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->mTitle = 'Envíos - ';
        $this->push_breadcrumb('Envíos');
    }

    public function index() {
        
    }

    public function pendientes() {
        $crud = $this->generate_crud('mail_envios');
        $crud->where('env_estado', 0);
        $crud->display_as('env_asunto', 'Asunto');
        $crud->display_as('env_contenido', 'Contenido');
        $crud->set_field_upload('env_img', UPLOAD_ENVIO);
        $crud->display_as('env_img', 'Imagen');
        $crud->display_as('env_Fprogramada', 'Fecha de envío');
        $crud->display_as('env_url', 'Dirección del enlace');
        //$crud->required_fields('Remitentes', 'Destinatarios', 'env_asunto', 'env_contenido', 'env_img', 'env_Fprogramada', 'env_url');
        $crud->columns('env_asunto', 'env_Fprogramada', 'Destinatarios');
        $crud->fields('Remitentes', 'Destinatarios', 'env_asunto', 'env_contenido', 'env_img', 'env_Fprogramada', 'env_url');
        $crud->set_relation_n_n('Remitentes', 'mail_env_remitentes', 'mail_remitentes', 'enre_envio', 'enre_remitente', 'rem_correo');
        $crud->set_relation_n_n('Destinatarios', 'mail_env_etiqueta', 'mail_etiqueta', 'enet_envio', 'enet_etiqueta', 'eti_nombre');
        $this->mTitle.= 'Pendientes';
        $this->render_crud();
    }

    public function procesando() {
        
    }

    public function remitidos() {

        $crud = $this->generate_crud('mail_envios');
        $crud->where('env_estado', 1);
        $crud->unset_add();
        $crud->unset_edit();
        $crud->unset_delete();
        //$crud->unset_read();
        $crud->display_as('env_asunto', 'Asunto');
        $crud->columns('env_asunto', 'env_Fprogramada', 'Destinatarios');
        $crud->set_relation_n_n('Destinatarios', 'mail_env_etiqueta', 'mail_etiqueta', 'enet_envio', 'enet_etiqueta', 'eti_nombre');
        $crud->add_action('Destinatarios', base_url() . 'assets/grocery_crud/themes/flexigrid/css/images/destinatarios.png', 'admin/envios/listado');

        $this->mTitle.= 'Remitidos';
        $this->render_crud();
    }
//http://190.237.15.180:213/correos/rastreo/url/56070/10
    public function listado($id) {
        if (isset($id)) {
            $this->load->model('envios_model');
            $asunto = $this->envios_model->envio($id);
            $crud = $this->generate_crud('mail_env_ejecutados');
            $crud->unset_add();
            $crud->unset_edit();
            $crud->unset_delete();
            $crud->unset_read();
            $crud->where('enje_envio', $id);
            $crud->set_relation('enje_destinatario', 'mail_destinatario', 'des_correo');
            $crud->display_as('enje_destinatario', 'Destinatario');
            $crud->display_as('enje_fecha', 'Fecha de envío');
            $crud->display_as('enje_abierto', 'Fecha de apertura');
            $crud->display_as('enje_enlace', 'Enlace abierto');
            $crud->columns('enje_destinatario', 'enje_fecha', 'enje_abierto', 'enje_enlace');
            $crud->unset_add();
            $this->mTitle.= 'Remitido - '.$asunto['env_asunto'];
            $this->render_crud();
        } else {
            $this->index();
        }
    }

}
