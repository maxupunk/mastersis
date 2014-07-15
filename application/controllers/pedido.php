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

    public function index() {}

    public function addproduto($id_pedido, $id_produto) {
        //verifica se o produto existe e tem um estoque maior que zero
        $produto = $this->join_model->ProdutoEstoque($id_produto)->row();
        if ($produto != NULL and $produto->ESTOQ_ATUAL >= 1 and $produto->PRO_ESTATUS === 'a') {
            //verifica se existe realmente um pedido com o id passado
            $pedido = $this->crud_model->pega("PEDIDOS", array('PEDIDO_ID' => $id_pedido, 'PEDIDO_ESTATUS' => '1'))->row();
            if ($pedido != NULL) {
                //verififca se já existe o prodoto na lista de pedido
                $lista_pedido = $this->crud_model->pega("LISTA_PRODUTOS", array('ESTOQ_ID' => $produto->ESTOQ_ID, 'PEDIDO_ID' => $id_pedido))->row();
                if ($lista_pedido == NULL) {
                    //inseri os dados abaixo no db
                    $dados = array(
                        'PEDIDO_ID' => $id_pedido,
                        'ESTOQ_ID' => $produto->ESTOQ_ID,
                        'LIST_PED_QNT' => '1',
                        'LIST_PED_PRECO' => $produto->ESTOQ_PRECO);
                    if ($this->crud_model->inserir('LISTA_PRODUTOS', $dados) != TRUE) {
                        $this->mensagem = $this->lang->line("msg_pedido_erro");
                    }
                } else {
                    $this->mensagem = "O item já existe, se deseja altera quantidades, click em uma das setas em QUANTIDADE.";
                }
            } else {
                $this->mensagem = "O pedido não existe ou já foi fechado!";
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

    public function atualizar($id_pedido, $lista_ped_id = null, $id_estoque = null, $quantidade = null) {

        // verifica se existe o pedido
        if ($lista_ped_id != NULL and $id_estoque != null and $quantidade != null) {
            $pedido = $this->crud_model->pega("PEDIDOS", array('PEDIDO_ID' => $id_pedido))->result();
            if ($pedido != NULL) {
                //verifica se existe a quatidade de produto pedido
                $produto = $this->crud_model->pega("ESTOQUES", array('ESTOQ_ID' => $id_estoque))->row();
                if ($produto->ESTOQ_ATUAL < $quantidade AND $produto->ESTOQ_MIN != -1) {
                    $this->mensagem = $this->lang->line("msg_estoque_insuficiente");
                    $quantidade = $produto->ESTOQ_ATUAL;
                }
                $atualizar = array('LIST_PED_QNT' => $quantidade);
                $condicao = array('LIST_PED_ID' => $lista_ped_id);
                if ($this->crud_model->update("LISTA_PRODUTOS", $atualizar, $condicao) === \FALSE) {
                    $this->mensagem = $this->lang->line("msg_atualuzado_erro");
                }
            } else {
                $this->mensagem = $this->lang->line("msg_pedido_erro");
            }
        }

        $dados = array(
            'tela' => 'venda_itens',
            'mensagem' => @$this->mensagem,
            'lista_pedido' => $this->join_model->ListaPedido($id_pedido)->result(),
            'total' => $this->geral_model->TotalPedido($id_pedido)->row(),
        );
        $this->load->view('contente', $dados);
    }

    public function updlista($id_pedido) {

        // verifica se existe o pedido
        $pedido = $this->crud_model->pega("PEDIDOS", array('PEDIDO_ID' => $id_pedido))->result();
        if ($pedido != NULL) {
            $dados = array(
                'tela' => 'venda_itens',
                'mensagem' => @$this->mensagem,
                'lista_pedido' => $this->join_model->ListaPedido($id_pedido)->result(),
                'total' => $this->geral_model->TotalPedido($id_pedido)->row(),
            );
        } else {
            $dados = array(
                'tela' => 'venda_itens',
                'mensagem' => @$this->mensagem,
                'lista_pedido' => NULL,
            );
        }

        $this->load->view('contente', $dados);
    }

    public function excluiritem($id_pedido, $lista_ped_id) {

        if ($this->crud_model->excluir("LISTA_PRODUTOS", array('LIST_PED_ID' => $lista_ped_id)) != TRUE) {
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
        $pedido = $this->crud_model->pega("PEDIDOS", array('PEDIDO_ID' => $id_pedido))->row();
        if ($pedido->PEDIDO_ESTATUS <= 1) {
            $this->geral_model->ExcluirPedido($id_pedido);
            $this->session->set_flashdata('mensagem', "Pedido excluido com sucesso!");
        } else {
            if ($this->geral_model->ReabrirPedido($id_pedido) >= 1) {
                if ($this->geral_model->ExcluirPedido($id_pedido) == TRUE) {
                    $this->session->set_flashdata('mensagem', "Pedido reaberto e excluido!");
                }
            }
        }
        redirect(base_url() . 'venda');
    }


}