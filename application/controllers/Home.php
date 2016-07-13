<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index()
	{
            parent::__construct();
            $data['titulo'] = "CRM Pessoal | Attique Tecnologia";
            $data['itemActive'] = 'class="active"';
            $this->load->view('header',$data);
            $this->load->view('menu',$data);
            $this->load->view('index');//este elemento é o conteudo da pagina
            $this->load->view('footer');
	}

	public function info() {
    	phpinfo();
    	exit();
	}
}
