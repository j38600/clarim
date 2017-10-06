<?php
if ( ! defined('BASEPATH')) {
    exit('No direct script access allowed');
};

class Registo extends CI_Controller
{
    
    function __construct()
    {
        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('auth', 'refresh');
        } elseif (!$this->ion_auth->is_admin()) {
            redirect('clarim', 'refresh');
        } else {
            $this->template->set('title', 'Históricos');
            $this->template->set('nav', 'registo');
            $this->template->set('user', $this->ion_auth->user()->row()->username);
            $this->template->set('admin', ($this->ion_auth->is_admin())? true: false);
        }
    }
    
    public function index()
    {
        redirect('registo/automaticos', 'refresh');
    }

    public function automaticos()
    {
        $info = array();
        $info['obter'] = 'automaticos';
        $info['registos'] = $this->registo_model->ler($info);
        $info['admin'] = $this->ion_auth->is_admin();
        $this->template->load('template', 'registos/automaticos', $info);
    }

    public function manuais()
    {
        $info = array();
        $info['obter'] = 'manuais';
        $info['registos'] = $this->registo_model->ler($info);
        $info['admin'] = $this->ion_auth->is_admin();
        $this->template->load('template', 'registos/manuais', $info);
    }

    public function agendamentos()
    {
        $info = array();
        $info['obter'] = 'agendamentos';
        $info['registos'] = $this->registo_model->ler($info);
        $info['admin'] = $this->ion_auth->is_admin();
        $this->template->load('template', 'registos/agendamentos', $info);
    }
}