<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Compras extends CI_Controller {
    
    var $mensagem;

    public function __construct() {
        parent::__construct();
        $this->load->model(array('crud_model', 'join_model', 'geral_model'));
        $this->load->library(array('form_validation', 'table', 'convert'));
        $this->auth->check_logged($this->router->class, $this->router->method);
    }

    public function index() {
        $dados = array(
            'tela' => "compras",
        );
        $this->load->view('home', $dados);
    }

    public function fornecedor() {

        $dados = array(
            'tela' => 'compras_fornecedor',
        );
        $this->load->view('contente', $dados);
    }

    public function abrir($IdCliente) {

        // se for valido ele chama o inserir dentro do produto_model
        if ($this->crud_model->pega("PESSOAS", array('PES_ID' => $IdCliente))->row() != NULL) {
            $pedido = $this->crud_model->pega("PEDIDOS", array('PES_ID' => $IdCliente, 'PEDIDO_TIPO' => 'v', 'PEDIDO_ESTATUS' => '1'))->row();
            if ($pedido == NULL) {
                $dados = array(
                    'PES_ID' => $IdCliente,
                    'USUARIO_ID' => $this->session->userdata('USUARIO_ID'),
                    'PEDIDO_DATA' => date("Y-m-d h:i:s"),
                    'PEDIDO_ESTATUS' => '1',
                    'PEDIDO_LOCAL' => 'l',
                    'PEDIDO_TIPO' => 'v');
                if ($this->crud_model->inserir('PEDIDOS', $dados) != TRUE) {
                    $this->mensagem = $this->lang->line("msg_pedido_erro");
                } else {
                    $pedido_id = $this->db->insert_id();
                }
            } else {
                $pedido_id = $pedido->PEDIDO_ID;
                $this->mensagem = "Já existe um pedido em aberto para essse clientes!";
            }
        }
        $dados = array(
            'tela' => 'venda_abrir',
            'pedido_id' => $pedido_id,
            'cliente' => $this->join_model->EnderecoCompleto($IdCliente)->row(),
            'lista_pedido' => $this->join_model->ListaPedido($pedido_id)->result(),
            'total' => $this->geral_model->TotalPedido($pedido_id)->row(),
            'pedido' => $pedido,
            'mensagem' => $this->mensagem,
        );
        $this->load->view('contente', $dados);
    }

}