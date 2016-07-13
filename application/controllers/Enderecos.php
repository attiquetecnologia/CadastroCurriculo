<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Enderecos extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        
        $this->load->model('Enderecos_model','model',TRUE);
        $this->load->helper('form'); //carrega um helper como web2py
        /** carrega a biblioteca do CodeIgniter responsável pela validação dos forms */
        $this->load->library('form_validation');
    }

    public function index() {
        
        $data['titulo'] = "Enderecos | CRM Pessoal | Attique Tecnologia";
        $data['enderecos'] = $this->model->listar();
        $data['itemActive'] = 'class="active"';
        $this->load->view('header',$data);
        $this->load->view('menu',$data);
        $this->load->view('enderecos/endereco_view',$data);
        $this->load->view('footer');
            
    }
        
    function inserir()  {
        $data['IS_EDITAR'] = FALSE;
    
        $data['dados'] = $this->model->find(1);
        $data['titulo'] = "Cadastro de Enderecos | CRM Pessoal | Attique Tecnologia";
        $this->load->view('header',$data);
        $this->load->view('menu');
        $this->load->view('enderecos/endereco_edit',$data);
        $this->load->view('footer');
    }
     
    function editar($id) {
        $data['IS_EDITAR'] = TRUE;
    
        /* Busca os dados da pessoa que será editada */
        $data['dados'] = $this->model->find($id);

        $data['titulo'] = "Cadastro de Enderecos | CRM Pessoal | Attique Tecnologia";
        
        $this->load->view('header',$data);
        $this->load->view('menu');
        $this->load->view('enderecos/endereco_edit',$data);
        $this->load->view('footer');
    }
    
    function cadastro(){
        
        /** define as tags onde a mensagem de erro será exibida na página */
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger">','</div>');

        /** Define as regras para validação */
        $this->form_validation->set_rules('logradouro','Logradouro:','required|max_length[120]');
        $this->form_validation->set_rules('cep','CEP:','required|max_length[14]');
        $this->form_validation->set_rules('bairro','Bairro:','required|max_length[120]');
        $this->form_validation->set_rules('cidade','Cidade:','required|max_length[120]');
        $this->form_validation->set_rules('uf','UF:','required|max_length[2]');
        
        if ($this->form_validation->run() === FALSE) {
//            echo 'valor de editar '.$this->IS_EDITAR;
            if ($this->input->post('id') != "0") { //se estiver no modo edição
                
                $this->editar($this->input->post('id'));
            } else {
                $this->inserir();
            }
        } else { //se não sucesso!
            /* recebe os dados do form (visão) */
            
            $data['logradouro'] = $this->input->post('logradouro');
            $data['cep'] = $this->input->post('cep');
            $data['bairro'] = $this->input->post('bairro');
            $data['cidade'] = $this->input->post('cidade');
            $data['uf'] = $this->input->post('uf');

            //chama a função insereir do model 
            if ($this->input->post('id') != "0") {
                $data['id'] = $this->input->post('id');
                $this->model->atualizar($data) ? $this->index() : log_message('error','Erro ao inserir endereço!');
            } else {
                $this->model->inserir($data) ? $this->index() : log_message('error','Erro ao inserir endereço!');
            }
        }//fim se validar o form
    }//fim cadastro
            
    public function pesquisar(){
        $data['titulo'] = " | Enderecos | CRM Pessoal | Attique Tecnologia";
        $data['enderecos'] = $this->model->like($this->input->post('pesquisa'));
        $data['itemActive'] = 'class="active"';
        $this->load->view('header',$data);
        $this->load->view('menu',$data);
        $this->load->view('enderecos/endereco_view',$data);
        $this->load->view('footer');
    }
    
    function deletar($id) {

        /* Executa a função deletar do modelo passando como parâmetro o id da pessoa */
        if ($this->model->deletar($id)) {
                $this->index();
        } else {
                log_message('error', 'Erro ao deletar enderecos.');
        }
    }
    
    public function search_cep($cep){
        if (!empty($this->model->findByCep($cep))){
            $reg = $this->model->findByCep($cep);
            
            $dados['sucesso'] = "1";
            $dados['id_endereco'] = (string) $reg[0]->id;
            $dados['logradouro']  = (string) $reg[0]->logradouro;
            $dados['bairro']  = (string) $reg[0]->bairro;
            $dados['cidade']  = (string) $reg[0]->cidade;
            $dados['uf']  = (string) $reg[0]->uf;
        } else {
            $reg = simplexml_load_file("http://cep.republicavirtual.com.br/web_cep.php?formato=xml&cep=" . $cep);
            
            $dados['sucesso'] = (string) $reg->resultado;
            $dados['id_endereco'] = "0";
            $dados['logradouro']     = (string) $reg->tipo_logradouro . ' ' . $reg->logradouro;
            $dados['bairro']  = (string) $reg->bairro;
            $dados['cidade']  = (string) $reg->cidade;
            $dados['uf']  = (string) $reg->uf;
        }
//        var_dump($dados);
        echo json_encode($dados);
    }
}//fim classe
