<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Servico extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('crud_model');
        $this->load->library(array('form_validation', 'table'));
    }

    public function index() {

        $dados = array(
            'tela' => "servico",
        );
        $this->load->view('home', $dados);
    }

    public function cadastrar() {

        $this->form_validation->set_rules('SERV_NOME', 'DESCRIÇÃO DO SERVICO', 'required|max_length[45]|strtoupper|is_unique[SERVICOS.SERV_NOME]');
        $this->form_validation->set_rules('SERV_VALOR', 'VALOR', 'required|max_length[11]');
        $this->form_validation->set_rules('SERV_DESC', 'DESCERIÇÃO', 'required');

        $this->form_validation->set_error_delimiters('<p class="text-error">', '</p>');

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
                $mensagem = $this->lang->line("msg_cadastro_sucesso");
            } else {
                $mensagem = $this->lang->line("msg_cadastro_erro");
            }
        endif;

        $dados = array(
            'tela' => "serv_cadastro",
            'mensagem' => @$mensagem,
        );
        $this->load->view('contente', $dados);
    }

    public function listar() {
        $this->load->library('pagination');

        $config['base_url'] = base_url('servico/listar');
        $config['total_rows'] = $this->crud_model->pega_tudo('SERVICOS')->num_rows();
        $config['per_page'] = 10;
        $quant = $config['per_page'];

        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="disabled"><a>';
        $config['cur_tag_close'] = '</a></li>';
        $config['next_link'] = '&gt;';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['prev_link'] = '&lt;';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';

        $this->uri->segment(3) != '' ? $inicial = $this->uri->segment(3) : $inicial = 0;

        $this->pagination->initialize($config);

        $dados = array(
            'servico' => $this->crud_model->pega_tudo("SERVICOS", $quant, $inicial)->result(),
            'tela' => 'serv_listar',
            'total' => $this->crud_model->pega_tudo("SERVICOS")->num_rows(),
            'paginacao' => $this->pagination->create_links(),
        );
        $this->load->view('contente', $dados);
    }

    public function busca() {
        $dados = array(
            'tela' => "serv_busca",
        );
        $this->load->view('contente', $dados);
    }

    public function editar() {

        $this->form_validation->set_rules('SERV_NOME', 'NOME SERVICO', 'required|max_length[45]');

        $this->form_validation->set_error_delimiters('<p class="text-error">', '</p>');

        // se for valido ele chama o inserir dentro do produto_model
        if ($this->form_validation->run() == TRUE):

            $dados = elements(array('SERV_NOME', 'SERV_DESC', 'SERV_ESTATUS'), $this->input->post());
            if ($this->crud_model->update("SERVICOS", $dados, array('SERV_ID' => $this->input->post('id_servico'))) === TRUE) {
                $mensagem = $this->lang->line("msg_editar_sucesso");
            } else {
                $mensagem = $this->lang->line("msg_editar_erro");
            }

        endif;

        $dados = array(
            'tela' => "serv_editar",
            'mensagem' => @$mensagem,
        );
        $this->load->view('contente', $dados);
    }

    public function excluir() {
        if ($this->input->post('id_servico') > 0):
            if ($this->crud_model->excluir("SERVICOS", array('SERV_ID' => $this->input->post('id_servico'))) === TRUE) {
                $mensagem = $this->lang->line("msg_excluir_sucesso");
            } else {
                $mensagem = $this->lang->line("msg_excluir_erro");
            }
        endif;

        $dados = array(
            'tela' => "serv_excluir",
            'mensagem' => @$mensagem,
        );
        $this->load->view('contente', $dados);
    }

}