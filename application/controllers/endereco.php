<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Endereco extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('crud_model');
        $this->load->library(array('form_validation', 'table'));
    }

    public function index() {
        $dados = array(
            'tela' => "endereco",
        );
        $this->load->view('home', $dados);
    }

    public function bairro() {
        // validar o formulario
        $this->form_validation->set_rules('BAIRRO_NOME', 'NOME', 'required|max_length[45]|is_unique[BAIRROS.BAIRRO_NOME]');
        $this->form_validation->set_rules('CIDA_ID', 'CIDADE', 'required');

        $this->form_validation->set_error_delimiters('<span class="label label-danger">', '</span>');

        if ($this->form_validation->run() == TRUE):

            $dados = elements(array('BAIRRO_NOME', 'CIDA_ID'), $this->input->post());
            if ($this->crud_model->inserir('BAIRROS', $dados) === TRUE) {
                $mensagem = $this->lang->line("msg_cadastro_sucesso");
            } else {
                $mensagem = $this->lang->line("msg_cadastro_erro");
            }

        endif;

        $dados = array(
            'estados' => $this->crud_model->pega_tudo("ESTADOS")->result(),
            'tela' => 'endereco_bairro',
            'mensagem' => @$mensagem,
        );
        $this->load->view('contente', $dados);
    }

    
    public function rua() {
        // validar o formulario
        $this->form_validation->set_rules('RUA_NOME', 'NOME', 'required|max_length[45]|is_unique[RUA.RUA_NOME]');
        $this->form_validation->set_rules('RUA_CEP', 'CEP', 'required');
        $this->form_validation->set_rules('BAIRRO_ID', 'BAIRRO', 'required');

        $this->form_validation->set_error_delimiters('<span class="label label-danger">', '</span>');

        if ($this->form_validation->run() == TRUE):

            $dados = elements(array('RUA_NOME', 'RUA_CEP', 'BAIRRO_ID'), $this->input->post());
            if ($this->crud_model->inserir('RUA', $dados) === TRUE) {
                $mensagem = $this->lang->line("msg_cadastro_sucesso");
            } else {
                $mensagem = $this->lang->line("msg_cadastro_erro");
            }

        endif;

        $dados = array(
            'estados' => $this->crud_model->pega_tudo("ESTADOS")->result(),
            'tela' => 'endereco_rua',
            'mensagem' => @$mensagem,
        );
        $this->load->view('contente', $dados);
    }

    
    function pegacidades($id) {

        $cidades = $this->crud_model->pega("CIDADES", array('ESTA_ID' => $id))->result();

        if ($cidades === FALSE){
            echo '{ "nome": "ERRO NO DB" }';
            exit();
        }
        
        if (empty($cidades)){
            echo '{ "nome": "Nenhuma cidade encontrada" }';
            exit();
        }

        $arr_cidade = array();
        foreach ($cidades as $cidade) {
            $arr_cidade[] = '{"id":' . $cidade->CIDA_ID . ',"nome":"' . $cidade->CIDA_NOME . '"}';
        }

        echo '[ {"nome":"Selecione a cidade"}, ' . implode(",", $arr_cidade) . ']';
    }

    
    function pegabairros($id) {

        $bairros = $this->crud_model->pega("BAIRROS", array('CIDA_ID' => $id))->result();

        if ($bairros === FALSE){
            echo '[{ "nome": "ERRO NO DB" }]';
            exit();
        }
        
        if (empty($bairros)){
            echo '[{ "nome": "Nenhum bairro encontrado" }]';
            exit();
        }

        $arr_bairros = array();
        foreach ($bairros as $bairro) {
            $arr_bairros[] = '{"id":' . $bairro->BAIRRO_ID . ',"nome":"' . $bairro->BAIRRO_NOME . '"}';
        }

        echo '[ {"nome":"Selecione o bairro"}, ' . implode(",", $arr_bairros) . ']';
    }

    
    function pegaruas($id) {

        $ruas = $this->crud_model->pega("RUA", array('RUA_ID' => $id))->result();

        if ($ruas === FALSE){
            echo '[{ "nome": "ERRO NO DB" }]';
            exit();
        }
        
        if (empty($ruas)){
            echo '[{ "nome": "Nenhuma rua encontrado" }]';
            exit();
        }

        $arr_ruas = array();
        foreach ($ruas as $ruas) {
            $arr_ruas[] = '{"id":' . $ruas->RUA_ID . ',"nome":"' . $ruas->RUA_NOME . '"}';
        }

        echo '[ {"nome":"Selecione a rua"}, ' . implode(",", $arr_ruas) . ']';
    }

    public function busca() {
        $dados = array(
            'tela' => "endereco_busca",
        );
        $this->load->view('contente', $dados);
    }

}