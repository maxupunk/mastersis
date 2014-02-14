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
            'tela' => "permissoes",
        );
        $this->load->view('home', $dados);
    }

    public function gerenciar($id_usuario) {
        $rows = $this->crud_model->pega("PERMISSOES", array('USUARIO_ID' => $id_usuario))->result();
        $array = array();
        foreach ($rows as $row)
            array_push($array, $row->METOD_ID);

        $dados = array(
            'tela' => 'permissoes_gerenciar',
            'usuario' => $this->crud_model->pega("USUARIO", array('USUARIO_ID' => $id_usuario))->row(),
            'permissoes' => $array,
            'metodos' => $this->crud_model->pega_tudo("METODOS", "0", "0", "METOD_CLASS asc")->result(),
        );
        $this->load->view('contente', $dados);
    }

    public function inserir($id_usuario, $id_metodo) {
        
        if ($this->crud_model->pega("PERMISSOES", array('USUARIO_ID' => $id_usuario, 'METOD_ID' => $id_metodo))->row() == NULL) {
            $dados = array(
                'USUARIO_ID' => $id_usuario,
                'METOD_ID' => $id_metodo);
            if ($this->crud_model->inserir('PERMISSOES', $dados) === TRUE) {
                $this->mensagem = $this->lang->line("msg_permissao_add_sucesso");
            } else {
                $this->mensagem = $this->lang->line("msg_permissao_add_erro");
            }

            $dados = array(
                'tela' => "permissoes_mensagem",
                'mensagem' => $this->mensagem,
            );
            $this->load->view('contente', $dados);
        }
    }

    public function retirar($id_usuario, $id_metodo) {
        
        if ($this->crud_model->pega("PERMISSOES", array('USUARIO_ID' => $id_usuario, 'METOD_ID' => $id_metodo))->row() != NULL) {

            if ($this->crud_model->excluir("PERMISSOES", array('USUARIO_ID' => $id_usuario, 'METOD_ID' => $id_metodo)) === TRUE) {
                $this->mensagem = $this->lang->line("msg_permissao_rm_sucesso");
            } else {
                $this->mensagem = $this->lang->line("msg_permissao_rm_erro");
            }

            $dados = array(
                'tela' => "permissoes_mensagem",
                'mensagem' => $this->mensagem,
            );
            $this->load->view('contente', $dados);
        }
    }

}