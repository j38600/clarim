<?php

class Agendamento_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }
    
    /*
    / Tabela agendamento
    / ID  | ID_FICHEIRO |    GDH    | SEMANA
    / int | int         | timestamp | bool
    */
    
    //funcao que le a tabela dos agendamentos
    function ler($info)
    {
        
        if (isset($info['id'])) {
            $this->db->where('id', $info['id']);
            $this->db->limit(1);
            $this->db->select();
            $this->db->from('agendamento');
        } else {
            $this->db->select('ficheiro.*, agendamento.*');
            $this->db->where('semana', $info['semana']);
            $this->db->from('agendamento');
            $this->db->join('ficheiro', 'ficheiro.id = agendamento.id_ficheiro');
            $this->db->order_by('gdh', 'asc');
        }
        $query = $this->db->get();
        return ($query->result_array());
    }
    
    //funcao para adicionar um agendamento novo
    function adicionar($info)
    {
        $this->db->insert('agendamento', $info);
        $novo_id = $this->db->insert_id();
        return $novo_id;
    }
    
    //funcao para eliminar um agendamento
    function apagar($info)
    {
        $this->db->where('id', $info['id']);
        $this->db->delete('agendamento');
    }
}

?>