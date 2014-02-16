<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cadastros extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index(){
        $dados = array(
            'tela' => "cadastro",
        );
        $this->load->view('home', $dados);
    }
}