<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Usuario extends CI_Controller {

    var $mensagem;

    public function __construct() {
        parent::__construct();
        $this->load->model('crud_model');
        $this->load->library(array('form_validation', 'table'));
        $this->auth->check_logged($this->router->class, $this->router->method);
    }

    public function index() {
        // validar o formulario
        $this->form_validation->set_rules('PES_NOME', 'CLIENTE', 'required|strtoupper');
        $this->form_validation->set_rules('PES_ID', 'NOME DA PESSOA', 'required|is_unique[USUARIOS.PES_ID]');
        $this->form_validation->set_rules('USUARIO_APELIDO', 'APELIDO', 'required');
        $this->form_validation->set_rules('USUARIO_LOGIN', 'LOGIN', 'required|is_unique[USUARIOS.USUARIO_LOGIN]');
        $this->form_validation->set_rules('USUARIO_SENHA', 'SENHA', 'required');
        $this->form_validation->set_rules('USUARIO_SENHA_RE', 'REPITA A SENHA', 'required|matches[USUARIO_SENHA]');
        $this->form_validation->set_rules('CARG_ID', 'CARGO', 'required');
        $this->form_validation->set_message('is_unique', 'Já existe um usuario com esse %s cadastrado!');

        $this->form_validation->set_error_delimiters('<span class="label label-danger">', '</span>');


        // se for valido ele chama o inserir dentro do produto_model
        if ($this->form_validation->run() == TRUE):

            $formulario = $this->input->post();
            $senha = array('USUARIO_SENHA' => hash("sha512", $formulario['USUARIO_SENHA']));
            $novo_form = array_replace($formulario, $senha);

            $dados = elements(array('PES_ID', 'USUARIO_APELIDO', 'USUARIO_LOGIN', 'USUARIO_SENHA', 'CARG_ID'), $novo_form);
            if ($this->crud_model->inserir('USUARIOS', $dados) === TRUE) {
                $this->mensagem = $this->lang->line("msg_cadastro_sucesso");
            } else {
                $this->mensagem = $this->lang->line("msg_cadastro_erro");
            }

        endif;
        $dados = array(
            'tela' => 'usuario/cadastro',
            'cargos' => $this->crud_model->pega_tudo("CARGOS")->result(),
            'mensagem' => $this->mensagem,
        );
        $this->load->view('contente', $dados);
    }

    public function busca() {
        $busca = $this->input->get('buscar', TRUE);
        $dados = array(
            'tela' => "usuario/busca",
            'query' => $this->crud_model->buscar("USUARIOS", array('USUARIO_APELIDO' => $busca, 'USUARIO_LOGIN' => $busca))->result(),
        );
        $this->load->view('contente', $dados);
    }

    public function editar($id_usuario) {

        $this->form_validation->set_rules('USUARIO_APELIDO', 'APELIDO', 'required');
        $this->form_validation->set_rules('CARG_ID', 'CARGO', 'required');


        $this->form_validation->set_error_delimiters('<span class="label label-danger">', '</span>');


        // se for valido ele chama o inserir dentro do produto_model
        if ($this->form_validation->run() == TRUE):
            $dados = elements(array('USUARIO_APELIDO', 'CARG_ID', 'USUARIO_ESTATUS'), $this->input->post());
            if ($this->crud_model->update("USUARIOS", $dados, array('USUARIO_ID' => $this->input->post('usuario_id'))) === TRUE) {
                $this->mensagem = $this->lang->line("msg_editar_sucesso");
            } else {
                $this->mensagem = $this->lang->line("msg_editar_erro");
            }
        endif;

        $dados = array(
            'tela' => 'usuario/editar',
            'id_usuario' => $id_usuario,
            'usuario' => $this->crud_model->pega("USUARIOS", array('USUARIO_ID' => $id_usuario))->row(),
            'cargos' => $this->crud_model->pega_tudo("CARGOS")->result(),
            'mensagem' => $this->mensagem,
        );
        $this->load->view('contente', $dados);
    }

    public function pegausuario() {
        $busca = $this->input->get('buscar', TRUE);

        $rows = $this->crud_model->buscar("USUARIOS", array('USUARIO_APELIDO' => $busca, 'USUARIO_LOGIN' => $busca))->result();

        $json_array = array();
        foreach ($rows as $row) {
            array_push($json_array, array('id' => $row->USUARIO_ID, 'value' => $row->USUARIO_LOGIN));
        }

        $dados = array(
            'query' => $json_array,
        );

        $this->load->view('json', $dados);
    }

}
