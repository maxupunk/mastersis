<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Venda extends CI_Controller {

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

    public function abrir($id_cliente) {
        $mensagem = NULL;
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
                    $mensagem = $this->lang->line("msg_pedido_erro");
                } else {
                    $id_venda = $this->db->insert_id();
                }
            } else {
                $id_venda = $pedido->PEDIDO_ID;
                $mensagem = "Já existe um pedido em aberto para essse clientes!";
            }
        }
        $dados = array(
            'tela' => 'venda_abrir',
            'id_venda' => $id_venda,
            'cliente' => $this->join_model->endereco_completo($id_cliente)->row(),
            'pedido' => $pedido,
            'mensagem' => $mensagem,
        );
        $this->load->view('contente', $dados);
    }

    public function addproduto($id_pedido, $id_produto) {
        $mensagem = NULL;
        //verifica se o produto existe e tem um estoque maior que zero
        $produto = $this->join_model->produto_estoque($id_produto)->row();
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
                        $mensagem = $this->lang->line("msg_pedido_erro");
                    }
                } else {
                    $mensagem = $this->lang->line("msg_addproduto_existente");
                }
            } else {
                $mensagem = $this->lang->line("msg_pedido_erro");
            }
        } else {
            $mensagem = "Erro:<br> - O produto está com o estoque zerado!<br> - Produto esta desativo.";
        }
        $dados = array(
            'tela' => 'venda_lista',
            'mensagem' => $mensagem,
            'lista_pedido' => $this->join_model->lista_pedido($id_pedido)->result(),
        );
        $this->load->view('contente', $dados);
    }

    public function atualizar($id_pedido, $lista_ped_id, $id_estoque, $quantidade) {
        $mensagem = NULL;
        // verifica se existe o pedido
        $pedido = $this->crud_model->pega("PEDIDO", array('PEDIDO_ID' => $id_pedido))->result();
        if ($pedido != NULL) {
            //verifica se existe a quatidade de produto pedido
            $produto = $this->crud_model->pega("ESTOQUE", array('ESTOQ_ID' => $id_estoque))->row();
            if ($produto->ESTOQ_ATUAL < $quantidade) {
                $mensagem = $this->lang->line("msg_estoque_insuficiente");
                $quantidade = $produto->ESTOQ_ATUAL;
            }
            $atualizar = array('LIST_PED_QNT' => $quantidade);
            $condicao = array('LIST_PED_ID' => $lista_ped_id);
            if ($this->crud_model->update("LISTA_PEDIDO", $atualizar, $condicao) === \FALSE) {
                $mensagem = $this->lang->line("msg_atualuzado_erro");
            }
        } else {
            $mensagem = $this->lang->line("msg_pedido_erro");
        }

        $dados = array(
            'tela' => 'venda_lista',
            'mensagem' => @$mensagem,
            'lista_pedido' => $this->join_model->lista_pedido($id_pedido)->result(),
        );
        $this->load->view('contente', $dados);
    }

    public function excluir($id_pedido, $lista_ped_id) {
        $mensagem = NULL;
        if ($this->crud_model->excluir("LISTA_PEDIDO", array('LIST_PED_ID' => $lista_ped_id)) === TRUE) {
            $mensagem = $this->lang->line("msg_excluir_sucesso");
        } else {
            $mensagem = $this->lang->line("msg_excluir_sucesso");
        }

        $dados = array(
            'tela' => 'venda_lista',
            'mensagem' => $mensagem,
            'lista_pedido' => $this->join_model->lista_pedido($id_pedido)->result(),
        );
        $this->load->view('contente', $dados);
    }

    public function busca() {
        $busca = $_GET['buscar'];
        $dados = array(
            'tela' => "prod_busca",
            'query' => $this->crud_model->buscar("PRODUTOS", array('PRO_ID' => $busca, 'PRO_DESCRICAO' => $busca, 'PRO_CARAC_TEC' => $busca))->result(),
        );
        $this->load->view('contente', $dados);
    }

    public function cansela($id_pedido) {
        $this->geral_model->delete_pedido($id_pedido);
        redirect(base_url() . 'venda');
    }

    public function avista($id_pedido) {
        $pedido = $this->crud_model->pega("PEDIDO", array('PEDIDO_ID' => $id_pedido))->row();

        $dados = array(
            'tela' => "venda_avista",
            'total' => $this->geral_model->total_pedido($id_pedido)->row(),
            'pessoa' => $this->join_model->endereco_completo($pedido->PES_ID)->row(),
            'id_pedido' => $id_pedido,
        );
        $this->load->view('contente', $dados);
    }

    public function fecha_pedido($id_pedido) {
        $mensagem = NULL;
        ini_set('memory_limit', '32M');

        $pedido = $this->crud_model->pega("PEDIDO", array('PEDIDO_ID' => $id_pedido))->row();

        if ($this->geral_model->fecha_pedido($id_pedido) > 0) {
            $mensagem = 'Venda concluida com sucesso. Os itens foram baixado no estoque!';
        } else {
            $mensagem = 'Esse pedido já foi baixado anteriormente!';
        }

        $dados = array(
            'tela' => "venda_fecha",
            'mensagem' => $mensagem,
            'lista_pedido' => $this->join_model->lista_pedido($id_pedido)->result(),
            'empresa' => $this->crud_model->pega_tudo("EMPRESA")->row(),
            'pessoa' => $this->join_model->endereco_completo($pedido->PES_ID)->row(),
        );
        
        $html = $this->load->view('contente', $dados);
    }

    public function teste() {
        print_r($this->join_model->produto_busca("p")->result());
    }

}