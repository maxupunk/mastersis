<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Servico extends CI_Controller {

    var $mensagem;

    public function __construct() {
        parent::__construct();
        $this->load->model('crud_model');
        $this->load->library(array('form_validation', 'table'));
        $this->auth->check_logged($this->router->class, $this->router->method);
    }

    public function index() {

        $this->form_validation->set_rules('SERV_NOME', 'DESCRIÇÃO DO SERVICO', 'required|max_length[45]|strtoupper|is_unique[SERVICOS.SERV_NOME]');
        $this->form_validation->set_message('is_unique', 'Essa %s já esta cadastrado no banco de dados!');
        $this->form_validation->set_rules('SERV_VALOR', 'VALOR', 'required|max_length[11]');
        $this->form_validation->set_rules('SERV_DESC', 'DESCERIÇÃO', 'required');

        $this->form_validation->set_error_delimiters('<span class="label label-danger">', '</span>');


        if ($this->form_validation->run() == TRUE):

            $formulario = $this->input->post();
            $source = array('.', ',');
            $replace = array('', '.');
            $valor = $formulario['SERV_VALOR'];
            $custo = str_replace($source, $replace, $valor);
            $atualiza = array('SERV_VALOR' => $custo);
            $novo_form = array_replace($formulario, $atualiza);

            $dados = elements(array('SERV_NOME', 'SERV_DESC', 'SERV_VALOR'), $novo_form);
            if ($this->crud_model->inserir("SERVICOS", $dados) == TRUE) {
                $this->mensagem = $this->lang->line("msg_cadastro_sucesso");
            } else {
                $this->mensagem = $this->lang->line("msg_cadastro_erro");
            }
        endif;

        $dados = array(
            'tela' => "serv_cadastro",
            'mensagem' => $this->mensagem,
        );
        $this->load->view('contente', $dados);
    }

    public function busca() {
        $busca = $_GET['buscar'];
        $dados = array(
            'tela' => "serv_busca",
            'query' => $this->crud_model->buscar("SERVICOS", array('SERV_ID' => $busca, 'SERV_NOME' => $busca))->result(),
        );
        $this->load->view('contente', $dados);
    }

    public function editar() {

        $this->form_validation->set_rules('SERV_NOME', 'NOME SERVICO', 'required|max_length[45]');

        $this->form_validation->set_error_delimiters('<span class="label label-danger">', '</span>');


        // se for valido ele chama o inserir dentro do produto_model
        if ($this->form_validation->run() == TRUE):

            $dados = elements(array('SERV_NOME', 'SERV_DESC', 'SERV_ESTATUS'), $this->input->post());
            if ($this->crud_model->update("SERVICOS", $dados, array('SERV_ID' => $this->input->post('id_servico'))) === TRUE) {
                $this->mensagem = $this->lang->line("msg_editar_sucesso");
            } else {
                $this->mensagem = $this->lang->line("msg_editar_erro");
            }

        endif;

        $dados = array(
            'tela' => "serv_editar",
            'mensagem' => $this->mensagem,
        );
        $this->load->view('contente', $dados);
    }

    public function excluir($id_servico) {

        if ($this->input->post('id_servico') > 0):
            if ($this->crud_model->excluir("SERVICOS", array('SERV_ID' => $this->input->post('id_servico'))) === TRUE) {
                $this->mensagem = $this->lang->line("msg_excluir_sucesso");
            } else {
                $this->mensagem = $this->lang->line("msg_excluir_erro");
            }
        endif;

        $dados = array(
            'tela' => "serv_excluir",
            'mensagem' => $this->mensagem,
            'query' => $this->crud_model->pega("SERVICOS", array('SERV_ID' => $id_servico))->row(),
        );
        $this->load->view('contente', $dados);
    }

    public function pegaproduto() {
        $busca = $_GET['buscar'];
        $rows = $this->crud_model->buscar("SERVICOS", array('SERV_ID' => $busca, 'SERV_NOME' => $busca))->result();

        setlocale(LC_MONETARY, "pt_BR");

        $json_array = array();
        foreach ($rows as $row)
            array_push($json_array, array('id' => $row->SERV_ID, 'value' => $row->SERV_NOME . ' | ' . money_format('%n', $row->SERV_VALOR)));

        $dados = array(
            'query' => $json_array,
        );


        $this->load->view('json', $dados);
    }

}