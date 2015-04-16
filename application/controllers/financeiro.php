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

    ///// Funções para validação /////////////
    public function id_check($str) {
        $pedido = $this->crud_model->pega("DESPESA_RECEITA", array('PEDIDO_ID' => $str))->row();
        $os = $this->crud_model->pega("DESPESA_RECEITA", array('OS_ID' => $str))->row();
        if ($pedido or $os) {
            return TRUE;
        } else {
            $this->form_validation->set_message('id_check', 'O ID do pedido não existe');
            return FALSE;
        }
    }

    public function parcela_check($id) {
        $data = $this->input->post('DESREC_VECIMENTO');
        $natureza = $this->input->post('DESREC_NATUREZA');

        // verifica se já existe uma parcela para esse vencimento para esse cliente
        $condicao = array('PES_ID' => $id, 'DESREC_NATUREZA' => $natureza, 'DESREC_VECIMENTO' => $this->convert->DataParaDB($data));
        $parcela = $this->crud_model->pega("DESPESA_RECEITA", $condicao)->row();
        if ($parcela != null) {
            $this->form_validation->set_message('parcela_check', 'Já existe uma parcela nessa vecimento para esse cliente');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    /////////////////////////////////////////////////

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
        $campos = array('USUARIO_ID', 'PES_ID', 'DESREC_NATUREZA', 'DESREC_DESCR', 'DESREC_VALOR', 'DESREC_VECIMENTO', 'DESCRE_ESTATUS');

        // validar o formulario
        $this->form_validation->set_rules('PES_NOME', 'NOME DA CLIENTE/FORNECEDOR', 'required|strtoupper');
        $this->form_validation->set_rules('PES_ID', 'NOME DA CLIENTE/FORNECEDOR', 'required|callback_parcela_check');
        $this->form_validation->set_rules('DESREC_VALOR', 'VALOR', 'required');
        $this->form_validation->set_rules('DESREC_VECIMENTO', 'VENCIMENTO', 'required');
        $this->form_validation->set_rules('ADICIONA', '', 'required');
        $this->form_validation->set_rules('DESREC_NATUREZA', '', 'required');
        $this->form_validation->set_rules('ADICIONA', '', 'required');

        if ($this->input->post('ADICIONA') > 1) {
            $this->form_validation->set_rules('PED_OS_ID', 'ID', 'required|is_natural_no_zero|callback_id_check');
            switch ($formulario['ADICIONA']) {
                case 2:
                    array_push($campos, 'OS_ID');
                    $formulario['OS_ID'] = $formulario['PED_OS_ID'];
                    break;
                case 3:
                    array_push($campos, 'PEDIDO_ID');
                    $formulario['PEDIDO_ID'] = $formulario['PED_OS_ID'];
                    break;
            }
        } else {
            $this->form_validation->set_rules('DESREC_DESCR', 'Descrição', 'required');
        }

        if ($this->input->post('DESCRE_ESTATUS') == "pg") {
            $this->form_validation->set_rules('DESCRE_DATA_PG', 'DATA DO PAGAMENTO', 'required');
            $data_pg = array('DESCRE_DATA_PG' => $this->convert->DataParaDB($formulario['DESCRE_DATA_PG']));
            $formulario = array_replace($formulario, $data_pg);
        }

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

        if ($this->form_validation->run() == TRUE) {

            $senha = array('DESREC_VALOR' => $this->convert->EmDecimal($formulario['DESREC_VALOR']));
            $vencimento = array('DESREC_VECIMENTO' => $this->convert->DataParaDB($formulario['DESREC_VECIMENTO']));
            $formulario = array_replace($formulario, $senha);
            $formulario = array_replace($formulario, $vencimento);

            $formulario['USUARIO_ID'] = $this->session->userdata('USUARIO_ID');

            $dados = elements($campos, $formulario);
            if ($this->crud_model->inserir('DESPESA_RECEITA', $dados) === TRUE) {
                $this->mensagem = "Inserido com sucesso!";
            } else {
                $this->mensagem = "Erro: problema ao gravar no banco de dados";
            }
        }
        $dados = array(
            'tela' => 'financeiro/novo',
            'mensagem' => $this->mensagem,
        );
        $this->load->view('contente', $dados);
    }

    public function baixa($id) {

        $this->form_validation->set_rules('PES_ID', 'NOME DA CLIENTE/FORNECEDOR', 'required|callback_parcela_check');
        $this->form_validation->set_rules('DESREC_VALOR', 'VALOR', 'required');
        $this->form_validation->set_rules('DESREC_VECIMENTO', 'VENCIMENTO', 'required');

        if ($this->form_validation->run() == TRUE) {
            
        }

        $DadosPedido = $this->join_model->RecDesTudo($id)->row();

        $dados = array(
            'tela' => 'financeiro/baixa',
            'query' => $DadosPedido,
            'Parcelas' => $this->geral_model->ParcelasRestante($DadosPedido->PEDIDO_ID)->row(),
            'mensagem' => $this->mensagem,
        );
        $this->load->view('contente', $dados);
    }

    public function teste($id) {
        echo "<pre>";
        $tudo = $this->join_model->RecDesTudo($id)->row();
        print_r($tudo);
        echo "</pre>";
        echo "<pre>";
        print_r($this->geral_model->ParcelaTotal($tudo->PEDIDO_ID)->row());
        echo "</pre>";
    }

}
