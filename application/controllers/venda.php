<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Venda extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('crud_model', 'join_model'));
        $this->load->library(array('form_validation', 'table'));
    }

    public function index() {
        $dados = array(
            'tela' => "venda",
        );
        $this->load->view('home', $dados);
    }

    public function abrir($id_cliente) {
        // se for valido ele chama o inserir dentro do produto_model
        if ($this->crud_model->pega("PESSOAS", array('PES_ID' => $id_cliente))->row() != NULL) {
            $pedido = $this->crud_model->pega("PEDIDO", array('PES_ID' => $id_cliente, 'PEDIDO_TIPO' => 'v', 'PEDIDO_ESTATUS' => '1'))->row();
            if ($pedido == NULL) {
                $dados = array(
                    'PES_ID' => $id_cliente,
                    //'USU_ID' => '',
                    'PEDIDO_DATA' => date("Y-m-d h:i:s"),
                    'PEDIDO_ESTATUS' => '1',
                    'PEDIDO_TIPO' => 'v');
                if ($this->crud_model->inserir('PEDIDO', $dados) != TRUE) {
                    $mensagem = $this->lang->line("msg_pedido_erro");
                } else {
                    $id_venda = $this->db->insert_id();
                }
            } else {
                $id_venda = $pedido->PEDIDO_ID;
            }
        }
        $dados = array(
            'tela' => 'venda_abrir',
            'id_venda' => $id_venda,
            'cliente' => $this->join_model->endereco_completo($id_cliente)->row(),
            'pedido' => $pedido,
            'mensagem' => @$mensagem,
        );
        $this->load->view('contente', $dados);
    }

    public function addproduto($id_pedido, $id_produto) {
        // se for valido ele chama o inserir dentro do produto_model
        $produto = $this->join_model->produto($id_produto)->row();
        if ($produto != NULL || $produto->ESTOQ_ATUAL > 0) {
            $pedido = $this->crud_model->pega("PEDIDO", array('PEDIDO_ID' => $id_pedido))->result();
            if ($pedido != NULL) {
                $lista_pedido = $this->crud_model->pega("LISTA_PEDIDO", array('ESTOQ_ID' => $produto->ESTOQ_ID))->row();
                if ($lista_pedido == NULL) {
                    echo "<br>pode da insert na lista_pedido";
                } else {
                    echo "<br>faz o update de adição no produto";
                }
            } else {
                $mensagem = $this->lang->line("msg_pedido_erro");
            }
        } else {
            $mensagem = "1";
        }
        $dados = array(
            'tela' => 'venda_lista',
            'mensagem' => @$mensagem,
            'lista_pedido' => $this->join_model->lista_pedido($id_pedido)->result(),
        );
        $this->load->view('contente', $dados);
    }

    public function atualizar($id_pedido, $lista_ped_id, $quantidade) {
        $pedido = $this->crud_model->pega("PEDIDO", array('PEDIDO_ID' => $id_pedido))->result();
        if ($pedido != NULL) {
            $atualizar = array('LIST_PED_QNT' => $quantidade);
            $cindicao = array('LIST_PED_ID' => $lista_ped_id);
            if ($this->crud_model->update("LISTA_PEDIDO", $atualizar, $cindicao) === TRUE) {
                $mensagem = $this->lang->line("msg_atualuzado_sucesso");
            } else {
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

    public function excluir($id_produto) {
        if ($this->input->post('id_produto') > 0):
            if ($this->crud_model->excluir("PRODUTOS", array('PRO_ID' => $this->input->post('id_produto'))) === TRUE) {
                $mensagem = $this->lang->line("msg_excluir_sucesso");
            } else {
                $mensagem = $this->lang->line("msg_excluir_sucesso");
            }
        endif;

        $dados = array(
            'tela' => "prod_excluir",
            'mensagem' => @$mensagem,
            'query' => $this->crud_model->pega("PRODUTOS", array('PRO_ID' => $id_produto))->row(),
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

    public function exibir() {
        echo "<pre>";
        print_r($this->join_model->lista_pedido("3")->result());
        echo "</pre>";
    }

}