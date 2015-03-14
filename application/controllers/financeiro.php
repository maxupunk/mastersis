<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Financeiro extends CI_Controller {

    var $mensagem;

    public function __construct() {
        parent::__construct();
        $this->load->model(array('crud_model', 'join_model', 'geral_model'));
        $this->load->library(array('form_validation', 'convert'));
        $this->auth->check_logged($this->router->class, $this->router->method);
    }

    public function index() {

        $dados = array(
            'tela' => "financeiro/financeiro",
        );
        $this->load->view('home', $dados);
    }

    public function ReceitaDespesaLst($natureza = 1) {
        $ReceitaDespesas = $this->join_model->ReceitaDespesa($natureza, 'DESREC_VECIMENTO asc')->result();
        if (isset($ReceitaDespesas)) {
            $this->load->view('json', array('query' => $ReceitaDespesas));
        }
    }

    public function ValorCompra() {
        // validar o formulario
        $this->form_validation->set_rules('Pedido', 'O id do pedido não passado!', 'required');
        $this->form_validation->set_rules('ListPed', 'O id da lista de pedido não passado!', 'required');
        $this->form_validation->set_rules('Valor', 'A quantidade não foi repassada', 'required');

        $this->form_validation->set_error_delimiters('<span class="label label-danger">', '</span>');

        // se for valido ele chama o inserir dentro do produto_model
        if ($this->form_validation->run() == TRUE) {

            $post = $this->input->post();
            // pega o item dentro da lista de produto
            $pedido = $this->crud_model->pega("LISTA_PRODUTOS", array('LIST_PED_ID' => $post['ListPed']))->result();
            if ($pedido != NULL) {
                $atualizar = array('LIST_PED_COMP' => $this->convert->EmDecimal($post['Valor']));
                $condicao = array('LIST_PED_ID' => $post['ListPed']);
                if ($this->crud_model->update("LISTA_PRODUTOS", $atualizar, $condicao) == FALSE) {
                    $this->mensagem = "Erro: Problema ao atualuzar item!";
                }
            } else {
                $this->mensagem = "Erro: Não existe esse item no pedido";
            }
        }

        if ($this->mensagem == NULL) {
            $Retorno_array = array();
            $Dados_Array = array();

            $ProdutoInfo = $this->join_model->PedidoProduto($post['ListPed'])->row();

            $Dados_Array['LIST_PED_ID'] = $ProdutoInfo->LIST_PED_ID;
            $Dados_Array['LIST_PED_QNT'] = $ProdutoInfo->LIST_PED_QNT;
            $Dados_Array['LIST_PED_PRECO'] = $ProdutoInfo->LIST_PED_COMP;

            $Total = $this->geral_model->TotalPedComp($post['Pedido'])->row();
            array_push($Retorno_array, $Dados_Array);
            array_push($Retorno_array, array('Total' => $this->convert->em_real($Total->total)));
        } else {
            $Retorno_array = array('msg' => $this->mensagem);
        }

        $dados = array(
            'query' => $Retorno_array,
        );

        $this->load->view('json', $dados);
    }

    public function ValorVenda() {
        // validar o formulario
        $this->form_validation->set_rules('Pedido', 'O id do pedido não passado!', 'required');
        $this->form_validation->set_rules('ListPed', 'O id da lista de pedido não passado!', 'required');
        $this->form_validation->set_rules('Valor', 'A quantidade não foi repassada', 'required');

        // se for valido ele chama o inserir dentro do produto_model
        if ($this->form_validation->run() == TRUE) {
            $post = $this->input->post();
            // pega o item dentro da lista de produto
            $pedido = $this->crud_model->pega("LISTA_PRODUTOS", array('LIST_PED_ID' => $post['ListPed']))->result();
            if ($pedido != NULL) {
                $atualizar = array('LIST_PED_PRECO' => $this->convert->EmDecimal($post['Valor']));
                $condicao = array('LIST_PED_ID' => $post['ListPed']);
                if ($this->crud_model->update("LISTA_PRODUTOS", $atualizar, $condicao) == FALSE) {
                    log_message('error', 'Problema ao atualuzar item!');
                    show_error(500);
                }
            } else {
                log_message('error', 'Erro: Não existe esse item no pedido');
                show_error(500);
            }
        } else {
            log_message('error', validation_errors());
            show_error(500);
        }
    }

    public function FormaPG($FPG_ID = null) {

        if ($FPG_ID != NULL) {
            $FPG = $this->crud_model->pega("FORMA_PG", array('FPG_ID' => $FPG_ID))->row();
            if ($FPG == NULL) {
                $FPG = array('msg' => "Essa forma de pagamento não existe no banco de dados!");
            }
        } else {
            $FPG = array('msg' => "Forma de pagamento invalida!");
        }

        $dados = array(
            'query' => $FPG,
        );

        $this->load->view('json', $dados);
    }

    public function Nparcelas($pedidoId = NULL, $FPG_ID = NULL, $Nparcela = NULL) {

        if ($pedidoId != NULL AND $FPG_ID != NULL AND $Nparcela != NULL) {
            $Total = $this->geral_model->TotalPedido($pedidoId)->row();
            $FPG = $this->crud_model->pega("FORMA_PG", array('FPG_ID' => $FPG_ID))->row();
            $PEDIDO = $this->crud_model->pega("PEDIDOS", array('PEDIDO_ID' => $pedidoId))->row();
            $Jurus = (((($FPG->FPG_AJUSTE / 100) * $Total->total) * $Nparcela) - $PEDIDO->PEDIDO_DESCONTO);
            $TotalRetorno = $Jurus + $Total->total;
            $atualizar = array('PG_FPG_ID' => $FPG_ID, 'PEDIDO_NPARC' => $Nparcela);
            $condicao = array('PEDIDO_ID' => $pedidoId);
            if ($this->crud_model->update("PEDIDOS", $atualizar, $condicao) == FALSE) {
                $TotalRetorno = array('msg' => "Erro ao Altera a forma de pagamento");
            }
        } else {
            $TotalRetorno = array('msg' => "Dados incompleto ou Numero de parcela incorreto");
        }

        $dados = array(
            'query' => $TotalRetorno
        );

        $this->load->view('json', $dados);
    }

    public function novo() {

        $formulario = $this->input->post();

        // validar o formulario
        $this->form_validation->set_rules('PES_NOME', 'NOME DA CLIENTE/FORNECEDOR', 'required|strtoupper');
        $this->form_validation->set_rules('PES_ID', 'NOME DA CLIENTE/FORNECEDOR', 'required');
        $this->form_validation->set_rules('DESREC_VALOR', 'VALOR', 'required');
        $this->form_validation->set_rules('DESREC_VECIMENTO', 'VENCIMENTO', 'required');

        if ($formulario['ADICIONA'] > 1) {
            $this->form_validation->set_rules('PED_OS_ID', 'ID', 'required');
        }

        if ($formulario['DESCRE_ESTATUS'] == "pg") {
            $this->form_validation->set_rules('DESCRE_DATA_PG', 'DATA DO PAGAMENTO', 'required');
        }

        $this->form_validation->set_rules('DESREC_DESCR', 'DESCRIÇÃO', 'required');

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');


        // se for valido ele chama o inserir dentro do produto_model
        if ($this->form_validation->run() == TRUE):

            $senha = array('USUARIO_SENHA' => hash("sha512", $formulario['USUARIO_SENHA']));
            $novo_form = array_replace($formulario, $senha);

            $dados = elements(array('PES_ID', 'USUARIO_APELIDO', 'USUARIO_LOGIN', 'USUARIO_SENHA', 'CARG_ID'), $novo_form);
            if ($this->crud_model->inserir('USUARIOS', $dados) === TRUE) {
                $this->mensagem = $this->lang->line("msg_cadastro_sucesso");
            } else {
                $this->mensagem = $this->lang->line("msg_cadastro_erro");
            }

        endif;
        $dados = array(
            'tela' => 'financeiro/novo',
            'mensagem' => $this->mensagem,
        );
        $this->load->view('contente', $dados);
    }

}
