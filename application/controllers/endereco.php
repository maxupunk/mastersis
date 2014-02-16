<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Endereco extends CI_Controller {

    var $mensagem;
    public function __construct() {
        parent::__construct();
        $this->load->model(array('crud_model','join_model'));
        $this->load->library(array('form_validation', 'table'));
        $this->auth->check_logged($this->router->class , $this->router->method);
    }

    public function cadastrar(){
        $dados = array(
            'tela' => "endereco",
        );
        $this->load->view('contente', $dados);
    }

    public function bairro() {        
        // validar o formulario
        $this->form_validation->set_rules('BAIRRO_NOME', 'NOME', 'required|max_length[45]|is_unique[BAIRROS.BAIRRO_NOME]');
        $this->form_validation->set_rules('CIDA_ID', 'CIDADE', 'required');

        $this->form_validation->set_error_delimiters('<span class="label label-danger">', '</span>');

        
        if ($this->form_validation->run() == TRUE):

            $dados = elements(array('BAIRRO_NOME', 'CIDA_ID'), $this->input->post());
            if ($this->crud_model->inserir('BAIRROS', $dados) === TRUE) {
                $this->mensagem = $this->lang->line("msg_cadastro_sucesso");
            } else {
                $this->mensagem = $this->lang->line("msg_cadastro_erro");
            }

        endif;

        $dados = array(
            'estados' => $this->crud_model->pega_tudo("ESTADOS")->result(),
            'tela' => 'endereco_bairro',
            'mensagem' => $this->mensagem,
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
                $this->mensagem = $this->lang->line("msg_cadastro_sucesso");
            } else {
                $this->mensagem = $this->lang->line("msg_cadastro_erro");
            }

        endif;

        $dados = array(
            'estados' => $this->crud_model->pega_tudo("ESTADOS")->result(),
            'tela' => 'endereco_rua',
            'mensagem' => $this->mensagem,
        );
        $this->load->view('contente', $dados);
    }

    function pegacidades($id) {

        $cidades = $this->crud_model->pega("CIDADES", array('ESTA_ID' => $id))->result();

        if ($cidades === FALSE) {
            echo '{ "CIDA_ID": "ERRO NO DB" }';
            die();
        }

        if (empty($cidades)) {
            echo '{ "CIDA_ID": "Nenhuma cidade encontrada" }';
            die();
        }
        array_unshift($cidades, array('CIDA_NOME' => 'Selecione a cidade'));
        $dados = array(
            'query' => $cidades,
        );
        $this->load->view('json', $dados);
    }

    function pegabairros($id) {

        $bairros = $this->crud_model->pega("BAIRROS", array('CIDA_ID' => $id))->result();

        if ($bairros === FALSE) {
            echo '[{ "BAIRRO_NOME": "ERRO NO DB" }]';
            die();
        }

        if (empty($bairros)) {
            echo '[{ "BAIRRO_NOME": "Nenhum bairro encontrado" }]';
            die();
        }
        array_unshift($bairros, array('BAIRRO_NOME' => 'Selecione o bairro'));
        $dados = array(
            'query' => $bairros,
        );
        $this->load->view('json', $dados);
    }

    function pegaruas($id) {

        $ruas = $this->crud_model->pega("RUA", array('RUA_ID' => $id))->result();

        if ($ruas === FALSE) {
            echo '[{ "RUA_NOME": "ERRO NO DB" }]';
            die();
        }

        if (empty($ruas)) {
            echo '[{ "RUA_NOME": "Nenhuma rua encontrado" }]';
            die();
        }
        array_unshift($ruas, array('RUA_NOME' => 'Selecione a rua'));
        $dados = array(
            'query' => $ruas,
        );
        $this->load->view('json', $dados);
    }

    public function busca() {
        $busca = $_GET['buscar'];
        $dados = array(
            'tela' => "endereco_busca",
            'busca_rua' => $this->crud_model->buscar("RUA", array('RUA_NOME' => $busca, 'RUA_CEP' => $busca))->result(),
            'busca_bairro' => $this->crud_model->buscar("BAIRROS", array('BAIRRO_NOME' => $busca))->result(),
            'busca_cidade' => $this->crud_model->buscar("CIDADES", array('CIDA_NOME' => $busca))->result(),
            'busca_estado' => $this->crud_model->buscar("ESTADOS", array('ESTA_NOME' => $busca))->result(),
        );
        $this->load->view('contente', $dados);
    }

    }