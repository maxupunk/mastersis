<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Relatorios extends CI_Controller {

    var $mensagem;

    public function __construct() {
        parent::__construct();
        $this->load->model(array('crud_model','join_model'));
        $this->load->library(array('form_validation', 'table'));
        $this->auth->check_logged($this->router->class, $this->router->method);
    }

    public function index() {

        $dados = array(
            'tela' => "relatorios/relatorios",
            'mensagem' => $this->mensagem,
        );
        $this->load->view('home', $dados);
    }


    public function Vendas() {
        // validar o formulario
        $this->form_validation->set_rules('DataInicial', 'Data inicial', 'required');
        $this->form_validation->set_rules('DataFinal', 'Data Final', 'required');

        // se for valido ele chama o inserir dentro do produto_model
        if ($this->form_validation->run() == TRUE) {
            
            $post = $this->input->post();
            print_r($post);
            
            switch ($post['LstTotal']) {
                case 'l':
                    $tela = 'relatorios/vendas_lst';
                    break;
                case 't':
                    $tela = 'relatorios/vendas_total';
                    break;
            }
            
            $dados = array(
                'tela' => $tela,
                '' => $post,
                'pedidos' => $this->geral_model->PedidosPessoa('PEDIDO_DATA desc')->result(),
            );
            
        } else {
            $dados = array(
                'tela' => 'relatorios/vendas_form',
                'mensagem' => validation_errors(),
                'FormaPg' => $this->crud_model->pega_tudo("FORMA_PG")->result(),
            );
        }

        $this->load->view('contente', $dados);
    }
    
    public function teste(){
        $this->output->enable_profiler(TRUE);
        echo "<pre>";
        print_r($this->join_model->PedidosPorUsuario()->result());
    }

}
