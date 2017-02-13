<?php

class Registo_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }
    /*
    / Tabela log
    / ID  | USER | GDH     | IP_MAQUINA | ACCAO  | FICHEIRO | AGENDAMENTO | FERIADO |TIPO
    / int | int  |timestamp| varchar    | varchar| int      | int         | int     | int
    */
    
    function log_escreve ($info)
    {
        //$info tem que trazer 5 variaveis dentro dela...
        $this->db->set('user', $info['user']);
        $mysqltime = date("Y-m-d H:i:s");
        $this->db->set('gdh', $mysqltime);
        $this->db->set('ip_maquina', gethostbyaddr($_SERVER['REMOTE_ADDR']));
        $this->db->set('accao', $info['accao']);
        $this->db->set('ficheiro', $info['ficheiro']);
        $this->db->set('agendamento', $info['agendamento']);
        $this->db->set('feriado', $info['feriado']);
        $this->db->set('tipo', $info['tipo']);
        $this->db->insert('log');
        
        return true;
    }

    function ler($info)
    {
        
        switch ($info['obter']){
        case('automaticos'):
            $this->db->where('tipo', '1');
            break;
        case('manuais'):
            $this->db->where('tipo', 2);
            break;
        case('agendamentos'):
            $this->db->where('tipo', 3);
            break;
        }
        $this->db->select('log.*, users.username');
        $this->db->from('log');
        $this->db->join('users', 'log.user = users.id');
        $this->db->order_by('gdh', 'desc');
        $query = $this->db->get();

        return ($query->result_array());
    }
}

?>