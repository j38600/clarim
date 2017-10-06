<?php
if ( ! defined('BASEPATH')) {
    exit('No direct script access allowed');
};

class Clarim extends CI_Controller
{
    
    function __construct()
    {
        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('auth', 'refresh');
        } else {
            $this->template->set('title', 'Clarim');
            $this->template->set('nav', 'clarim');
            $this->template->set('user', $this->ion_auth->user()->row()->username);
            $this->template->set(
                'admin', ($this->ion_auth->is_admin())? true: false
            );
        }
    }
    
    public function index($id = '')
    {
        $info = array();
        
        //Se tiver sido clicado um botao, vai a informação para a view
        $info['toque'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        
        $info['ficheiros'] = $this->clarim_model->ler($info);

        $info['admin'] = $this->ion_auth->is_admin();
        
        $this->template->load('template', 'clarim/index', $info);
    }
    
    //funcao para tocar o ficheiro
    public function toque($id = '')
    {
        $info = array();
        $info['id'] = $id;
        $ficheiro = $this->clarim_model->ler($info);
        $ficheiro = $ficheiro[0];

        //o site pára enquanto executa o som... Acho que é bom.
        exec('"'.LOCALIZACAO_VLC.'vlc.exe" --play-and-exit '.LOCALIZACAO_TOQUES.$ficheiro['nome_ficheiro']);
        
        //user, accao, agendamento, ficheiro, feriado
        $info['user'] = $this->ion_auth->user()->row()->id;
        $info['accao'] = 'deu o toque '.$ficheiro['id'].' - '.$ficheiro['nome_curto'];
        $info['agendamento'] = null;
        $info['ficheiro'] = $id;
        $info['feriado'] = null;
        $info['tipo'] = 2;
        $this->registo_model->log_escreve($info);
        
        redirect('clarim/index/'.$id, 'refresh');
    }
    
    //funcao para criar uma entrada nova na tabela ficheiro
    public function novo()
    {
        $this->form_validation->set_rules('nome_curto', 'Nome Curto', 'trim|max_length[50]|required|xss_clean');
        $this->form_validation->set_rules('descricao', 'Descrição', 'trim|required|xss_clean');

        $info['pasta'] = scandir(LOCALIZACAO_TOQUES);
    
        if ($this->form_validation->run() == true) {
            
            //guardo o array com o conteudo da pasta, e o indice do ficheiro no array
            $pasta = $info['pasta'];
            $ficheiro = $this->input->post('nome_ficheiro');

            unset($info);
            $info = array();
            $info = $this->input->post(null, true);
            unset($info['submit']);
            //o valor que vem no post, é o do indice. aqui vou buscar o nome do ficheiro
            $info['nome_ficheiro'] = $pasta[$ficheiro];
            $info['ativo'] = true;
            $info['id'] = $this->clarim_model->adicionar($info);
            
            $info['user'] = $this->ion_auth->user()->row()->id;
            $info['accao'] = 'adicionou o toque '.$info['id'].' - '.$info['nome_curto'];
            $info['agendamento'] = null;
            $info['ficheiro'] = $info['id'];
            $info['feriado'] = null;
            $info['tipo'] = 2;
            $this->registo_model->log_escreve($info);

            redirect('clarim', 'refresh');

        } else {
            $this->template->load('template', 'clarim/novo', $info);
        }
    }
    
    //funcao para matar o vlc
    public function parar()
    {
        exec('taskkill /IM vlc.exe /F');

        $info['user'] = $this->ion_auth->user()->row()->id;
        $info['accao'] = 'Deu a ordem para parar os toques.';
        $info['agendamento'] = null;
        $info['ficheiro'] = null;
        $info['feriado'] = null;
        $info['tipo'] = 2;
        $this->registo_model->log_escreve($info);

        redirect('clarim', 'refresh');
    }
    
    //funcao para alterar a visibilidade do ficheiro
    public function visivel($id)
    {
        if (!$this->ion_auth->is_admin()) {
            redirect('clarim', 'refresh');
        }
        $info = array();
        $info['id'] = $id;
        $ficheiro = $this->clarim_model->ler($info);
        $ficheiro = $ficheiro[0];
        $info['ativo'] = !$ficheiro['ativo'];
        $this->clarim_model->visibilidade($info);
        
        //user, accao, agendamento, ficheiro, feriado
        $info['user'] = $this->ion_auth->user()->row()->id;
        $accao = ($info['ativo']) ? 'Disponibilizou': 'Escondeu';
        $info['accao'] = $accao.' o ficheiro '.$ficheiro['id'].' - '.$ficheiro['nome_curto'];
        $info['agendamento'] = null;
        $info['ficheiro'] = $ficheiro['id'];
        $info['feriado'] = null;
        $info['tipo'] = 2;
        $this->registo_model->log_escreve($info);
        
        redirect('clarim', 'refresh');
    }
    
    //funcao para apagar uma entrada na tabela ficheiro
    public function apagar($id)
    {
        if (!$this->ion_auth->is_admin()) {
            redirect('clarim', 'refresh');
        }
        $info = array();
        $info['id'] = $id;
        $ficheiro = $this->clarim_model->ler($info);
        $ficheiro = $ficheiro[0];
        
        $this->clarim_model->apagar($info);

        //user, accao, agendamento, ficheiro, feriado
        $info['user'] = $this->ion_auth->user()->row()->id;
        $info['accao'] = 'Apagou o ficheiro '.$ficheiro['id'].' - '.$ficheiro['nome_curto'];
        $info['agendamento'] = null;
        $info['ficheiro'] = null;
        $info['feriado'] = null;
        $info['tipo'] = 2;
        $this->registo_model->log_escreve($info);

        redirect('clarim', 'refresh');
    }
    
}