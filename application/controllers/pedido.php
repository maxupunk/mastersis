<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pedido extends CI_Controller {

    var $mensagem;

    public function __construct() {
        parent::__construct();
        $this->load->model(array('crud_model', 'join_model', 'geral_model'));
        $this->load->library(array('form_validation', 'convert'));
        $this->auth->check_logged($this->router->class, $this->router->method);
    }

    public function index() {
        
    }

    public function EmAberto() {
        $EmAberto = $this->crud_model->pega("PEDIDOS", array('USUARIO_ID' => $this->session->userdata('USUARIO_ID'), 'PEDIDO_ESTATUS' => '1'))->result();
        if (isset($EmAberto)) {
            $this->load->view('json', array('query' => $EmAberto));
        }
    }

    public function LmpLstEmAberto() {
        if ($this->input->post()) {
            $this->crud_model->excluir("PEDIDOS", array('USUARIO_ID' => $this->session->userdata('USUARIO_ID'), 'PEDIDO_ESTATUS' => '1'));
        }

        $this->load->view('contente', array('tela' => "pedido/lmplst"));
    }

    public function AddProdVenda($id_pedido, $id_produto) {

        $produto = $this->join_model->ProdutoEstoque($id_produto)->row();
        //verifica se o produto existe
        if ($produto != NULL) {
            if ($produto->PRO_TIPO === 'p') {
                if ($produto->ESTOQ_ATUAL >= 1 and $produto->PRO_ESTATUS === 'a') {
                    //verifica se existe realmente um pedido com o id passado
                    if ($this->crud_model->pega("PEDIDOS", array('PEDIDO_ID' => $id_pedido, 'PEDIDO_ESTATUS' => '1'))->row() != NULL) {
                        //verififca se já existe o prodoto na lista de pedido
                        if (!$this->crud_model->pega("LISTA_PRODUTOS", array('ESTOQ_ID' => $produto->ESTOQ_ID, 'PEDIDO_ID' => $id_pedido))->row()) {
                            //inseri os dados abaixo no db
                            $dados = array(
                                'PEDIDO_ID' => $id_pedido,
                                'ESTOQ_ID' => $produto->ESTOQ_ID,
                                'LIST_PED_QNT' => '1',
                                'LIST_PED_PRECO' => $produto->ESTOQ_PRECO);
                            if ($this->crud_model->inserir('LISTA_PRODUTOS', $dados) != TRUE) {
                                $this->mensagem = "Erro: problema ao adicionar item no pedido!";
                            } else {
                                $idLstProd = $this->db->insert_id();
                            }
                        } else {
                            $this->mensagem = "O item já existe, se deseja altera quantidades, click em uma das setas em QUANTIDADE.";
                        }
                    } else {
                        $this->mensagem = "O pedido não existe ou já foi fechado!";
                    }
                } else {
                    $this->mensagem = "O produto está com o estoque zerado, desativado ou é um serviço.";
                }
            } else {
                $this->mensagem = "Erro: Você selecionou um serviço";
            }
        } else {
            $this->mensagem = "Esse produto não existe no banco de dados!";
        }

        if ($this->mensagem == NULL) {
            $ProdutoInfo = $this->join_model->PedidoProduto($idLstProd)->result();
            $Total = $this->geral_model->TotalPedido($id_pedido)->row();
            array_push($ProdutoInfo, array('Total' => $this->convert->em_real($Total->total)));
        } else {
            $ProdutoInfo = array('msg' => $this->mensagem);
        }

        $dados = array(
            'query' => $ProdutoInfo,
        );

        $this->load->view('json', $dados);
    }

    public function AddProdCompra($id_pedido, $id_produto) {
        //verifica se o produto existe
        $produto = $this->join_model->ProdutoEstoque($id_produto)->row();
        if ($produto != NULL) {
            if ($produto->PRO_TIPO === 'p') {
                //verifica se existe realmente um pedido com o id passado
                if ($this->crud_model->pega("PEDIDOS", array('PEDIDO_ID' => $id_pedido, 'PEDIDO_ESTATUS' => '1'))->row() != NULL) {
                    //verififca se já existe o prodoto na lista de pedido
                    if (!$this->crud_model->pega("LISTA_PRODUTOS", array('ESTOQ_ID' => $produto->ESTOQ_ID, 'PEDIDO_ID' => $id_pedido))->row()) {
                        //inseri os dados abaixo no db
                        $dados = array(
                            'PEDIDO_ID' => $id_pedido,
                            'ESTOQ_ID' => $produto->ESTOQ_ID,
                            'LIST_PED_QNT' => '1',
                            'LIST_PED_COMP' => $produto->ESTOQ_CUSTO,
                            'LIST_PED_PRECO' => $produto->ESTOQ_PRECO);
                        if ($this->crud_model->inserir('LISTA_PRODUTOS', $dados) != TRUE) {
                            $this->mensagem = "Erro: problema ao adicionar item no pedido!";
                        } else {
                            $idLstProd = $this->db->insert_id();
                        }
                    } else {
                        $this->mensagem = "O item já existe, se deseja altera quantidades, click em uma das setas em QUANTIDADE.";
                    }
                } else {
                    $this->mensagem = "Erro: O pedido não existe ou já foi fechado!";
                }
            } else {
                $this->mensagem = "Erro: Você selecionou um serviço";
            }
        } else {
            $this->mensagem = "Erro: O produto não existe no banco de dados";
        }

        if ($this->mensagem == NULL) {
            $ProdutoInfo = $this->join_model->PedidoProduto($idLstProd)->result();
            $Total = $this->geral_model->TotalPedComp($id_pedido)->row();
            array_push($ProdutoInfo, array('Total' => $this->convert->em_real($Total->total)));
        } else {
            $ProdutoInfo = array('msg' => $this->mensagem);
        }

        $dados = array(
            'query' => $ProdutoInfo,
        );

        $this->load->view('json', $dados);
    }

    public function AddProdOs($id_os, $id_produto) {
        //verifica se o produto ou serviço existe
        $produto = $this->join_model->ProdutoEstoque($id_produto)->row();
        if ($produto != NULL) {
            if (($produto->ESTOQ_ATUAL >= 1 and $produto->PRO_ESTATUS === 'a') or ( $produto->PRO_TIPO === 's')) {
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
                $this->mensagem = "Erro: O produto está com o estoque zerado ou desativado!";
            }
        } else {
            $this->mensagem = "Erro: O produto ou serviço não existe no banco de dados.";
        }

        if ($this->mensagem == NULL) {
            $ProdutoInfo = $this->join_model->ListaProdOs($id_os)->result();
            $Total = $this->geral_model->TotalProdOS($id_os)->row();
            array_push($ProdutoInfo, array('Total' => $this->convert->em_real($Total->total)));
        } else {
            $ProdutoInfo = array('msg' => $this->mensagem);
        }

        $dados = array(
            'query' => $ProdutoInfo,
        );

        $this->load->view('json', $dados);
    }

    public function AtualizaQntItems() {
        // validar o formulario
        $this->form_validation->set_rules('Pedido', '', 'required');
        $this->form_validation->set_rules('ListPed', '', 'required');
        $this->form_validation->set_rules('Estoq_id', '', 'required');
        $this->form_validation->set_rules('qtd', '', 'required');

        $this->form_validation->set_error_delimiters('<span class="label label-danger">', '</span>');

        // se for valido ele chama o inserir dentro do produto_model
        if ($this->form_validation->run()) {

            $post = $this->input->post();

            if ($this->mensagem == NULL AND $this->UpdtQntItem($post['ListPed'], $post['Estoq_id'], $post['qtd'])) {
                $FuncaoTotal = (isset($post['tipo']) AND $post['tipo'] == "c") ? 'TotalPedComp' : 'TotalPedido';
                $Retorno_array = array();
                $Dados_Array = array();

                $ProdutoInfo = $this->join_model->PedidoProduto($post['ListPed'])->row();

                $Dados_Array['LIST_PED_ID'] = $ProdutoInfo->LIST_PED_ID;
                $Dados_Array['LIST_PED_QNT'] = $ProdutoInfo->LIST_PED_QNT;
                $Dados_Array['LIST_PED_PRECO'] = (isset($post['tipo']) AND $post['tipo'] == "c") ? $ProdutoInfo->LIST_PED_COMP : $ProdutoInfo->LIST_PED_PRECO;

                $Total = $this->geral_model->$FuncaoTotal($post['Pedido'])->row();
                array_push($Retorno_array, $Dados_Array);
                array_push($Retorno_array, array('Total' => $this->convert->em_real($Total->total)));
            } else {
                $Retorno_array = array('msg' => $this->mensagem);
            }

//            $Retorno_array = array('msg' => $this->mensagem);

            $dados = array(
                'query' => $Retorno_array,
            );

            $this->load->view('json', $dados);
        }
    }

    public function AtualizaQntItemOs() {
        // validar o formulario
        $this->form_validation->set_rules('Os', 'O id da ordem de serviço!', 'required');
        $this->form_validation->set_rules('ListPed', 'O id da lista de pedido não passado!', 'required');
        $this->form_validation->set_rules('Estoq_id', 'O id do estoque não passado!', 'required');
        $this->form_validation->set_rules('qtd', 'A quantidade não passada!', 'required');

        $this->form_validation->set_error_delimiters('<span class="label label-danger">', '</span>');

        // se for valido ele chama o inserir dentro do produto_model
        if ($this->form_validation->run() == TRUE) {

            $post = $this->input->post();

            if ($this->mensagem == NULL AND $this->UpdtQntItem($post['ListPed'], $post['Estoq_id'], $post['qtd'])) {
                $Retorno_array = array();
                $Dados_Array = array();

                $ProdutoInfo = $this->join_model->PedidoProduto($post['ListPed'])->row();

                $Dados_Array['LIST_PED_ID'] = $ProdutoInfo->LIST_PED_ID;
                $Dados_Array['LIST_PED_QNT'] = $ProdutoInfo->LIST_PED_QNT;
                $Dados_Array['LIST_PED_PRECO'] = $ProdutoInfo->LIST_PED_PRECO;

                $Total = $this->geral_model->TotalProdOS($post['Os'])->row();
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
    }

    public function Abrir($id_pedido) {

        // verifica se existe o pedido
        $pedido = $this->crud_model->pega("PEDIDOS", array('PEDIDO_ID' => $id_pedido))->result();
        if ($pedido != NULL) {
            $ProdutoInfo = $this->join_model->ListaPedido($id_pedido)->result();
            $Total = $this->geral_model->TotalPedido($id_pedido)->row();
            array_push($ProdutoInfo, array('Total' => $this->convert->em_real($Total->total)));
        } else {
            $ProdutoInfo = array('msg' => "O pedido não existe ou foi apagado!");
        }

        $dados = array(
            'query' => $ProdutoInfo,
        );

        $this->load->view('json', $dados);
    }

    public function AbrirLstProdutoOS($id_os) {

        // verifica se existe o pedido
        $pedido = $this->crud_model->pega("ORDEM_SERV", array('OS_ID' => $id_os))->result();
        if ($pedido != NULL) {
            $ProdutoInfo = $this->join_model->ListaProdOs($id_os)->result();
            $Total = $this->geral_model->TotalProdOS($id_os)->row();
            array_push($ProdutoInfo, array('Total' => $this->convert->em_real($Total->total)));
        } else {
            $ProdutoInfo = array('msg' => "O pedido não existe ou foi apagado!");
        }

        $dados = array(
            'query' => $ProdutoInfo,
        );

        $this->load->view('json', $dados);
    }

    public function RemoverItem($tipo, $id_pedido, $lista_ped_id) {

        if ($this->crud_model->excluir("LISTA_PRODUTOS", array('LIST_PED_ID' => $lista_ped_id)) !== TRUE) {
            $resposta = array('msg' => "Erro: problema com a exclusão do item");
        } else {
            $FuncaoTotal = ($tipo == "c") ? 'TotalPedComp' : 'TotalPedido';
            $Total = $this->geral_model->$FuncaoTotal($id_pedido)->row();
            $resposta = array();
            array_push($resposta, array('Total' => $this->convert->em_real($Total->total)));
        }

        $dados = array('query' => $resposta);

        $this->load->view('json', $dados);
    }

    public function RemoverItemOs($id_os, $lista_ped_id) {

        if ($this->crud_model->excluir("LISTA_PRODUTOS", array('LIST_PED_ID' => $lista_ped_id)) !== TRUE) {
            $resposta = array('msg' => "Erro: problema com a exclusão do item");
        } else {
            $Total = $this->geral_model->TotalProdOS($id_os)->row();
            $resposta = array();
            array_push($resposta, array('Total' => $this->convert->em_real($Total->total)));
        }

        $dados = array('query' => $resposta);

        $this->load->view('json', $dados);
    }

    public function Delete($id_pedido) {
        if ($this->input->post('id_pedido') > 0) {
            if ($id_pedido > 0) {
                $pedido = $this->crud_model->pega("PEDIDOS", array('PEDIDO_ID' => $id_pedido))->row();
                if ($pedido != null) {
                    if ($pedido->PEDIDO_ESTATUS <= 1) {
                        $this->geral_model->ExcluirPedido($id_pedido);
                        $this->mensagem = "Pedido excluido com sucesso!";
                    } else {
                        if ($this->geral_model->ReabrirPedido($id_pedido) >= 1) {
                            if ($this->geral_model->ExcluirPedido($id_pedido) == TRUE) {
                                $this->mensagem = "Pedido reaberto e excluido!";
                            }
                        }
                    }
                } else {
                    $this->mensagem = "O pedido que não existe!";
                }
            } else {
                $this->mensagem = "Pedido não selecionado!";
            }
        }
        $dados = array(
            'tela' => "pedido/excluir",
            'id_pedido' => $id_pedido,
            'mensagem' => $this->mensagem,
        );
        $this->load->view('contente', $dados);
    }

    public function Receber($id_pedido) {

        $this->form_validation->set_rules('id_pedido', 'id', 'is_natural_no_zero');

        $post = $this->input->post();

        if ($this->form_validation->run() == TRUE) {
            if ($this->geral_model->AddCompraEstoq($id_pedido) > 0) {
                $this->mensagem = "Entrada no estoque feita com sucesso!";
            } else {
                $this->mensagem = "Não ouve entrada no estoque, provavelmente o pedido já foi fechado anteriormente!";
            }
            $atualizar = array('PEDIDO_N_DOC' => $post['PEDIDO_N_DOC'], 'PEDIDO_OBS' => $post['PEDIDO_OBS']);
            $condicao = array('PEDIDO_ID' => $post['id_pedido']);
            if ($this->crud_model->update("PEDIDOS", $atualizar, $condicao) == FALSE) {
                $this->mensagem .= "Erro: Problema ao adicionar NUMERO DOCUMENTO e OBS. DO PEDIDO!";
            }
        }
        $dados = array(
            'tela' => "pedido/receber",
            'id_pedido' => $id_pedido,
            'mensagem' => $this->mensagem,
            'LstPedido' => $this->join_model->ListaPedido($id_pedido)->result(),
        );
        $this->load->view('contente', $dados);
    }

    /////////////////////////////////////////////////////
    // Funções privadas
    /////////////////////////////////////////////////////
    private function UpdtQntItem($ListPed, $Estoq_id, $qtd) {
        // Verifica se a quantidade digitada é maior que 0\
        //echo is_numeric($qtd);
        if ($qtd > 0 AND is_numeric($qtd) == TRUE) {
            // pega o item dentro da lista de produto
            $pedido = $this->crud_model->pega("LISTA_PRODUTOS", array('LIST_PED_ID' => $ListPed))->result();
            if ($pedido != NULL) {
                $produto = $this->crud_model->pega("ESTOQUES", array('ESTOQ_ID' => $Estoq_id))->row();
                // Verifica de tem estoque suficiente ou se é serviço "-1
                if ($produto->ESTOQ_ATUAL < $qtd AND $produto->ESTOQ_MIN != -1) {
                    $this->mensagem = "Não existe estoque suficiente! O estoque atual é de " . $produto->ESTOQ_ATUAL . " unidades!";
                }
                $atualizar = array('LIST_PED_QNT' => $qtd);
                $condicao = array('LIST_PED_ID' => $ListPed);
                if ($this->crud_model->update("LISTA_PRODUTOS", $atualizar, $condicao) == FALSE) {
                    $this->mensagem = "Erro: Problema ao atualuzar item!";
                }
            } else {
                $this->mensagem = "Erro: Nã existe esse item no pedido";
            }
        } else {
            $this->mensagem = "Erro: Não é aceitavel quantidades menores que 0,01! ou você não digitou numero";
        }
        if ($this->mensagem == NULL)
            return true;
    }

}
