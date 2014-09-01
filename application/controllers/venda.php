<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Venda extends CI_Controller {

    var $mensagem;

    public function __construct() {
        parent::__construct();
        $this->load->model(array('crud_model', 'join_model', 'geral_model'));
        $this->load->library(array('form_validation', 'table', 'convert'));
        $this->auth->check_logged($this->router->class, $this->router->method);
    }

    public function index() {
        $dados = array(
            'tela' => "venda",
        );
        $this->load->view('home', $dados);
    }

    public function Cliente($IdCliente) {

        $dados = array(
            'tela' => 'venda_cliente',
            'mensagem' => $this->mensagem,
            'cliente' => $this->join_model->EnderecoCompleto($IdCliente)->row(),
        );
        $this->load->view('contente', $dados);
    }

    public function Abrir($IdCliente) {

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
                if ($this->crud_model->inserir('PEDIDOS', $dados) == TRUE) {
                    $pedido_id = $this->db->insert_id();
                } else {
                    $this->mensagem = "Erro ao grava pedido no banco de dados!";
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
            'LstProd' => $this->join_model->ListaPedido($pedido_id)->result(),
            'Total' => $this->geral_model->TotalPedido($pedido_id)->row(),
            'pedido' => $pedido,
            'mensagem' => $this->mensagem,
        );
        $this->load->view('contente', $dados);
    }


    public function Pagamento($id_pedido) {
        $pedido = $this->crud_model->pega("PEDIDOS", array('PEDIDO_ID' => $id_pedido))->row();

        $dados = array(
            'tela' => "venda_pagar",
            'total' => $this->geral_model->TotalPedido($id_pedido)->row(),
            'pessoa' => $this->join_model->EnderecoCompleto($pedido->PES_ID)->row(),
            'id_pedido' => $id_pedido,
        );
        $this->load->view('contente', $dados);
    }

    public function FechaPedido($id_pedido) {

        $pedido = $this->crud_model->pega("PEDIDOS", array('PEDIDO_ID' => $id_pedido))->row();

        if ($this->geral_model->FechaPedido($id_pedido) > 0) {
            $this->mensagem = 'Venda concluida com sucesso!';
        } else {
            $this->mensagem = 'Esse pedido já foi fchado anteriormente!';
        }

        $dados = array(
            'tela' => "venda_fecha",
            'mensagem' => $this->mensagem,
            'pedido' => $this->crud_model->pega("PEDIDOS", array('PEDIDO_ID' => $id_pedido))->row(),
            'lista_pedido' => $this->join_model->ListaPedido($id_pedido)->result(),
            'total' => $this->geral_model->TotalPedido($id_pedido)->row(),
            'empresa' => $this->crud_model->pega_tudo("EMPRESAS")->row(),
            'pessoa' => $this->join_model->EnderecoCompleto($pedido->PES_ID)->row(),
        );

        $this->load->view('contente', $dados);
    }

    public function Listar($IdCliente) {

        $this->load->library('pagination');
        $config['base_url'] = base_url('venda/listar/' . $IdCliente);
        $config['total_rows'] = $this->geral_model->PedidosCliente($IdCliente)->num_rows();
        $config['per_page'] = 10;
        $config['uri_segment'] = 4;
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

        $this->uri->segment(4) != '' ? $inicial = $this->uri->segment(4) : $inicial = 0;

        $this->pagination->initialize($config);


        $dados = array(
            'pedidos_cliente' => $this->geral_model->PedidosCliente($IdCliente, $config['per_page'], $inicial, 'PEDIDO_DATA desc')->result(),
            'tela' => 'venda_listar',
            'paginacao' => $this->pagination->create_links(),
        );
        $this->load->view('contente', $dados);
    }

}