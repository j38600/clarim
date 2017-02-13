<?php
if ( ! defined('BASEPATH')) {
    exit('No direct script access allowed');
};

class Cron extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('agendamento_model');
        $this->load->model('feriado_model');
    }
    
    public function normal()
    {
        $gdh = date("Y-m-d H:i:s");
        $dia_semana = (date('N') < 6) ? 1 : 0;
        $info = array();
        $feriados = $this->feriado_model->ler($info);
        
        if ($dia_semana) {
            foreach ($feriados as $feriado) {
                if (!strncmp($gdh, $feriado['data'], 10)) {
                    $dia_semana = 0;
                    break;
                };
            }
        }
        $info['semana'] = $dia_semana;
        $agendamentos = $this->agendamento_model->ler($info);
        foreach ($agendamentos as $agendamento) {
            $datetime = explode(" ", $agendamento['gdh']);
            $tempo = substr($agendamento['gdh'], 11, -3);
            if (!substr_compare($gdh, $tempo, 11, 5)) {
                exec('"'.LOCALIZACAO_VLC.'vlc.exe" --play-and-exit '.LOCALIZACAO_TOQUES.$agendamento['nome_ficheiro']);
                break;
            };
        }
    }
}