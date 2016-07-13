<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pessoas extends CI_Controller {
    /** Variável para controle de insersao
     * É utilizada para saber se o formulário esta em modo edição e/ou inserção
     */
    private $IS_EDITAR;
    
    public function __construct() {
        parent::__construct();
        
        $this->load->model('Pessoas_model','pessoa_model',TRUE);
        $this->load->model('Enderecos_model','endereco_model',TRUE);
        $this->load->helper('form','date'); //carrega um helper como web2py
        /** carrega a biblioteca do CodeIgniter responsável pela validação dos forms */
        $this->load->library('form_validation');
        $this->IS_EDITAR = FALSE;
    }

    public function index() {
        $data['titulo'] = "Pessoas | CRM Pessoal | Attique Tecnologia";
        $data['pessoas'] = $this->pessoa_model->listar();
        $data['itemActive'] = 'class="active"';
        $this->load->view('header',$data);
        $this->load->view('menu',$data);
        $this->load->view('pessoas/pessoa_view',$data);
        $this->load->view('footer');

    }
        
    function inserir()  {
        $data['IS_EDITAR'] = $this->IS_EDITAR;
        $data['dados'] = $this->pessoa_model->find(1);
        $data['titulo'] = "Cadastro de Pessoas | CRM Pessoal | Attique Tecnologia";
        $this->load->view('header',$data);
        $this->load->view('menu');
        $this->load->view('pessoas/pessoa_edit',$data);
        $this->load->view('footer');
    }
     
    function editar($id) {
        $data['IS_EDITAR'] = $this->IS_EDITAR = TRUE;
        /* Busca os dados da pessoa que será editada */
        $data['dados'] = $this->pessoa_model->find($id);

        $data['titulo'] = "Cadastro de Pessoas | CRM Pessoal | Attique Tecnologia";
        
        $this->load->view('header',$data);
        $this->load->view('menu');
        $this->load->view('pessoas/pessoa_edit',$data);
        $this->load->view('footer');
    }
    
    function cadastro(){
        
        /** define as tags onde a mensagem de erro será exibida na página */
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger">','</div>');

        /** Define as regras para validação */
        $this->form_validation->set_rules('nome','Nome:','required|max_length[120]');
        $this->form_validation->set_rules('sobrenome','Sobrenome:','required|max_length[100]');
        
        $this->form_validation->set_rules('logradouro','Logradouro:','required|max_length[120]');
        $this->form_validation->set_rules('cep','CEP:','required|max_length[14]');
        $this->form_validation->set_rules('bairro','Bairro:','required|max_length[120]');
        $this->form_validation->set_rules('cidade','Cidade:','required|max_length[120]');
        $this->form_validation->set_rules('uf','UF:','required|max_length[2]');
        
        //tenta validar o formulário, caso não consiga retorna com os erros de validação
        if ($this->form_validation->run() === FALSE) {
            if ($this->IS_EDITAR) { //se estiver no modo edição
                $this->editar($this->input->post('id'));
            } else {
                $this->inserir();
            }
        } else { //se não tenta inserir!
            /* recebe os dados do form (visão) */
            $pes['nome'] = $this->input->post('nome');
            $pes['sobrenome'] = $this->input->post('sobrenome');
            $pes['contato'] = $this->input->post('contato');
            $pes['numero_endereco'] = $this->input->post('numero_endereco');
            $pes['endereco_id'] = $this->input->post('endereco_id');
            
            $end['id'] = $this->input->post('endereco_id');
            $end['logradouro'] = $this->input->post('logradouro');
            $end['cep'] = $this->input->post('cep');
            $end['bairro'] = $this->input->post('bairro');
            $end['cidade'] = $this->input->post('cidade');
            $end['uf'] = $this->input->post('uf');
            
            //se o endereço não existir insere o endereço e depois 
            //atualiza o id para a variável de pessoa
            if (empty($this->endereco_model->findByCep($end['cep']))){
        
                $this->endereco_model->inserir($end);
                $pes['endereco_id'] = $this->endereco_model->findByCep($end['cep']);
            } 
            
            //chama a função insereir do model se for nova pessoa
            if ($this->input->post('id') == '0') {
                //se inserir pessoa volta para index, se não retorna um erro em logs
                $this->pessoa_model->inserir($pes) ? $this->index() : log_message('error','Erro ao inserir pessoa!');
            } else {
                $pes['id'] = $this->input->post('id');
                $this->pessoa_model->atualizar($pes) ? $this->index() : log_message('error','Erro ao inserir pessoa!');
            }
        }//fim se validar o form
    }//fim cadastro
            
    function deletar($id) {

        /* Executa a função deletar do modelo passando como parâmetro o id da pessoa */
        if ($this->pessoa_model->deletar($id)) {
                redirect('endereco');
        } else {
                log_message('error', 'Erro ao deletar enderecos.');
        }
    }

    public function pesquisar(){
        
        $data['pessoas'] = $this->pessoa_model->like($this->input->post('pesquisa'));
        $this->load->view('header',$data);
        $this->load->view('menu',$data);
        $this->load->view('pessoas/pessoa_view',$data);
        $this->load->view('footer');
    }
    
    public function search_cep($cep){
        if (!empty($this->endereco_model->findByCep($cep))){
            $reg = $this->endereco_model->findByCep($cep);
            
            $dados['sucesso'] = "1";
            $dados['endereco_id'] = (string) $reg[0]->id;
            $dados['logradouro']  = (string) $reg[0]->logradouro;
            $dados['bairro']  = (string) $reg[0]->bairro;
            $dados['cidade']  = (string) $reg[0]->cidade;
            $dados['uf']  = (string) $reg[0]->uf;
        } else {
            $reg = simplexml_load_file("http://cep.republicavirtual.com.br/web_cep.php?formato=xml&cep=" . $cep);
            
            $dados['sucesso'] = (string) $reg->resultado;
            $dados['endereco_id'] = "0";
            $dados['logradouro']     = (string) $reg->tipo_logradouro . ' ' . $reg->logradouro;
            $dados['bairro']  = (string) $reg->bairro;
            $dados['cidade']  = (string) $reg->cidade;
            $dados['uf']  = (string) $reg->uf;
        }
        
        echo json_encode($dados);
    }
}//fim classe
