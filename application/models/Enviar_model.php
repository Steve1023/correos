<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Enviar_model
 *
 * @author desarrollo02
 */
class Enviar_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function envio() {
        $this->db->select('env_id,env_asunto,env_contenido,env_img,env_url');
        $this->db->where('env_estado', 0);
        $this->db->where('env_Fprogramada <=', date('Y-m-d H:i:s'));
        $this->db->limit(1);
        $query = $this->db->get('mail_envios');

        if ($query->num_rows() == 1) {
            return $query->row_array();
        } else {
            return FALSE;
        }
    }

    public function cambia_estado($id) {
        $data = array(
            'env_estado' => 1
        );
        $this->db->where('env_id', $id);
        $this->db->update('mail_envios', $data);
    }

    public function grupos($id) {
        $this->db->select('enet_etiqueta');
        $this->db->where('enet_envio', $id);
        $query = $this->db->get('mail_env_etiqueta');

        if ($query->num_rows() > 0) {
            return $query;
        } else {
            return FALSE;
        }
    }
    public function empresa($id){
        $this->db->select('emp_razon');
        $this->db->where('emp_id', $id);
        $query = $this->db->get('mail_empresa');
        if ($query->num_rows() == 1) {
            return $query->row_array();
        } else {
            return FALSE;
        }
    }
    
    public function cargo($id){
        $this->db->select('dcar_nombre');
        $this->db->where('dcar_id', $id);
        $query = $this->db->get('mail_des_cargo');
        if ($query->num_rows() == 1) {
            return $query->row_array();
        } else {
            return FALSE;
        }
    }

    public function destinatarios($data,$inicio,$final) {
        $this->db->select('id_destinatario,des_correo,des_nombre,des_apellidopaterno,des_apellidomaterno,dtit_nombre,id_dcar,id_emp');
        $this->db->join('mail_destinatario', 'mail_destinatario.des_id=mail_eti_asignados.id_destinatario');
        $this->db->join('mail_des_titulo', 'mail_destinatario.id_dtit=mail_des_titulo.dtit_id');
        //$this->db->join('mail_des_cargo', 'mail_destinatario.id_dcar=mail_des_cargo.dcar_id');
        //$this->db->join('mail_empresa', 'mail_destinatario.id_emp=mail_empresa.emp_id');
        $i = 1;
        foreach ($data->result_array() as $row) {
            if ($i == 1) {
                $this->db->where('id_eti', $row['enet_etiqueta']);
            } else {
                $this->db->or_where('id_eti', $row['enet_etiqueta']);
            }
            $i++;
        }
        $this->db->where('des_correo IS NOT NULL');
        $this->db->group_by("id_destinatario");
        if ($inicio!=NULL && $final!=NULL){
            $this->db->limit($final,$inicio);
        }
        $query = $this->db->get('mail_eti_asignados');
        if ($query->num_rows() > 0) {
            return $query;
        } else {
            return FALSE;
        }
    }

    public function remitentes($id) {
        $this->db->select('rem_correo,rem_smtp,rem_contrasena,rem_puerto');
        $this->db->join('mail_remitentes', 'mail_remitentes.rem_id=mail_env_remitentes.enre_remitente', 'right');
        $this->db->where('enre_envio', $id);
        $query = $this->db->get('mail_env_remitentes');

        if ($query->num_rows() > 0) {
            return $query;
        } else {
            return FALSE;
        }
    }

    public function registrar_envio($destinatario,$envio) {
        $data = array(
            'enje_destinatario' => $destinatario,
            'enje_envio' => $envio
        );

        $this->db->insert('mail_env_ejecutados', $data);
    }
    
    public function destinatario($correo,$mensaje){
        $this->db->join('mail_destinatario', 'mail_destinatario.des_id=mail_env_ejecutados.enje_destinatario');
        $this->db->join('mail_des_titulo', 'mail_destinatario.id_dtit=mail_des_titulo.dtit_id');
        //$this->db->join('mail_des_cargo', 'mail_destinatario.id_dcar=mail_des_cargo.dcar_id');
        //$this->db->join('mail_empresa', 'mail_destinatario.id_emp=mail_empresa.emp_id');
        
        $this->db->join('mail_envios', 'mail_envios.env_id=mail_env_ejecutados.enje_envio');
        
        
        $this->db->where('enje_destinatario', $correo);
        $this->db->where('enje_envio', $mensaje);
        $query = $this->db->get('mail_env_ejecutados');
        if ($query->num_rows() == 1) {
            return $query->row_array();
        } else {
            return FALSE;
        }
    }

}

