<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Destinatarios
 *
 * @author desarrollo02
 */
class Destinatarios extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->mTitle = 'Destinatarios - ';
		$this->push_breadcrumb('Destinatarios');
	}
        public function index(){
            
        }
        
        public function destinatarios(){
            
		$crud = $this->generate_crud('mail_destinatario');
		$crud->set_relation('id_dcar', 'mail_des_cargo', 'dcar_nombre')
				->set_relation('id_dtit', 'mail_des_titulo', 'dtit_nombre')
				->set_relation('id_emp', 'mail_empresa', 'emp_razon');
		$crud->order_by('des_apellidopaterno','asc');
		$crud->display_as('des_nombre','Nombres')
				->display_as('des_apellidopaterno','Apellido paterno')
				->display_as('des_apellidomaterno','Apellido materno')
				->display_as('id_dcar','Cargo')
				->display_as('id_emp','Empresa')
				->display_as('id_dtit','Título')
				->display_as('des_correo','Correo electrónico');

		$crud->set_relation_n_n('Etiquetas', 'mail_eti_asignados', 'mail_etiqueta', 'id_destinatario', 'id_eti', 'eti_nombre');

		$this->mTitle.= 'Destinatarios';
		$this->render_crud();
	}

	public function etiquetas(){
		$crud = $this->generate_crud('mail_etiqueta');
		$crud->display_as('eti_nombre','Etiqueta');

		$this->mTitle.= 'Etiquetas';
		$this->render_crud();
	}
	
	public function des_cargo(){
		$crud = $this->generate_crud('mail_des_cargo','');
		$crud->display_as('dcar_nombre','Cargo')
				->display_as('dcar_codigo','Código');
		$crud->columns('dcar_nombre');
		$this->mTitle.= 'Grupos empresariales';
		$this->render_crud();
	}
}
