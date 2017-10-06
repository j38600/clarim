<?php
if ( ! defined('BASEPATH')) {
    exit('No direct script access allowed');
};

class Agenda extends CI_Controller
{
    
    function __construct()
    {
        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('auth', 'refresh');
        } else {
            $this->template->set('title', 'Agendamentos');
            $this->template->set('nav', 'agenda');
            $this->template->set('user', $this->ion_auth->user()->row()->username);
            $this->template->set(
                'admin', ($this->ion_auth->is_admin())? true: false
            );
        }
    }
    
    public function index()
    {
        redirect('agenda/normal', 'refresh');
    }

    public function reduzido()
    {
        $info = array();
        $info['semana'] = 0;
        $info['agendamentos'] = $this->agendamento_model->ler($info);
        $info['admin'] = $this->ion_auth->is_admin();
        $this->template->load('template', 'agenda/reduzido', $info);
    }

    public function normal()
    {
        $info = array();
        $info['semana'] = 1;
        $info['agendamentos'] = $this->agendamento_model->ler($info);
        $info['admin'] = $this->ion_auth->is_admin();
        $this->template->load('template', 'agenda/normal', $info);
    }

    public function feriado($info = '')
    {
        //a info pode ser "novo" ou "id", for para apagar.
        if (is_numeric($info) && ($this->ion_auth->is_admin())) {
            $id = $info;
            unset($info);
            $info = array();
            $info['id'] = $id;
            $feriado = $this->feriado_model->ler($info);
            $feriado = $feriado[0];
            $this->feriado_model->apagar($info);

            //user, accao, agendamento, ficheiro, feriado
            $datetime = explode(" ", $feriado['data']);
            $data = $datetime[0];
            
            $info['user'] = $this->ion_auth->user()->row()->id;
            $info['accao'] = 'Apagou o feriado '.
                $feriado['descricao'].' do dia '.$data;
            $info['agendamento'] = null;
            $info['ficheiro'] = null;
            $info['feriado'] = null;
            $info['tipo'] = 3;
            $this->registo_model->log_escreve($info);

            redirect('agenda/feriado', 'refresh');
        } elseif ($info == 'novo' && ($this->ion_auth->is_admin())) {
            $this->form_validation->set_rules(
                'data', 'Dia do feriado', 'trim|required|xss_clean'
            );
            $this->form_validation->set_rules(
                'descricao', 'Descrição', 'trim|required|xss_clean'
            );
            $this->form_validation->set_message(
                'required', $this->lang->line('form_validation_required')
            );

            if ($this->form_validation->run() == true) {
                
                unset($info);
                $info = array();
                $info = $this->input->post(null, true);
                unset($info['submit']);
                //o valor que vem no post, é o do indice.
                //aqui vou buscar o nome do ficheiro
                $data = $info['data'];
                $info['data'] = $info['data'].' 00:00:00';
                $info['id'] = $this->feriado_model->adicionar($info);

                $info['user'] = $this->ion_auth
                    ->user()->row()->id;
                $info['accao'] = 'adicionou o feriado '.
                    $info['descricao'].', no dia '.$data;
                $info['agendamento'] = null;
                $info['ficheiro'] = null;
                $info['feriado'] = $info['id'];
                $info['tipo'] = 3;
                $this->registo_model->log_escreve($info);

                redirect('agenda/feriado', 'refresh');

            } else {
                $this->template->load('template', 'agenda/novo_feriado', $info);
            }
        } else {
            $info = array();
            $info['feriados'] = $this->feriado_model->ler($info);
            $info['admin'] = $this->ion_auth->is_admin();
            $this->template->load('template', 'agenda/feriado', $info);
        }
    }
    
    public function novo($info = '')
    {
        //novo agendamento
        if (!$this->ion_auth->is_admin()) {
            redirect('clarim', 'refresh');
        }
        $horario = $info;
        unset($info);
        $info = array();
        $info['horario'] = $horario;
        $info['ficheiros'] = $this->clarim_model->ler($info);
        
        $this->form_validation->set_rules(
            'gdh', 'Hora do toque', 'trim|required|xss_clean'
        );
        $this->form_validation->set_message(
            'required', $this->lang->line('form_validation_required')
        );

        if ($this->form_validation->run() == true) {
            unset($info);
            $info = array();
            $info = $this->input->post(null, true);
            unset($info['submit']);
            $hora = $info['gdh'];

            $info['gdh'] = '1951-01-12 '.$info['gdh'].':00';
            //data qem o papa declarou s. gabriel patrono das telecomunicações
            $info['semana'] = ($horario == 'normal') ? 1 : 0;
            $info['id'] = $this->agendamento_model->adicionar($info);
            
            $info['user'] = $this->ion_auth->user()->row()->id;
            $info['accao'] = 'Agendou o toque numero '.$info['id_ficheiro'].
                ' para as '.$hora.' no horário '.$horario;
            $info['agendamento'] = $info['id'];
            $info['ficheiro'] = null;
            $info['feriado'] = null;
            $info['tipo'] = 3;
            $this->registo_model->log_escreve($info);

            redirect('agenda/'.$horario, 'refresh');

        } else {
            $this->template->load('template', 'agenda/novo_agendamento', $info);
        }
    }
    
    public function apagarAgendamento($id)
    {
        if (!$this->ion_auth->is_admin()) {
            redirect('clarim', 'refresh');
        }
        $info = array();
        $info['id'] = $id;
        $agendamento = $this->agendamento_model->ler($info);
        $agendamento = $agendamento[0];
        $horario = ($agendamento['semana']) ? 'normal' : 'reduzido';
        $this->agendamento_model->apagar($info);

        //user, accao, agendamento, ficheiro, feriado
        $datetime = explode(" ", $agendamento['gdh']);
        $time = $datetime[1];
        
        $info['user'] = $this->ion_auth->user()->row()->id;
        $info['accao'] = 'Apagou o agendamento do toque numero '.
        $agendamento['id_ficheiro'].', às '.$time ;
        $info['agendamento'] = null;
        $info['ficheiro'] = null;
        $info['feriado'] = null;
            $info['tipo'] = 3;
        $this->registo_model->log_escreve($info);

        redirect('agenda/'.$horario, 'refresh');
    }
}