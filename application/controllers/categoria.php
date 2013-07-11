<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Categoria extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('categoria_model');
        $this->load->library(array('form_validation', 'table'));
    }

    public function index() {

        $dados = array(
            'tela' => "categoria",
        );
        $this->load->view('home', $dados);
    }

    public function cadastrar() {

        $this->form_validation->set_rules('CATE_NOME', 'CATEGORIA', 'required|max_length[20]|strtoupper|is_unique[CATEGORIA.CATE_NOME]');
        $this->form_validation->set_message('is_unique', 'Essa %s já esta cadastrado no banco de dados!');

        if ($this->form_validation->run() == TRUE):

            $dados = elements(array('CATE_NOME', 'CATE_DESCRIC'), $this->input->post());
            $this->categoria_model->inserir($dados);
        endif;

        $dados = array(
            'tela' => "categ_cadastro",
        );
        $this->load->view('contente', $dados);
    }

    public function listar() {

        $dados = array(
            'tela' => "categ_listar",
        );
        $this->load->view('contente', $dados);
    }

}