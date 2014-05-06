<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Compra extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $dados = array(
            'tela' => "compras",
        );
        $this->load->view('home', $dados);
    }

    public function abrir($IdVendedor) {

        // se for valido ele chama o inserir dentro do produto_model
        if ($this->crud_model->pega("PESSOAS", array('PES_ID' => $IdVendedor))->row() != NULL) {
            $pedido = $this->crud_model->pega("PEDIDO", array('PES_ID' => $IdVendedor, 'PEDIDO_TIPO' => 'v', 'PEDIDO_ESTATUS' => '1'))->row();
            if ($pedido == NULL) {
                $dados = array(
                    'PES_ID' => $IdVendedor,
                    'USUARIO_ID' => $this->session->userdata('USUARIO_ID'),
                    'PEDIDO_DATA' => date("Y-m-d h:i:s"),
                    'PEDIDO_ESTATUS' => '1',
                    'PEDIDO_LOCAL' => 'l',
                    'PEDIDO_TIPO' => 'v');
                if ($this->crud_model->inserir('PEDIDO', $dados) != TRUE) {
                    $this->mensagem = $this->lang->line("msg_pedido_erro");
                } else {
                    $id_venda = $this->db->insert_id();
                }
            } else {
                $id_venda = $pedido->PEDIDO_ID;
                $this->mensagem = "Já existe um pedido em aberto para essse clientes!";
            }
        }
        $dados = array(
            'tela' => 'venda_abrir',
            'id_venda' => $id_venda,
            'cliente' => $this->join_model->EnderecoCompleto($IdVendedor)->row(),
            'pedido' => $pedido,
            'mensagem' => $this->mensagem,
        );
        $this->load->view('contente', $dados);
    }

}