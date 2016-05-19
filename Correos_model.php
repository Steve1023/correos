<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Correos_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	function ver($id,$comparacion,$tabla){
		$this->db->select($id);
		$this->db->where($comparacion);
		$query = $this->db->get($tabla);
		if ($query->num_rows() > 0)
		{
			return $query->row_array();
		}else{
			return FALSE;
		}
	}
	function guardar($tabla,$data){
		$this->db->insert($tabla, $data); 
	}
	function buscar_coincidencias($etiqueta){
		$this->db->select('des_id');

		$this->db->join('mail_empresa', 'mail_empresa.emp_id = mail_destinatario.id_emp');
		$this->db->join('mail_des_cargo', 'mail_des_cargo.dcar_id = mail_destinatario.id_dcar');
		$this->db->join('mail_emp_subsector', 'mail_emp_subsector.esub_id = mail_empresa.emp_subsector_id');

		$this->db->like('mail_empresa.emp_razon', $etiqueta);
		$this->db->or_like('mail_empresa.emp_nombre', $etiqueta); 
		$this->db->or_like('mail_emp_subsector.esub_nombre_esp', $etiqueta); 
		$this->db->or_like('mail_emp_subsector.esub_detalle_esp', $etiqueta); 
		$this->db->or_like('mail_emp_subsector.esub_detalle_ing', $etiqueta); 
		$this->db->or_like('mail_des_cargo.dcar_nombre', $etiqueta); 

		$query = $this->db->get('mail_destinatario');

		if ($query->num_rows() > 0)
		{
			return $query;
		}else{
			return FALSE;
		}
	}

}