<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Usuario extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('crud_model');
        $this->load->library(array('form_validation', 'table', 'auth'));
        $this->auth->check_logged($this->router->class, $this->router->method);
        $mensagem = NULL;
    }

    public function index() {

        $dados = array(
            'tela' => "usuario",
        );
        $this->load->view('home', $dados);
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