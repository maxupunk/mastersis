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

    public function abrir($IdFornecedor) {

        // se for valido ele chama o inserir dentro do produto_model
        if ($this->crud_model->pega("PESSOAS", array('PES_ID' => $IdFornecedor))->row() != NULL) {
            $pedido = $this->crud_model->pega("PEDIDOS", array('PES_ID' => $IdFornecedor, 'PEDIDO_TIPO' => 'c', 'PEDIDO_ESTATUS' => '1'))->row();
            if ($pedido == NULL) {
                $dados = array(
                    'PES_ID' => $IdFornecedor,
                    'USUARIO_ID' => $this->session->userdata('USUARIO_ID'),
                    'PEDIDO_DATA' => date("Y-m-d h:i:s"),
                    'PEDIDO_ESTATUS' => '1',
                    'PEDIDO_LOCAL' => 'l',
                    'PEDIDO_TIPO' => 'c');
                if ($this->crud_model->inserir('PEDIDOS', $dados) == TRUE) {
                    $pedido_id = $this->db->insert_id();
                } else {
                    $this->mensagem = "Erro ao grava pedido no banco de dados!";
                }
            } else {
                $pedido_id = $pedido->PEDIDO_ID;
                $this->mensagem = "Já existe um pedido em aberto para essse fornecedor!";
            }
        }
        $dados = array(
            'tela' => 'compras_fornecedor',
            'IdPed' => $pedido_id,
            'cliente' => $this->join_model->EnderecoCompleto($IdFornecedor)->row(),
            'LstProd' => $this->join_model->ListaPedido($pedido_id)->result(),
            'Total' => $this->geral_model->TotalPedido($pedido_id)->row(),
            'pedido' => $pedido,
            'tipo' => "c",
            'mensagem' => $this->mensagem,
        );
        $this->load->view('contente', $dados);
    }
    
    public function listar() {

        $this->load->library('pagination');
        $config['base_url'] = base_url('compras/listar');
        $config['total_rows'] = $this->geral_model->PedidosFornecedor()->num_rows();
        $config['per_page'] = 10;
        $config['uri_segment'] = 3;
        $config['num_links'] = 30;

        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="disabled"><a>';
        $config['cur_tag_close'] = '</a></li>';
        $config['next_link'] = '&gt;';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['prev_link'] = '&lt;';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['first_link'] = 'Primeira';
        $config['last_link'] = 'Ultima';

        $this->uri->segment(3) != '' ? $inicial = $this->uri->segment(3) : $inicial = 0;

        $this->pagination->initialize($config);


        $dados = array(
            'pedidos_cliente' => $this->geral_model->PedidosFornecedor($config['per_page'], $inicial, 'PEDIDO_DATA desc')->result(),
            'tela' => 'compras_listar',
            'paginacao' => $this->pagination->create_links(),
        );
        $this->load->view('contente', $dados);
    }

}