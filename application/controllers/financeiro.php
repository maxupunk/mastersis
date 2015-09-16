<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

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
            $this->form_validation->set_message('id_check', 'O ID do pedido/ordem não existe');
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
    // funcões privada
    ////////////////////////////////////////////////
    private function log($id) {
        $data['USUARIO_ID'] = $this->session->userdata('USUARIO_ID');
        $data['DESREC_ID'] = $id;
        $data['HISTORICO_CMD'] = $this->router->method;
        $data['HISTORICO_DATA'] = date("Y-m-d h:i:s");
        $this->db->insert('HISTORICO', $data);
    }

    ///////////////////////////////////////////////

    public function VlrCstPedido() {
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
            $Total = $this->geral_model->TotalPedComp($post['Pedido'])->row();

            $Dados_Array['LIST_PED_ID'] = $ProdutoInfo->LIST_PED_ID;
            $Dados_Array['LIST_PED_QNT'] = $ProdutoInfo->LIST_PED_QNT;
            $Dados_Array['LIST_PED_PRECO'] = $ProdutoInfo->LIST_PED_COMP;

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

    public function VlrVendaPedido() {
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

    public function VlVndProduto() {
        // validar o formulario
        $this->form_validation->set_rules('IdEstq', 'ID do produto', 'required');
        $this->form_validation->set_rules('Valor', 'Valor do produto', 'required');

        // se for valido ele chama o inserir dentro do produto_model
        if ($this->form_validation->run() == TRUE) {
            $post = $this->input->post();
            $atualizar = array('ESTOQ_PRECO' => $this->convert->EmDecimal($post['Valor']));
            $condicao = array('ESTOQ_ID' => $post['IdEstq']);
            if ($this->crud_model->update("ESTOQUES", $atualizar, $condicao) == FALSE) {
                log_message('error', 'Problema ao atualuzar item!');
                show_error(500);
            }
        } else {
            log_message('error', 'Erro: Falta parametros');
            show_error(500);
        }
    }

    public function VlCstProduto() {
        // validar o formulario
        $this->form_validation->set_rules('IdEstq', 'ID do produto', 'required');
        $this->form_validation->set_rules('Valor', 'Valor do produto', 'required');

        // se for valido ele chama o inserir dentro do produto_model
        if ($this->form_validation->run() == TRUE) {
            $post = $this->input->post();
            $atualizar = array('ESTOQ_CUSTO' => $this->convert->EmDecimal($post['Valor']));
            $condicao = array('ESTOQ_ID' => $post['IdEstq']);
            if ($this->crud_model->update("ESTOQUES", $atualizar, $condicao) == FALSE) {
                log_message('error', 'Problema ao atualuzar item!');
                show_error(500);
            }
        } else {
            log_message('error', 'Erro: Falta parametros');
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
            $Jurus = ((($FPG->FPG_AJUSTE / 100) * $Total->total) * $Nparcela);
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

    public function Novo() {

        $formulario = $this->input->post();
        $campos = array('PES_ID', 'DESREC_NATUREZA', 'DESREC_DESCR', 'DESREC_VALOR', 'DESREC_VECIMENTO', 'DESCRE_ESTATUS');

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

            $formulario['DESREC_VALOR'] = $this->convert->EmDecimal($formulario['DESREC_VALOR']);
            $formulario['DESREC_VECIMENTO'] = $this->convert->DataParaDB($formulario['DESREC_VECIMENTO']);

            $dados = elements($campos, $formulario);
            if ($this->crud_model->inserir('DESPESA_RECEITA', $dados) === TRUE) {
                $this->log($this->db->insert_id());
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

    public function Baixar($id) {

        // verifica se está aberto
        if ($this->crud_model->pega("DESPESA_RECEITA", array('DESCRE_ESTATUS' => 'ab', 'DESREC_ID' => $id))->row() !== NULL) {
            $this->form_validation->set_rules('DESREC_ID', 'ID DESPEZA / RECEITA', 'required');

            if ($this->form_validation->run() == TRUE) {
                if ($this->geral_model->BaixaPg($id) > 0) {
                    $this->log($id);
                    $this->mensagem = "Baixa feita com sucesso!";
                } else {
                    $this->mensagem = "Erro: Despeza / Receita não existe ou já foi baixada anteriormente";
                }
            }
        } else {
            $this->mensagem = "O item não poder ser baixado, o mesmo não está em aberto";
        }

        $DadosPedido = $this->join_model->RecDesTudo($id)->row();

        $PED_ID = $DadosPedido->DESREC_ID;
        $selecao = 'dr';

        if ($DadosPedido->OS_ID !== NULL) {
            $PED_ID = $DadosPedido->OS_ID;
            $selecao = 'os';
        }
        if ($DadosPedido->PEDIDO_ID !== NULL) {
            $PED_ID = $DadosPedido->PEDIDO_ID;
            $selecao = 'pd';
        }

        $dados = array(
            'tela' => 'financeiro/baixar',
            'query' => $DadosPedido,
            'Parcelas' => $this->geral_model->ParcelasRestante($PED_ID, $selecao)->row(),
            'mensagem' => $this->mensagem,
        );
        $this->load->view('contente', $dados);
    }

    public function Detalhes($id) {

        $DadosPedido = $this->join_model->RecDesTudo($id)->row();

        $PED_ID = $DadosPedido->DESREC_ID;
        $selecao = 'dr';

        if ($DadosPedido->OS_ID !== NULL) {
            $PED_ID = $DadosPedido->OS_ID;
            $selecao = 'os';
        }
        if ($DadosPedido->PEDIDO_ID !== NULL) {
            $PED_ID = $DadosPedido->PEDIDO_ID;
            $selecao = 'pd';
        }

        $dados = array(
            'tela' => 'financeiro/detalhes',
            'query' => $DadosPedido,
            'Parcelas' => $this->geral_model->ParcelasRestante($PED_ID, $selecao)->row(),
            'historicos' => $this->join_model->Historico($id, "dr")->result(),
            'mensagem' => $this->mensagem,
        );
        $this->load->view('contente', $dados);
    }

    public function Editar($id) {

        $formulario = $this->input->post();

        // validar o formulario
        $this->form_validation->set_rules('DESREC_VALOR', 'VALOR', 'required');
        $this->form_validation->set_rules('DESREC_VECIMENTO', 'VENCIMENTO', 'required');
        $this->form_validation->set_rules('DESREC_NATUREZA', '', 'required');
        $this->form_validation->set_rules('DESCRE_ESTATUS', '', 'in_list[ab]');
        $this->form_validation->set_message('in_list', 'Alterações só pode ser feitas se o estatus for colocado em aberto!');

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

        if ($this->form_validation->run() == TRUE) {
            $formulario['DESREC_VALOR'] = $this->convert->EmDecimal($formulario['DESREC_VALOR']);
            $formulario['DESREC_VECIMENTO'] = $this->convert->DataParaDB($formulario['DESREC_VECIMENTO']);

            $campos = array('DESREC_NATUREZA', 'DESCRE_ESTATUS', 'DESREC_DESCR', 'DESREC_VALOR', 'DESREC_VECIMENTO');
            $elementos = elements($campos, $formulario);
            if ($this->crud_model->update("DESPESA_RECEITA", $elementos, array('DESREC_ID' => $formulario['DESREC_ID'])) === TRUE) {
                $this->log($id);
                $this->mensagem = "Edição salva com sucesso!";
            } else {
                $this->mensagem = "Erro: problema ao grava alterações no banco de dados";
            }
        }

        $DadosPedido = $this->join_model->RecDesTudo($id)->row();

        $PED_ID = $DadosPedido->DESREC_ID;
        $selecao = 'dr';

        if ($DadosPedido->OS_ID !== NULL) {
            $PED_ID = $DadosPedido->OS_ID;
            $selecao = 'os';
        }
        if ($DadosPedido->PEDIDO_ID !== NULL) {
            $PED_ID = $DadosPedido->PEDIDO_ID;
            $selecao = 'pd';
        }

        $dados = array(
            'tela' => 'financeiro/editar',
            'query' => $DadosPedido,
            'Parcelas' => $this->geral_model->ParcelasRestante($PED_ID, $selecao)->row(),
            'mensagem' => $this->mensagem
        );
        $this->load->view('contente', $dados);
    }

    public function Canselar($id) {
        // verifica se já não está canselada
        if ($this->crud_model->pega("DESPESA_RECEITA", array('DESCRE_ESTATUS' => 'cn', 'DESREC_ID' => $id))->row() === NULL) {

            $this->form_validation->set_rules('DESREC_ID', '', 'required');

            if ($this->form_validation->run() == TRUE) {
                $atualizar = array('DESCRE_ESTATUS' => 'cn');
                $condicao = array('DESREC_ID' => $this->input->post('DESREC_ID'));
                if ($this->crud_model->update("DESPESA_RECEITA", $atualizar, $condicao) === TRUE) {
                    $this->log($id);
                    $this->mensagem = "Canselado com sucesso!";
                } else {
                    $this->mensagem = "Erro: problema ao grava alterações no banco de dados";
                }
            }

            $DadosPedido = $this->join_model->RecDesTudo($id)->row();

            $PED_ID = $DadosPedido->DESREC_ID;
            $selecao = 'dr';

            if ($DadosPedido->OS_ID !== NULL) {
                $PED_ID = $DadosPedido->OS_ID;
                $selecao = 'os';
            }
            if ($DadosPedido->PEDIDO_ID !== NULL) {
                $PED_ID = $DadosPedido->PEDIDO_ID;
                $selecao = 'pd';
            }

            $dados = array(
                'tela' => 'financeiro/canselar',
                'query' => $DadosPedido,
                'Parcelas' => $this->geral_model->ParcelasRestante($PED_ID, $selecao)->row(),
                'historicos' => $this->join_model->Historico($id, "dr")->result(),
                'mensagem' => $this->mensagem,
            );
        } else {
            $dados = array(
                'tela' => 'financeiro/canselar',
                'mensagem' => 'Essa conta já foi canselada anteriormente',
            );
        }
        $this->load->view('contente', $dados);
    }

    public function Filtro() {
        $this->form_validation->set_rules('qtd', '', 'required');
        $this->form_validation->set_rules('estatus', '', 'required');
        $this->form_validation->set_rules('natureza', '', 'required');

        if ($this->form_validation->run() == TRUE) {
            $formulario = $this->input->post();
            $busca = $formulario['busca'];
            $estatus = $formulario['estatus'];
            $qnt = $formulario['qtd'];
            $natureza = $formulario['natureza'];
            $query = $this->join_model->RecDesFiltro($busca, $estatus, $qnt, $natureza)->result();
            $dados = array('query' => $query);
            $this->load->view('json', $dados);
        }
    }

    public function TodosDados($id = 0) {
        if ($id != 0) {
            $produto = $this->join_model->ProdutoEstoque($id)->row();
            //verifica se o produto existe
            if (isset($produto)) {
                $this->load->view('json', array('query' => $produto));
            }
        }
    }

    public function FormasPG() {
        $FormaPG = $this->crud_model->pega("FORMA_PG", array('FPG_STATUS' => 'a'))->result();
        if (isset($FormaPG)) {
            $this->load->view('json', array('query' => $FormaPG));
        }
    }

    public function NovaFormaPG() {

        $this->form_validation->set_rules('DescrFPG', 'FORMA DE PAGAMENTO', 'required|max_length[30]|is_unique[FORMA_PG.FPG_DESCR]');
        $this->form_validation->set_rules('ParceFPT', 'PARCELAS', 'required');
        $this->form_validation->set_rules('JurusFPG', 'JURUS', 'required');
        
        //verifica se passou na validação
        if ($this->form_validation->run() == TRUE):
            $dados = elements(array('CATE_NOME', 'CATE_DESCRIC'), $this->input->post());
            if ($this->crud_model->inserir("CATEGORIAS", $dados) == TRUE) {
                $this->mensagem = $this->lang->line("msg_cadastro_sucesso");
            } else {
                $this->mensagem = $this->lang->line("msg_cadastro_erro");
            }
        endif;

        if (isset($FormaPG)) {
            $this->load->view('json', array('query' => $FormaPG));
        }
    }

}
