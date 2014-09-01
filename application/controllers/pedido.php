<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pedido extends CI_Controller {

    var $mensagem;

    public function __construct() {
        parent::__construct();
        $this->load->model(array('crud_model', 'join_model', 'geral_model'));
        $this->load->library(array('form_validation', 'table', 'convert'));
        $this->auth->check_logged($this->router->class, $this->router->method);
    }

    public function index() {
        
    }

    public function AddProd($tipo, $id_pedido, $id_produto) {
        //verifica se o produto existe e tem um estoque maior que zero
        $produto = $this->join_model->ProdutoEstoque($id_produto)->row();
        if (($produto != NULL) and ( $produto->ESTOQ_ATUAL >= 1 and $produto->PRO_ESTATUS === 'a') or ( $tipo != "v")) {
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
                        'LIST_PED_PRECO' => ($tipo == "v") ? $produto->ESTOQ_PRECO : $produto->ESTOQ_CUSTO);
                    if ($this->crud_model->inserir('LISTA_PRODUTOS', $dados) != TRUE) {
                        $this->mensagem = $this->lang->line("msg_pedido_erro");
                    }
                } else {
                    $this->mensagem = "O item já existe, se deseja altera quantidades, click em uma das setas em QUANTIDADE.";
                }
            } else {
                $dados = array(
                    'USUARIO_ID' => $this->session->userdata('USUARIO_ID'),
                    'PEDIDO_DATA' => date("Y-m-d h:i:s"),
                    'PEDIDO_ESTATUS' => '1',
                    'PEDIDO_LOCAL' => 'l',
                    'PEDIDO_TIPO' => 'v');
                if ($this->crud_model->inserir('PEDIDOS', $dados) == TRUE) {
                    $id_pedido = $this->db->insert_id();
                } else {
                    $this->mensagem = "Erro ao grava pedido no banco de dados!";
                }
            }
        } else {
            $this->mensagem = "Erro: O produto está com o estoque zerado ou esta desativo.";
        }
        $dados = array(
            'tela' => 'pedido_itens',
            'mensagem' => $this->mensagem,
            'IdPed' => $id_pedido,
            'LstProd' => $this->join_model->ListaPedido($id_pedido)->result(),
            'Total' => $this->geral_model->TotalPedido($id_pedido)->row(),
        );
        $this->load->view('contente', $dados);
    }

    public function AddProdOs($id_os, $id_produto) {
        //verifica se o produto existe e tem um estoque maior que zero
        $produto = $this->join_model->ProdutoEstoque($id_produto)->row();
        if ($produto != NULL and $produto->ESTOQ_ATUAL >= 1 and $produto->PRO_ESTATUS === 'a') {
            //verifica se existe realmente um pedido com o id passado
            $os = $this->crud_model->pega("ORDEM_SERV", array('OS_ID' => $id_os))->row();
            if ($os != NULL) {
                //verififca se já existe o prodoto na lista de pedido
                $lista_pedido = $this->crud_model->pega("LISTA_PRODUTOS", array('ESTOQ_ID' => $produto->ESTOQ_ID, 'OS_ID' => $id_os))->row();
                if ($lista_pedido == NULL) {
                    //inseri os dados abaixo no db
                    $dados = array(
                        'OS_ID' => $id_os,
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
                $this->mensagem = "Erro: A ordem de serviço não existe ou já foi fechado!";
            }
        } else {
            $this->mensagem = "Erro: O produto está com o estoque zerado!<br> - Produto esta desativo.";
        }
        $dados = array(
            'tela' => 'pedido_itens',
            'mensagem' => $this->mensagem,
            'IdPed' => $id_os,
            'LstProd' => $this->join_model->ListaProdOs($id_os)->result(),
            'Total' => $this->geral_model->TotalProdOS($id_os)->row(),
        );
        $this->load->view('contente', $dados);
    }

    public function UpdQntPedido() {
        // validar o formulario
        $this->form_validation->set_rules('Pedido', 'O id do pedido não passado!', 'required');
        $this->form_validation->set_rules('ListPed', 'O id da lista de pedido não passado!', 'required');
        $this->form_validation->set_rules('Estoq', 'O id do estoque é obrigado', 'required');
        $this->form_validation->set_rules('qtd', 'A quantidade não foi repassada', 'required');
        $this->form_validation->set_rules('tipo', 'O tipo de transisão não passado!', 'required');

        $this->form_validation->set_error_delimiters('<span class="label label-danger">', '</span>');

        // se for valido ele chama o inserir dentro do produto_model
        if ($this->form_validation->run() == TRUE) {

            $post = $this->input->post();
            // Verifica se a quantidade digitada é maior que 0
            if ($post['qtd'] > 0) {
                // pega o item dentro da lista de produto
                $pedido = $this->crud_model->pega("LISTA_PRODUTOS", array('LIST_PED_ID' => $post['ListPed']))->result();
                if ($pedido != NULL) {
                    $produto = $this->crud_model->pega("ESTOQUES", array('ESTOQ_ID' => $post['Estoq']))->row();
                    // Verifica de tem estoque suficiente ou se é serviço "-1
                    if ($produto->ESTOQ_ATUAL < $post['qtd'] AND $produto->ESTOQ_MIN != -1 AND $post['tipo'] == "v") {
                        $this->mensagem = "Não existe estoque suficiente! O estoque maximo foi digitado para você!";
                        $post['qtd'] = $produto->ESTOQ_ATUAL;
                    }
                    $atualizar = array('LIST_PED_QNT' => $post['qtd']);
                    $condicao = array('LIST_PED_ID' => $post['ListPed']);
                    if ($this->crud_model->update("LISTA_PRODUTOS", $atualizar, $condicao) == FALSE) {
                        $this->mensagem = "Erro: Problema ao atualuzar item!";
                    }
                } else {
                    $this->mensagem = "Erro: Esse item no pedido";
                }
            } else {
                $this->mensagem = "Erro: Não é aceitavel quantidades menores que 0,01";
            }
        }

        $dados = array(
            'tela' => 'pedido_itens',
            'mensagem' => @$this->mensagem,
            'IdPed' => $post['Pedido'],
            'LstProd' => $this->join_model->ListaPedido($post['Pedido'])->result(),
            'Total' => $this->geral_model->TotalPedido($post['Pedido'])->row(),
        );
        $this->load->view('contente', $dados);
    }

    public function UpdQntOs() {
        // validar o formulario
        $this->form_validation->set_rules('Os', 'O id da ordem de serviço!', 'required');
        $this->form_validation->set_rules('ListPed', 'O id da lista de pedido não passado!', 'required');
        $this->form_validation->set_rules('Estoq', 'O id do estoque não passado!', 'required');
        $this->form_validation->set_rules('qtd', 'A quantidade não passada!', 'required');

        $this->form_validation->set_error_delimiters('<span class="label label-danger">', '</span>');

        // se for valido ele chama o inserir dentro do produto_model
        if ($this->form_validation->run() == TRUE) {

            $post = $this->input->post();
            // Verifica se a quantidade digitada é maior que 0
            if ($post['qtd'] > 0) {
                // pega o item dentro da lista de produto
                $pedido = $this->crud_model->pega("LISTA_PRODUTOS", array('LIST_PED_ID' => $post['ListPed']))->result();
                if ($pedido != NULL) {
                    $produto = $this->crud_model->pega("ESTOQUES", array('ESTOQ_ID' => $post['Estoq']))->row();
                    // Verifica de tem estoque suficiente ou se é serviço "-1
                    if ($produto->ESTOQ_ATUAL < $post['qtd'] AND $produto->ESTOQ_MIN != -1) {
                        $this->mensagem = "Não existe estoque suficiente! O estoque maximo foi digitado para você!";
                        $post['qtd'] = $produto->ESTOQ_ATUAL;
                    }
                    $atualizar = array('LIST_PED_QNT' => $post['qtd']);
                    $condicao = array('LIST_PED_ID' => $post['ListPed']);
                    if ($this->crud_model->update("LISTA_PRODUTOS", $atualizar, $condicao) == FALSE) {
                        $this->mensagem = "Erro: Problema ao atualuzar item!";
                    }
                } else {
                    $this->mensagem = "Erro: Esse item no pedido";
                }
            } else {
                $this->mensagem = "Erro: Não é aceitavel quantidades menores que 0,01";
            }
        }

        $dados = array(
            'tela' => 'pedido_itens',
            'mensagem' => @$this->mensagem,
            'IdPed' => $post['Os'],
            'LstProd' => $this->join_model->ListaProdOs($post['Os'])->result(),
            'Total' => $this->geral_model->TotalProdOS($post['Os'])->row(),
        );
        $this->load->view('contente', $dados);
    }

    public function UpdLstPedido($id_pedido) {

        // verifica se existe o pedido
        $pedido = $this->crud_model->pega("PEDIDOS", array('PEDIDO_ID' => $id_pedido))->result();
        if ($pedido != NULL) {
            $dados = array(
                'tela' => 'pedido_itens',
                'mensagem' => @$this->mensagem,
                'IdPed' => $id_pedido,
                'LstProd' => $this->join_model->ListaPedido($id_pedido)->result(),
                'Total' => $this->geral_model->TotalPedido($id_pedido)->row(),
            );
        } else {
            $dados = array(
                'tela' => 'pedido_itens',
                'mensagem' => @$this->mensagem,
                'LstProd' => NULL,
            );
        }

        $this->load->view('contente', $dados);
    }

    public function UpdLstOs($id_os) {
        $dados = array(
            'tela' => 'pedido_itens',
            'mensagem' => $this->mensagem,
            'IdPed' => $id_os,
            'LstProd' => $this->join_model->ListaProdOs($id_os)->result(),
            'Total' => $this->geral_model->TotalProdOS($id_os)->row(),
        );
        $this->load->view('contente', $dados);
    }

    public function DelItemPedido($id_pedido, $lista_ped_id) {

        if ($this->crud_model->excluir("LISTA_PRODUTOS", array('LIST_PED_ID' => $lista_ped_id)) != TRUE) {
            $this->mensagem = $this->lang->line("msg_excluir_sucesso");
        }

        $dados = array(
            'tela' => 'pedido_itens',
            'mensagem' => $this->mensagem,
            'IdPed' => $id_pedido,
            'LstProd' => $this->join_model->ListaPedido($id_pedido)->result(),
            'Total' => $this->geral_model->TotalPedido($id_pedido)->row(),
        );
        $this->load->view('contente', $dados);
    }

    public function DelItemOs($id_os, $lista_ped_id) {

        if ($this->crud_model->excluir("LISTA_PRODUTOS", array('LIST_PED_ID' => $lista_ped_id)) != TRUE) {
            $this->mensagem = $this->lang->line("msg_excluir_sucesso");
        }

        $dados = array(
            'tela' => 'pedido_itens',
            'mensagem' => $this->mensagem,
            'IdPed' => $id_os,
            'LstProd' => $this->join_model->ListaProdOs($id_os)->result(),
            'Total' => $this->geral_model->TotalProdOS($id_os)->row(),
        );
        $this->load->view('contente', $dados);
    }

    public function DelPedido($id_pedido, $url = "venda") {
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
        redirect(base_url() . $url);
    }

}
