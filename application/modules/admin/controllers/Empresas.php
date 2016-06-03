<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Empresas
 *
 * @author desarrollo02
 */
class Empresas extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->mTitle = 'Empresas - ';
		$this->push_breadcrumb('Correos');
	}
        
        public function index(){
            
        }
        
        
        public function empresas(){
		$crud = $this->generate_crud('mail_empresa');
		/*
		$crud->columns('author_id', 'category_id', 'title', 'image_url', 'tags', 'publish_time', 'status');
		*/
		$crud->set_relation('emp_tipo_id', 'mail_emp_tipo', 'etip_nombre')
				->set_relation('emp_tamano_id', 'mail_emp_tamano', 'etam_nombre')
				->set_relation('emp_grupo_id', 'mail_emp_grupo', 'egru_nombre')
				->set_relation('emp_subsector_id', 'mail_emp_subsector', 'esub_nombre_esp');
		$crud->order_by('emp_razon','asc');
		$crud->display_as('emp_razon','Razón social')
				->display_as('emp_nombre','Nombre')
				->display_as('emp_ruc','RUC')
				->display_as('emp_web','Web')
				->display_as('emp_correo','Correo electrónico')
				->display_as('emp_tamano_id','Tamaño')
				->display_as('emp_subsector_id','Sector')
				->display_as('emp_grupo_id','Grupo empresarial')
				->display_as('emp_tipo_id','Tipo');
                $crud->columns('emp_razon','emp_nombre','emp_ruc','emp_tamano_id','emp_subsector_id','emp_tipo_id');

		/*
		$crud->set_relation_n_n('tags', 'mail_demo_blog_posts_tags', 'mail_demo_blog_tags', 'post_id', 'tag_id', 'title');
		
		$state = $crud->getState();
		if ($state==='add')
		{
			$crud->field_type('author_id', 'hidden', $this->mUser->id);
			$this->unset_crud_fields('status');
		}
		else
		{
			$crud->set_relation('author_id', 'mail_admin_users', '{first_name} {last_name}');
		}*/

		$this->mTitle.= 'Empresas';
		$this->render_crud();
	}
        public function emp_tipo(){
		$crud = $this->generate_crud('mail_emp_tipo','');
		$crud->display_as('etip_nombre','Tipo');

		$this->mTitle.= 'Tipo de empresas';
		$this->render_crud();
	}
	public function emp_grupo(){
		$crud = $this->generate_crud('mail_emp_grupo','');
		$crud->display_as('egru_nombre','Grupo');

		$this->mTitle.= 'Grupos empresariales';
		$this->render_crud();
	}
}
