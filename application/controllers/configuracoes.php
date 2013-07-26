<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Configuracoes extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('crud_model');
        $this->load->library(array('form_validation', 'table'));
    }

    public function index() {
        $dados = array(
            'tela' => "configuracoes",
        );
        $this->load->view('home', $dados);
    }

}