<?php

class Clarim_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }
    
    /*
    / Tabela ficheiro
    / ID  | NOME_FICHEIRO | NOME_CURTO | DESCRICAO | ATIVO
    / int | varchar       | varchar    | varchar   | bool
    */
    
    //funcao que le a tabela dos ficheiros
    function ler($info)
    {
        
        if (isset($info['id'])) {
            $this->db->where('id', $info['id']);
            $this->db->limit(1);
            $this->db->select();
        }
        
        $this->db->from('ficheiro');
        $query = $this->db->get();
        
        return ($query->result_array());
    }
    
    //funcao para adicionar um toque novo
    function adicionar($info)
    {
        $this->db->insert('ficheiro', $info);
        $novo_id = $this->db->insert_id();
        return $novo_id;

    }
    
    //funcao para eliminar um toque
    function apagar($info)
    {
        $this->db->where('id', $info['id']);
        $this->db->delete('ficheiro');
    }
    
    //funcao para alterar estado de visibilidade de ficheiro
    function visibilidade($info)
    {
        $this->db->where('id', $info['id']);
        $this->db->update('ficheiro', array('ativo' => $info['ativo'])); 
    
    }
}

?>