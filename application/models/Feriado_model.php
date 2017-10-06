<?php

class Feriado_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }
    
    /*
    / Tabela feriado
    / ID  | DATA      | DESCRICAO
    / int | timestamp | varchar
    */
    
    //funcao que le a tabela dos feriados
    function ler($info)
    {
        
        if (isset($info['id'])) {
            $this->db->where('id', $info['id']);
            $this->db->limit(1);
            $this->db->select();
        }
        
        $this->db->from('feriado');
        $this->db->order_by('data', 'asc');
        $query = $this->db->get();
        
        return ($query->result_array());
    }
    
    //funcao para adicionar um feriado novo
    function adicionar($info)
    {
        $this->db->insert('feriado', $info);
        $novo_id = $this->db->insert_id();
        return $novo_id;
    }
    
    //funcao para eliminar um feriado
    function apagar($info)
    {
        $this->db->where('id', $info['id']);
        $this->db->delete('feriado');
    }
}

?>