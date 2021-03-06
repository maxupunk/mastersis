<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Medida extends CI_Controller {

    var $mensagem;
    public function __construct() {
        parent::__construct();
        $this->load->model('crud_model');
        $this->load->library(array('form_validation', 'table'));
        $this->auth->check_logged($this->router->class , $this->router->method);
    }


    public function index() {

        $this->form_validation->set_rules('MEDI_NOME', 'UNIDADE DE MEDIDA', 'required|max_length[45]|strtoupper|is_unique[MEDIDAS.MEDI_NOME]');
        $this->form_validation->set_rules('MEDI_SIGLA', 'SIGLA', 'required|max_length[4]|strtoupper|is_unique[MEDIDAS.MEDI_SIGLA]');

        $this->form_validation->set_error_delimiters('<span class="label label-danger">', '</span>');

        
        if ($this->form_validation->run() == TRUE):

            $dados = elements(array('MEDI_NOME', 'MEDI_SIGLA'), $this->input->post());
            if ($this->crud_model->inserir("MEDIDAS", $dados) == TRUE) {
                $this->mensagem = $this->lang->line("msg_cadastro_sucesso");
            } else {
                $this->mensagem = $this->lang->line("msg_cadastro_erro");
            }
        endif;

        $dados = array(
            'tela' => "medida/cadastro",
            'mensagem' => $this->mensagem,
        );
        $this->load->view('contente', $dados);
    }

    public function busca() {
        $busca = $this->input->get('buscar', TRUE);
        $dados = array(
            'tela' => "medida/busca",
            'query' => $this->crud_model->buscar("MEDIDAS", array('MEDI_NOME' => $busca))->result(),
        );
        $this->load->view('contente', $dados);
    }

    public function editar($id_medida) {

        $this->form_validation->set_rules('MEDI_NOME', 'MEDIDA', 'required|max_length[45]');
        $this->form_validation->set_rules('MEDI_SIGLA', 'SIGLA', 'required|max_length[4]');

        $this->form_validation->set_error_delimiters('<span class="label label-danger">', '</span>');

        
        // se for valido ele chama o inserir dentro do produto_model
        if ($this->form_validation->run() == TRUE):

            $dados = elements(array('MEDI_NOME', 'MEDI_SIGLA'), $this->input->post());
            if ($this->crud_model->update("MEDIDAS", $dados, array('MEDI_ID' => $this->input->post('id_medida'))) === TRUE) {
                $this->mensagem = $this->lang->line("msg_editar_sucesso");
            } else {
                $this->mensagem = $this->lang->line("msg_editar_erro");
            }

        endif;

        $dados = array(
            'tela' => "medida/editar",
            'mensagem' => $this->mensagem,
            'query' => $this->crud_model->pega("MEDIDAS", array('MEDI_ID' => $id_medida))->row(),
        );
        $this->load->view('contente', $dados);
    }

    public function excluir($id_medida) {
        
        if ($this->input->post('id_medida') > 0):
            if ($this->crud_model->excluir("MEDIDAS", array('MEDI_ID' => $this->input->post('id_medida'))) === TRUE) {
                $this->mensagem = $this->lang->line("msg_excluir_sucesso");
            } else {
                $this->mensagem = $this->lang->line("msg_excluir_erro");
            }
        endif;

        $dados = array(
            'tela' => "medida/excluir",
            'mensagem' => $this->mensagem,
            'query' => $this->crud_model->pega("MEDIDAS", array('MEDI_ID' => $id_medida))->row(),
        );
        $this->load->view('contente', $dados);
    }

}