<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Permissoes extends CI_Controller {

    var $mensagem;

    public function __construct() {
        parent::__construct();
        $this->load->model('crud_model');
        $this->load->library(array('form_validation', 'table'));
        $this->auth->check_logged($this->router->class, $this->router->method);
    }

    public function index() {

        $dados = array(
            'tela' => "permissoes/permissoes",
        );
        $this->load->view('home', $dados);
    }

    public function gerenciar($id_usuario) {
        $rows = $this->crud_model->pega("PERMISSOES", array('USUARIO_ID' => $id_usuario))->result();
        $array = array();
        foreach ($rows as $row)
            array_push($array, $row->METOD_ID);

        $dados = array(
            'tela' => 'permissoes/gerenciar',
            'usuario' => $this->crud_model->pega("USUARIOS", array('USUARIO_ID' => $id_usuario))->row(),
            'permissoes' => $array,
            'metodos' => $this->crud_model->pega_tudo("METODOS", "0", "0", "METOD_CLASS asc")->result(),
        );
        $this->load->view('contente', $dados);
    }

    public function Adiciona() {

        $this->form_validation->set_rules('USU_ID', 'USUARIO', 'required');
        $this->form_validation->set_rules('METOD_ID', 'METODO', 'required');

        if ($this->form_validation->run() == TRUE) {
            $post = $this->input->post();

            $dados = array(
                'USUARIO_ID' => $post['USU_ID'],
                'METOD_ID' => $post['METOD_ID']);
            if ($this->crud_model->inserir('PERMISSOES', $dados) !== TRUE) {
                $this->mensagem = "Erro: Erro ao grava no banco de dados";
            }

            $this->load->view('json', array('query' => $this->mensagem));
        }
    }

    public function Remove() {

        $this->form_validation->set_rules('USU_ID', 'USUARIO', 'required');
        $this->form_validation->set_rules('METOD_ID', 'METODO', 'required');

        if ($this->form_validation->run() == TRUE) {
            $post = $this->input->post();

            if ($this->crud_model->excluir("PERMISSOES", array('USUARIO_ID' => $post['USU_ID'], 'METOD_ID' => $post['METOD_ID'])) !== TRUE) {
                $this->mensagem = "Erro: Erro ao apagar no banco de dados";
            }

            $this->load->view('json', array('query' => $this->mensagem));
        }
    }

    public function RemoveTodas() {

        $this->form_validation->set_rules('USU_ID', 'USU_ID', 'required');

        if ($this->form_validation->run() == TRUE) {
            $post = $this->input->post();

            if ($this->crud_model->excluir("PERMISSOES", array('USUARIO_ID' => $post['USU_ID'])) !== TRUE) {
                $this->mensagem = "Erro: Erro ao apagar no banco de dados";
            }

            $this->load->view('json', array('query' => $this->mensagem));
        }
    }

}
