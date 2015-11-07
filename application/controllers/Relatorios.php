<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Relatorios extends CI_Controller {

    var $mensagem;
    public function __construct() {
        parent::__construct();
        $this->load->model('crud_model');
        $this->load->library(array('form_validation', 'table'));
        $this->auth->check_logged($this->router->class , $this->router->method);
    }


    public function index() {

        $dados = array(
            'tela' => "relatorios/relatorios",
            'mensagem' => $this->mensagem,
        );
        $this->load->view('home', $dados);
    }
    
    

}