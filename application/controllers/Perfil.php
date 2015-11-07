<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Perfil extends CI_Controller {

    var $mensagem;

    public function __construct() {
        parent::__construct();
        $this->load->model(array('crud_model', 'join_model', 'geral_model'));
        $this->load->library(array('form_validation'));
        $this->auth->check_logged($this->router->class, $this->router->method);
    }

    public function index() {
        $dados = array(
            'tela' => "perfil/perfil",
        );
        $this->load->view('home', $dados);
    }

}
