<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Remitentes extends Admin_Controller {
        public function __construct()
	{
		parent::__construct();
		$this->mTitle = 'Remitentes - ';
		$this->push_breadcrumb('Remitentes');
	}
        public function index(){
                
        }
        public function remitentes(){
		$crud = $this->generate_crud('mail_remitentes','');
		$crud->display_as('rem_correo','Correo electrónico');
                $crud->display_as('rem_smtp','Servidor SMTP');
                $crud->display_as('rem_contrasena','Contraseña');
                $crud->field_type('rem_contrasena','password');
                $crud->display_as('rem_puerto','Puerto');
                $crud->columns('rem_correo','rem_smtp');
		$this->mTitle.= 'Remitentes';
		$this->render_crud();
	}

}