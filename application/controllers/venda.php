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
            $estatus = $this->crud_model->pega("PEDIDO", array('PES_ID' => $id_cliente, 'PEDIDO_TIPO' => 'v', 'PEDIDO_ESTATUS' => '1'))->row();
            if ($estatus == NULL) {
                $pedido = array(
                    'PES_ID' => $id_cliente,
                    //'USU_ID' => '',
                    'PEDIDO_DATA' => date("Y-m-d h:i:s"),
                    'PEDIDO_ESTATUS' => '1',
                    'PEDIDO_TIPO' => 'v');
                if ($this->crud_model->inserir('PEDIDO', $pedido) != TRUE) {
                    $mensagem = $this->lang->line("msg_pedido_erro");
                } else {
                    $id_venda = $this->db->insert_id();
                }
            } else {
                $mensagem = $this->lang->line("msg_pedido_aberto");
                $id_venda = $estatus->PEDIDO_ID;
            }
        }
        $dados = array(
            'tela' => 'venda_abrir',
            'id_venda' => $id_venda,
            'cliente' => $this->join_model->endereco_completo($id_cliente)->row(),
            'mensagem' => @$mensagem,
        );
        $this->load->view('contente', $dados);
    }

    public function listar() {

        $this->load->library('pagination');
        $config['base_url'] = base_url('vendas/listar');
        $config['total_rows'] = $this->crud_model->pega_tudo("PRODUTOS")->num_rows();
        $config['per_page'] = 10;
        $quant = $config['per_page'];

        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="disabled"><a>';
        $config['cur_tag_close'] = '</a></li>';
        $config['next_link'] = '&gt;';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['prev_link'] = '&lt;';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';

        $this->uri->segment(3) != '' ? $inicial = $this->uri->segment(3) : $inicial = 0;

        $this->pagination->initialize($config);

        $dados = array(
            'produtos' => $this->crud_model->pega_tudo("PRODUTOS", $quant, $inicial)->result(),
            'tela' => 'prod_listar',
            'total' => $this->crud_model->pega_tudo("PRODUTOS")->num_rows(),
            'paginacao' => $this->pagination->create_links(),
        );
        $this->load->view('contente', $dados);
    }

    public function editar() {

        $this->form_validation->set_rules('PRO_DESCRICAO', 'DESCRIÇÃO DO PRODUTO', 'required|max_length[100]');

        $this->form_validation->set_error_delimiters('<p class="text-error">', '</p>');

        // se for valido ele chama o inserir dentro do produto_model
        if ($this->form_validation->run() == TRUE):

            $dados = elements(array('PRO_DESCRICAO', 'PRO_CARAC_TEC', 'PRO_ESTATUS'), $this->input->post());
            if ($this->crud_model->update("PRODUTOS", $dados, array('PRO_ID' => $this->input->post('id_produto'))) === TRUE) {
                $mensagem = $this->lang->line("msg_editar_sucesso");
            } else {
                $mensagem = $this->lang->line("msg_editar_erro");
            }
        endif;

        $dados = array(
            'tela' => "prod_editar",
            'mensagem' => @$mensagem,
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
        var_dump($this->join_model->produto("1")->row());
        $teste = $this->join_model->produto("1")->row();
        echo $teste->PRO_NOME;
        echo $teste->ESTOQ_ATUAL;
        echo $teste->ESTOQ_CUSTO;
        echo $teste->ESTOQ_VENDA;
        echo "</pre>";
    }

}