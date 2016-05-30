<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Correo extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index($valor)
	{
		echo "Hola, amiguito. ".$valor.".".PHP_EOL;
	}

	private function ver_guardar($id,$comparacion,$tabla,$data){
		$ver=$this->correos_model->ver($id,$comparacion,$tabla);
		if($ver==TRUE){
			echo $ver[$id]."-Sí".PHP_EOL;

		}else{
			$this->correos_model->guardar($tabla,$data);
			$ver=$this->correos_model->ver($id,$comparacion,$tabla);
			echo $ver[$id]."-No".PHP_EOL;
		}
		return $ver[$id];
	}
	private function nulo($valor){
		if($valor==NULL){
			$valor=NULL;
		}
		return $valor;
	}
	public function etiqueta($etiqueta, $termino){
		$this->load->model("correos_model");

		$coincidencias = $this->correos_model->buscar_coincidencias($termino);
		if(isset($coincidencias)){
			$data = array(
				'eti_nombre' => $etiqueta
				);
			$etiqueta_id = $this->ver_guardar('eti_id',$data,'mail_etiqueta',$data);
			foreach ($coincidencias->result_array() as $row)
			{
				echo $row['des_id'].PHP_EOL;
				$data = array(
					'id_eti' => $etiqueta_id,
					'id_destinatario' =>  $row['des_id']
					);
				$this->ver_guardar('etas_id',$data,'mail_eti_asignados',$data);
			}
		}
		
	}

	public function csv($csv){
		$this->load->model("correos_model");
		
		$fila = 1;
		if (($gestor = fopen($csv, "r")) !== FALSE) {
			while (($datos = fgetcsv($gestor, 1000, ",")) !== FALSE) {

				$t_eruc		= $datos[0];
				$t_erazon	= $datos[1];
				$t_eciiu	= $datos[2];
				$t_etipo	= $datos[3];
				$t_enombre	= $datos[4];
				$t_ecorreo	= $datos[5];
				$t_eweb		= $datos[6];

				$t_dccodigo     = $datos[7];
				$t_dccargo	= $datos[8];
				$t_dtitulo	= $datos[9];
				$t_dnombre	= $datos[10];
				$t_dapellido_p	= $datos[11];
				$t_dapellido_m	= $datos[12];
				$t_dcorreo      = $datos[13];

				$t_esector_esp = $datos[14];
				$t_esector_ing = $datos[15];
				$t_esubsector_esp = $datos[16];
				$t_esubsector_esp_det = $datos[17];
				$t_esubsector_ing_det = $datos[18];
				$t_egrupo = $datos[19];
				$t_etamano = $datos[20];

				$numero = count($datos);
				echo "$numero de campos en la línea $fila: ".PHP_EOL;
				$fila++;
                                   
                                if($t_dnombre!=NULL &&  $t_dapellido_p!=NULL){
                                    if($t_dcorreo!=NULL){
                                        //Creamos tipo
                                        if($t_etipo==NULL){
                                            $t_etipo="Varios";
                                        }
                                        $data = array(
                                                'etip_nombre' => $t_etipo
                                                );
                                        $tipo = $this->ver_guardar('etip_id',$data,'mail_emp_tipo',$data);


                                        //Creamos grupo
                                        if($t_egrupo!=NULL){
                                                $data = array(
                                                        'egru_nombre' => $t_egrupo
                                                        );
                                                $grupo = $this->ver_guardar('egru_id',$data,'mail_emp_grupo',$data);
                                        }else{
                                                $grupo = NULL;
                                        }

                                        //Creamos tamano
                                        $data = array(
                                                'etam_nombre' => $t_etamano
                                                );
                                        $tamano = $this->ver_guardar('etam_id',$data,'mail_emp_tamano',$data);


                                        //Creamos sector
                                        $data = array(
                                                'esec_nombre_esp' => $t_esector_esp,
                                                'esec_nombre_ing' =>  $t_esector_ing
                                                );
                                        $sector=$this->ver_guardar('esec_id',$data,'mail_emp_sector',$data);

                                        //Creamos subsector
                                        $data = array(
                                                'esub_nombre_esp' => $t_esubsector_esp,
                                                'esub_detalle_esp' => $t_esubsector_esp_det,
                                                'esub_detalle_ing' =>  $t_esubsector_ing_det,
                                                'esub_ciiu' =>  $t_eciiu,
                                                'id_esec' => $sector
                                                );
                                        $subsector = $this->ver_guardar('esub_id',$data,'mail_emp_subsector',$data);

                                        //Creamos cargo
                                        if($t_dccargo!=NULL){
                                            $data = array(
                                                    'dcar_codigo' => $t_dccodigo,
                                                    'dcar_nombre' =>  $t_dccargo
                                                    );
                                            $cargo = $this->ver_guardar('dcar_id',$data,'mail_des_cargo',$data);
                                        }else{
                                            $cargo = NULL;
                                        }


                                        //Creamos empresa

                                        $t_enombre	= $this->nulo($t_enombre);
                                        $t_ecorreo	= $this->nulo($t_ecorreo);
                                        $t_eweb	= $this->nulo($t_eweb);

                                        $data = array(
                                                'emp_ruc' => $t_eruc,
                                                'emp_nombre' => $t_enombre,
                                                'emp_razon' =>  $t_erazon,
                                                'emp_web' =>  $t_eweb,
                                                'emp_correo' =>  $t_ecorreo,
                                                'emp_tamano_id' =>  $tamano,
                                                'emp_grupo_id' =>  $grupo,
                                                'emp_tipo_id' =>  $tipo,
                                                'emp_subsector_id' => $subsector
                                                );
                                        $empresa = $this->ver_guardar('emp_id',$data,'mail_empresa',$data);

                                        
                                        //Creamos titulo
                                        if($t_dtitulo==NULL){
                                            $t_dtitulo="Sr(a).";
                                        }
                                        $data = array(
                                                'dtit_nombre' => $t_dtitulo
                                                );
                                        $titulo = $this->ver_guardar('dtit_id',$data,'mail_des_titulo',$data);

                                        //Creamos destinatario

                                        $t_dapellido_m	= $this->nulo($t_dapellido_m);
                                        $t_dcorreo	= $this->nulo($t_dcorreo);

                                        $data = array(
                                                'id_dcar' =>  $cargo,
                                                'id_dtit' =>  $titulo,
                                                'des_nombre' =>  $t_dnombre,
                                                'des_apellidopaterno' =>  $t_dapellido_p,
                                                'des_apellidomaterno' =>  $t_dapellido_m,
                                                'des_correo' =>  $t_dcorreo,
                                                'id_emp' => $empresa
                                                );
                                        //$this->correos_model->guardar('mail_destinatario',$data);
                                        $empresa = $this->ver_guardar('des_id',$data,'mail_destinatario',$data);
                                    }
                                }
			}
			fclose($gestor);
		}

	}
}
