<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ordemservico extends CI_Controller {

    var $mensagem;

    public function __construct() {
        parent::__construct();
        $this->load->model(array('crud_model', 'join_model', 'geral_model'));
        $this->load->library(array('form_validation', 'table', 'convert'));
        $this->auth->check_logged($this->router->class, $this->router->method);
    }

    public function index() {

        $dados = array(
            'tela' => "ordem_servico",
            'emabertos' => $this->join_model->OsStatus('1', 'OS_DATA_ENT desc')->result(),
            'pendentes' => $this->join_model->OsStatus('2', 'OS_DATA_ENT desc')->result(),
            'concluidos' => $this->join_model->OsStatus('3', 'OS_DATA_ENT desc')->result(),
            'entregues' => $this->join_model->OsStatus('4', 'OS_DATA_SAI desc', '15')->result(),
        );
        $this->load->view('home', $dados);
    }

    private function estatus($id) {
        $estatus = $this->crud_model->pega("ORDEM_SERV", array('OS_ID' => $id))->row();
        return $this->convert->EstatusOs($estatus->OS_ESTATUS);
    }

    public function cadastrar() {

        $this->form_validation->set_rules('PES_NOME', 'CLIENTE', 'required|strtoupper');
        $this->form_validation->set_rules('PES_ID', 'CLIENTE', 'required');
        $this->form_validation->set_message('is_unique', 'Você não selecionou um %s');
        $this->form_validation->set_rules('OS_EQUIPAMENT', 'DESCRIÇÃO DO EQUIPAMENTO', 'required');
        $this->form_validation->set_rules('OS_DSC_DEFEITO', 'DEFEITO', 'required');

        $this->form_validation->set_error_delimiters('<span class="label label-danger">', '</span>');


        if ($this->form_validation->run() == TRUE):

            $formulario = $this->input->post();
            $formulario['USUARIO_ID'] = $this->session->userdata('USUARIO_ID');
            $formulario['OS_DATA_ENT'] = date("Y-m-d h:i:s");
            $formulario['OS_ESTATUS'] = '1';

            $dados = elements(array('PES_ID', 'OS_EQUIPAMENT', 'OS_DSC_DEFEITO', 'OS_ESTATUS', 'USUARIO_ID', 'OS_DATA_ENT', 'OS_ESTATUS'), $formulario);
            if ($this->crud_model->inserir("ORDEM_SERV", $dados) == TRUE) {
                $this->session->set_flashdata('mensagem', $this->lang->line("msg_cadastro_sucesso"));
            } else {
                $this->session->set_flashdata('mensagem', $this->lang->line("msg_cadastro_erro"));
            }
            redirect(base_url('ordemservico'));
        endif;

        $dados = array(
            'tela' => "os_cadastro",
            'mensagem' => $this->mensagem,
        );
        $this->load->view('contente', $dados);
    }

    public function imprimir($id) {
        $OsDados = $this->join_model->OsDados($id)->row();
        $dados = array(
            'tela' => "os_imprimir",
            'ListaPedido' => $this->join_model->ListaProdOs($id)->result(),
            'total' => $this->geral_model->TotalProdOs($id)->row(),
            'Estatus' => $this->estatus($id),
            'usuario' => $this->crud_model->pega('USUARIOS', array('USUARIO_ID' => $OsDados->USUARIO_ID))->row(),
            'OsDados' => $OsDados,
            'empresa' => $this->crud_model->pega_tudo("EMPRESAS")->row(),
            'pessoa' => $this->join_model->EnderecoCompleto($OsDados->PES_ID)->row(),
        );
        $this->load->view('contente', $dados);
    }

    public function editar($id) {

        $this->form_validation->set_rules('OS_ESTATUS', 'estatus', 'required');
        $this->form_validation->set_error_delimiters('<p class="text-error">', '</p>');

        // se for valido ele chama o inserir dentro do produto_model
        if ($this->form_validation->run() == TRUE):

            $dados = elements(array('OS_DSC_SOLUC', 'OS_DSC_PENDENT', 'OS_ESTATUS'), $this->input->post());
            if ($this->crud_model->update("ORDEM_SERV", $dados, array('OS_ID' => $this->input->post('id_os'))) === TRUE) {
                $this->session->set_flashdata('mensagem', $this->lang->line("msg_editar_sucesso"));
            } else {
                $this->session->set_flashdata('mensagem', $this->lang->line("msg_editar_erro"));
            }
            redirect(base_url('ordemservico'));
        endif;

        $dados = array(
            'tela' => "os_editar",
            'OsDados' => $this->join_model->OsDados($id)->row(),
            'total' => $this->geral_model->TotalProdOs($id)->row(),
            'Estatus' => $this->crud_model->pega("ORDEM_SERV", array('OS_ID' => $id))->row(),
        );
        $this->load->view('contente', $dados);
    }

    public function excluir($id) {
        if ($this->input->post('id_os') > 0) {
            if ($this->geral_model->ExcluirOs($id) === TRUE) {
                $this->session->set_flashdata('mensagem', $this->lang->line("msg_excluir_sucesso"));
            } else {
                $this->session->set_flashdata('mensagem', $this->lang->line("msg_excluir_erro"));
            }
            redirect(base_url('ordemservico'), 'refresh');
        }

        $dados = array(
            'tela' => "os_excluir",
            'OsDados' => $this->join_model->OsDados($id)->row(),
        );
        $this->load->view('contente', $dados);
    }

    public function gerenciaitens($id_os) {
        $dados = array(
            'tela' => 'os_gerenciaitem',
            'mensagem' => $this->mensagem,
            'id_os' => $id_os,
            'ListaProduto' => $this->join_model->ListaProdOs($id_os)->result(),
            'total' => $this->geral_model->TotalProdOS($id_os)->row(),
        );
        $this->load->view('contente', $dados);
    }

    public function entregar($id_os) {

        $os = $this->crud_model->pega("ORDEM_SERV", array('OS_ID' => $id_os))->row();

        $dados = array(
            'tela' => "os_entregar",
            'total' => $this->geral_model->TotalProdOS($id_os)->row(),
            'pessoa' => $this->join_model->EnderecoCompleto($os->PES_ID)->row(),
            'id_pedido' => $id_os,
        );
        $this->load->view('contente', $dados);
    }

    public function finaliza($id_os) {

        $OsDados = $this->join_model->OsDados($id_os)->row();

        if ($this->geral_model->FechaOs($id_os, "4") > 0) {
            $this->mensagem = 'Ordem entregue com sucesso!';
        } else {
            $this->mensagem = 'Essa ordem já foi fechado anteriormente!';
        }

        $dados = array(
            'tela' => "os_finaliza",
            'mensagem' => $this->mensagem,
            'ListaPedido' => $this->join_model->ListaProdOs($id_os)->result(),
            'total' => $this->geral_model->TotalProdOs($id_os)->row(),
            'OsDados' => $OsDados,
            'empresa' => $this->crud_model->pega_tudo("EMPRESAS")->row(),
            'pessoa' => $this->join_model->EnderecoCompleto($OsDados->PES_ID)->row(),
        );

        $this->load->view('contente', $dados);
    }

    public function reabrir($id_os) {
        $this->output->enable_profiler(TRUE);

        if ($this->geral_model->ReabrirOs($id_os) > 0) {
            $this->session->set_flashdata('mensagem', 'Pedido foi reaberto com sucesso!');
        } else {
            $this->session->set_flashdata('mensagem', 'Esse pedido já foi aberto anteriormente!');
        }

        redirect(base_url('ordemservico'));

        $dados = array(
            'tela' => "os_reabrir",
            'mensagem' => $this->mensagem
        );

        $this->load->view('contente', $dados);
    }

    public function addproduto($id_os, $id_produto) {
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
                $this->mensagem = $this->lang->line("msg_pedido_erro");
            }
        } else {
            $this->mensagem = "Erro:<br> - O produto está com o estoque zerado!<br> - Produto esta desativo.";
        }
        $dados = array(
            'tela' => 'os_itens',
            'mensagem' => $this->mensagem,
            'ListaProduto' => $this->join_model->ListaProdOs($id_os)->result(),
            'total' => $this->geral_model->TotalProdOS($id_os)->row(),
        );
        $this->load->view('contente', $dados);
    }

    public function updproduto($id_os, $lista_ped_id = null, $id_estoque = null, $quantidade = null) {

        // verifica se existe o pedido
        if ($lista_ped_id != NULL and $id_estoque != null and $quantidade != null) {
            $pedido = $this->crud_model->pega("ORDEM_SERV", array('OS_ID' => $id_os))->result();
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
            'tela' => 'os_itens',
            'mensagem' => $this->mensagem,
            'ListaProduto' => $this->join_model->ListaProdOs($id_os)->result(),
            'total' => $this->geral_model->TotalProdOS($id_os)->row(),
        );
        $this->load->view('contente', $dados);
    }

    public function excluiritem($id_os, $lista_ped_id) {

        if ($this->crud_model->excluir("LISTA_PRODUTOS", array('LIST_PED_ID' => $lista_ped_id)) != TRUE) {
            $this->mensagem = $this->lang->line("msg_excluir_sucesso");
        }

        $dados = array(
            'tela' => 'os_itens',
            'mensagem' => $this->mensagem,
            'ListaProduto' => $this->join_model->ListaProdOs($id_os)->result(),
            'total' => $this->geral_model->TotalProdOS($id_os)->row(),
        );
        $this->load->view('contente', $dados);
    }

    public function updlista($id_os) {
        $dados = array(
            'tela' => 'os_itens',
            'mensagem' => $this->mensagem,
            'id_os' => $id_os,
            'ListaProduto' => $this->join_model->ListaProdOs($id_os)->result(),
            'total' => $this->geral_model->TotalProdOS($id_os)->row(),
        );
        $this->load->view('contente', $dados);
    }

}