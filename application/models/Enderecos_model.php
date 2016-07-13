<?php
class Enderecos_model extends CI_Model {
    
    function __construct() {
            parent::__construct();
    }

    function inserir($data){
            return $this->db->insert('enderecos',$data);
    }

    function listar(){
            $query = $this->db->get('enderecos');
            return $query->result();
    }

    function like($pesquisa){
        $array = array('cep' => $pesquisa, 'cidade'=>$pesquisa, 'uf'=>$pesquisa, 'bairro'=>$pesquisa, 'logradouro'=>$pesquisa);
        $this->db->or_like($array);
        $query = $this->db->get('enderecos');
        return $query->result();
    }
    
    function find($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('enderecos');
        return $query->result();
    }

    function findByCep($cep) {
        $this->db->where('cep', $cep);
        $query = $this->db->get('enderecos');
        return $query->result();
    }
    
    function atualizar($data) {
        $this->db->set($data);
        $this->db->where('id', $data['id']);
        return $this->db->update('enderecos');
    }

    function deletar($id) {
        $this->db->where('id', $id);
        return $this->db->delete('enderecos');
    }
}//fim classe