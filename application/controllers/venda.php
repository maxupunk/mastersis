<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Venda extends CI_Controller {

    var $mensagem;

    public function __construct() {
        parent::__construct();
        $this->load->model(array('crud_model', 'join_model', 'geral_model'));
        $this->load->library(array('form_validation', 'table'));
        $this->auth->check_logged($this->router->class, $this->router->method);
    }

    public function index() {
        $dados = array(
            'tela' => "venda",
        );
        $this->load->view('home', $dados);
    }

    public function cliente($id_cliente) {

        $dados = array(
            'tela' => 'venda_cliente',
            'cliente' => $this->join_model->EnderecoCompleto($id_cliente)->row(),
            'mensagem' => $this->mensagem,
        );
        $this->load->view('contente', $dados);
    }

    public function abrir($id_cliente) {

        // se for valido ele chama o inserir dentro do produto_model
        if ($this->crud_model->pega("PESSOAS", array('PES_ID' => $id_cliente))->row() != NULL) {
            $pedido = $this->crud_model->pega("PEDIDO", array('PES_ID' => $id_cliente, 'PEDIDO_TIPO' => 'v', 'PEDIDO_ESTATUS' => '1'))->row();
            if ($pedido == NULL) {
                $dados = array(
                    'PES_ID' => $id_cliente,
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
            'cliente' => $this->join_model->EnderecoCompleto($id_cliente)->row(),
            'pedido' => $pedido,
            'mensagem' => $this->mensagem,
        );
        $this->load->view('contente', $dados);
    }

    public function addproduto($id_pedido, $id_produto) {

        //verifica se o produto existe e tem um estoque maior que zero
        $produto = $this->join_model->ProdutoEstoque($id_produto)->row();
        if ($produto != NULL and $produto->ESTOQ_ATUAL >= 1 and $produto->PRO_ESTATUS === 'a') {
            //verifica se existe realmente um pedido com o id passado
            $pedido = $this->crud_model->pega("PEDIDO", array('PEDIDO_ID' => $id_pedido))->row();
            if ($pedido != NULL) {
                //verififca se já existe o prodoto na lista de pedido
                $lista_pedido = $this->crud_model->pega("LISTA_PEDIDO", array('ESTOQ_ID' => $produto->ESTOQ_ID, 'PEDIDO_ID' => $id_pedido))->row();
                if ($lista_pedido == NULL) {
                    //inseri os dados abaixo no db
                    $dados = array(
                        'PEDIDO_ID' => $id_pedido,
                        'ESTOQ_ID' => $produto->ESTOQ_ID,
                        'LIST_PED_QNT' => '1',
                        'LIST_PED_PRECO' => $produto->ESTOQ_PRECO);
                    if ($this->crud_model->inserir('LISTA_PEDIDO', $dados) != TRUE) {
                        $this->mensagem = $this->lang->line("msg_pedido_erro");
                    }
                } else {
                    $this->mensagem = $this->lang->line("msg_addproduto_existente");
                }
            } else {
                $this->mensagem = $this->lang->line("msg_pedido_erro");
            }
        } else {
            $this->mensagem = "Erro:<br> - O produto está com o estoque zerado!<br> - Produto esta desativo.";
        }
        $dados = array(
            'tela' => 'venda_itens',
            'mensagem' => $this->mensagem,
            'lista_pedido' => $this->join_model->ListaPedido($id_pedido)->result(),
            'total' => $this->geral_model->TotalPedido($id_pedido)->row(),
        );
        $this->load->view('contente', $dados);
    }

    public function atualizar($id_pedido, $lista_ped_id, $id_estoque, $quantidade) {

        // verifica se existe o pedido
        $pedido = $this->crud_model->pega("PEDIDO", array('PEDIDO_ID' => $id_pedido))->result();
        if ($pedido != NULL) {
            //verifica se existe a quatidade de produto pedido
            $produto = $this->crud_model->pega("ESTOQUE", array('ESTOQ_ID' => $id_estoque))->row();
            if ($produto->ESTOQ_ATUAL < $quantidade) {
                $this->mensagem = $this->lang->line("msg_estoque_insuficiente");
                $quantidade = $produto->ESTOQ_ATUAL;
            }
            $atualizar = array('LIST_PED_QNT' => $quantidade);
            $condicao = array('LIST_PED_ID' => $lista_ped_id);
            if ($this->crud_model->update("LISTA_PEDIDO", $atualizar, $condicao) === \FALSE) {
                $this->mensagem = $this->lang->line("msg_atualuzado_erro");
            }
        } else {
            $this->mensagem = $this->lang->line("msg_pedido_erro");
        }

        $dados = array(
            'tela' => 'venda_itens',
            'mensagem' => @$this->mensagem,
            'lista_pedido' => $this->join_model->ListaPedido($id_pedido)->result(),
            'total' => $this->geral_model->TotalPedido($id_pedido)->row(),
        );
        $this->load->view('contente', $dados);
    }

    public function excluiritem($id_pedido, $lista_ped_id) {

        if ($this->crud_model->excluir("LISTA_PEDIDO", array('LIST_PED_ID' => $lista_ped_id)) === TRUE) {
            $this->mensagem = $this->lang->line("msg_excluir_sucesso");
        } else {
            $this->mensagem = $this->lang->line("msg_excluir_sucesso");
        }

        $dados = array(
            'tela' => 'venda_itens',
            'mensagem' => $this->mensagem,
            'total' => $this->geral_model->TotalPedido($id_pedido)->row(),
            'lista_pedido' => $this->join_model->ListaPedido($id_pedido)->result(),
        );
        $this->load->view('contente', $dados);
    }

    public function excluirpedido($id_pedido) {
        $this->geral_model->ExcluirPedido($id_pedido);
        redirect(base_url() . 'venda');
    }

    public function avista($id_pedido) {
        $pedido = $this->crud_model->pega("PEDIDO", array('PEDIDO_ID' => $id_pedido))->row();

        $dados = array(
            'tela' => "venda_avista",
            'total' => $this->geral_model->TotalPedido($id_pedido)->row(),
            'pessoa' => $this->join_model->EnderecoCompleto($pedido->PES_ID)->row(),
            'id_pedido' => $id_pedido,
        );
        $this->load->view('contente', $dados);
    }

    public function fechapedido($id_pedido) {

        $pedido = $this->crud_model->pega("PEDIDO", array('PEDIDO_ID' => $id_pedido))->row();

        if ($this->geral_model->FechaPedido($id_pedido) > 0) {
            $this->mensagem = 'Venda concluida com sucesso!';
        } else {
            $this->mensagem = 'Esse pedido já foi fchado anteriormente!';
        }

        $dados = array(
            'tela' => "venda_fecha",
            'mensagem' => $this->mensagem,
            'pedido' => $this->crud_model->pega("PEDIDO", array('PEDIDO_ID' => $id_pedido))->row(),
            'lista_pedido' => $this->join_model->ListaPedido($id_pedido)->result(),
            'total' => $this->geral_model->TotalPedido($id_pedido)->row(),
            'empresa' => $this->crud_model->pega_tudo("EMPRESA")->row(),
            'pessoa' => $this->join_model->EnderecoCompleto($pedido->PES_ID)->row(),
        );

        $this->load->view('contente', $dados);
    }

    public function listar($id_cliente) {

        $this->load->library('pagination');
        $config['base_url'] = base_url('venda/listar/' . $id_cliente);
        $config['total_rows'] = $this->geral_model->PedidosCliente($id_cliente)->num_rows();
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
            'pedidos_cliente' => $this->geral_model->PedidosCliente($id_cliente, $config['per_page'], $inicial)->result(),
            'tela' => 'venda_listar',
            'paginacao' => $this->pagination->create_links(),
        );
        $this->load->view('contente', $dados);
    }

}