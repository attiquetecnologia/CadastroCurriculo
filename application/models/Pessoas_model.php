<?php
class Pessoas_model extends CI_Model {
    function __construct() {
        parent::__construct();
    }

    function inserir($data){
        return $this->db->insert('pessoas',$data);
    }

    function listar(){
        $this->db->select("p.*,e.cep,e.logradouro,e.cidade,e.uf,e.bairro");
        $this->db->from("pessoas p");
        $this->db->join("enderecos e","p.endereco_id = e.id",'left');
        $query = $this->db->get();
        return $query->result();
    }

    function find($id) {
        $this->db->select("p.*,e.cep,e.logradouro,e.cidade,e.uf,e.bairro");
        $this->db->from("pessoas p");
        $this->db->join("enderecos e","p.endereco_id = e.id",'left');
        $this->db->where('p.id', $id);
        $query = $this->db->get();
        return $query->result();
    }

    function like($pesquisa){
        $this->db->select("p.*,e.cep,e.logradouro,e.cidade,e.uf,e.bairro");
        $this->db->from("pessoas p");
        $this->db->join("enderecos e","p.endereco_id = e.id",'left');
        $array = array('nome'=>$pesquisa,'sobrenome'=>$pesquisa,'cep' => $pesquisa, 'cidade'=>$pesquisa, 'uf'=>$pesquisa, 'bairro'=>$pesquisa, 'logradouro'=>$pesquisa);
        $this->db->or_like($array);
        $query = $this->db->get();
        return $query->result();
    }
    
    function atualizar($data) {
        $this->db->where('id', $data['id']);
        $this->db->set($data);
        return $this->db->update('pessoas');
    }

    function deletar($id) {
        $this->db->where('id', $id);
        return $this->db->delete('pessoas');
    }
    
}//fim classe