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
            'tela' => "ordemservico/ordemservico",
        );
        $this->load->view('home', $dados);
    }

    public function Ordens($id = 1) {
        $Lista = $this->join_model->OsStatus($id, 'OS_DATA_ENT asc')->result();
        if (isset($Lista)) {
            $this->load->view('json', array('query' => $Lista));
        }
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
                $this->mensagem = "Cadastrado realizado com sucesso!";
            } else {
                $this->mensagem = "Erro ao grava no banco de dados!";
            }
        endif;

        $dados = array(
            'tela' => "ordemservico/cadastro",
            'mensagem' => $this->mensagem,
        );
        $this->load->view('contente', $dados);
    }

    public function imprimir($id) {
        $OsDados = $this->join_model->OsDados($id)->row();
        $dados = array(
            'tela' => "ordemservico/imprimir",
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
        $ordem = $this->crud_model->pega("ORDEM_SERV", array('OS_ID' => $id))->row();
        // Verifica se a ordem não foi entregue
        if ($ordem->OS_ESTATUS <= 3) {
            // se for valido ele chama o inserir dentro do produto_model
            if ($this->form_validation->run() == TRUE) {
                $dados = elements(array('OS_DSC_SOLUC', 'OS_DSC_PENDENT', 'OS_ESTATUS'), $this->input->post());
                if ($this->crud_model->update("ORDEM_SERV", $dados, array('OS_ID' => $this->input->post('id_os'))) === TRUE) {
                    $this->mensagem = "Alteraçoes salvas com sucesso!";
                } else {
                    $this->mensagem = "Erro ao gravano banco de dados!";
                }
            }
            $dados = array(
                'tela' => "ordemservico/editar",
                'OsDados' => $this->join_model->OsDados($id)->row(),
                'total' => $this->geral_model->TotalProdOs($id)->row(),
                'Estatus' => $ordem->OS_ESTATUS,
                'mensagem' => $this->mensagem,
            );
            $this->load->view('contente', $dados);
        } else {
            $dados = array('mensagem' => "Ordem de serviço ja entregue, para edita você deve reabrir!");
            $this->load->view('mensagem', $dados);
        }
    }

    public function excluir($id) {
        if ($this->input->post('id_os') > 0) {
            if ($this->geral_model->ExcluirOs($id) === TRUE) {
                $this->mensagem = "exclusão realizada com sucesso!";
            } else {
                $this->mensagem = "Erro ao grava no banco de dados!";
            }
        }

        $dados = array(
            'tela' => "ordemservico/excluir",
            'OsDados' => $this->join_model->OsDados($id)->row(),
            'mensagem' => $this->mensagem,
        );
        $this->load->view('contente', $dados);
    }

    public function entregar($id) {
        $this->form_validation->set_rules('PEDIDO_ID', 'ID DO PEDIDO', 'required');
        if ($this->form_validation->run() === TRUE) {
            $OsDados = $this->join_model->OsDados($id)->row();
            if ($this->geral_model->FechaOs($id) > 0) {
                $this->mensagem = 'Ordem entregue com sucesso!';
            } else {
                $this->mensagem = 'Essa ordem já foi fechado anteriormente ou ouve outro problema!';
            }
            $dados = array(
                'tela' => "ordemservico/recibo",
                'mensagem' => $this->mensagem,
                'ListaPedido' => $this->join_model->ListaProdOs($id)->result(),
                'total' => $this->geral_model->TotalProdOs($id)->row(),
                'OsDados' => $OsDados,
                'empresa' => $this->crud_model->pega_tudo("EMPRESAS")->row(),
                'pessoa' => $this->join_model->EnderecoCompleto($OsDados->PES_ID)->row(),
            );
        } else {
            $os = $this->crud_model->pega("ORDEM_SERV", array('OS_ID' => $id))->row();
            $dados = array(
                'tela' => "ordemservico/entregar",
                'total' => $this->geral_model->TotalProdOS($id)->row(),
                'pessoa' => $this->join_model->EnderecoCompleto($os->PES_ID)->row(),
                'id_pedido' => $id,
            );
        }
        $this->load->view('contente', $dados);
    }

    public function reabrir($id) {

        if ($this->geral_model->ReabrirOs($id) > 0) {
            $this->mensagem = 'Pedido foi reaberto com sucesso!';
        } else {
            $this->mensagem = 'Esse pedido já esta aberto!';
        }


        $this->load->view('mensagem', array('mensagem' => $this->mensagem));
    }

}
