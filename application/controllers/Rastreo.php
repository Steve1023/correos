<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
error_reporting(E_ALL & ~E_NOTICE);
ini_set("display_errors", 1);
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
    public function index(){
        
    }
    public function track(){
        //verificar_algo($_GET); // Esto podria ser analizar y registrar datos
  header('Content-Type: image/gif');
  readfile('blank.gif');
    }
    public function url(){
        
    }
}
