<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Usuario extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('crud_model');
        $this->load->library(array('form_validation', 'table'));
        $this->auth->check_logged($this->router->class, $this->router->method);
    }

    public function index() {

        $dados = array(
            'tela' => "usuario",
        );
        $this->load->view('home', $dados);
    }

    public function cadastrar() {
        // validar o formulario
        $this->form_validation->set_rules('PES_ID', 'NOME DA PESSOA', 'required|is_unique[USUARIO.PES_ID]');
        $this->form_validation->set_message('is_unique', 'Essa %s já esta cadastrada como usuario!');
        $this->form_validation->set_rules('USUARIO_APELIDO', 'APELIDO', 'required');
        $this->form_validation->set_rules('USUARIO_LOGIN', 'LOGIN', 'required');
        $this->form_validation->set_rules('USUARIO_SENHA', 'SENHA', 'required');
        $this->form_validation->set_rules('USUARIO_SENHA_RE', 'REPITA A SENHA', 'required|matches[USUARIO_SENHA]');

        $this->form_validation->set_error_delimiters('<span class="label label-danger">', '</span>');

        $mensagem = NULL;
        // se for valido ele chama o inserir dentro do produto_model
        if ($this->form_validation->run() == TRUE):

            $dados = elements(array('PRO_DESCRICAO', 'PRO_CARAC_TEC', 'CATE_ID', 'MEDI_ID', 'PRO_PESO'), $this->input->post());
            if ($this->crud_model->inserir('PRODUTOS', $dados) === TRUE) {
                $mensagem = $this->lang->line("msg_cadastro_sucesso");
            } else {
                $mensagem = $this->lang->line("msg_cadastro_erro");
            }

        endif;
        $dados = array(
            'tela' => 'usuario_cadastro',
            'cargos' => $this->crud_model->pega_tudo("CARGOS")->result(),
            'mensagem' => $mensagem,
        );
        $this->load->view('contente', $dados);
    }

    public function pegausuario() {
        $busca = $_GET['buscar'];

        $rows = $this->crud_model->buscar("USUARIO", array('USUARIO_APELIDO' => $busca, 'USUARIO_LOGIN' => $busca))->result();

        $json_array = array();
        foreach ($rows as $row)
            array_push($json_array, array('id' => $row->USUARIO_ID, 'value' => $row->USUARIO_LOGIN));

        $dados = array(
            'query' => $json_array,
        );

        $this->load->view('json', $dados);
    }

}