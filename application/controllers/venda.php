<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Venda extends CI_Controller {

    var $mensagem;

    public function __construct() {
        parent::__construct();
        $this->load->model(array('crud_model', 'join_model', 'geral_model'));
        $this->load->library(array('form_validation', 'table', 'convert'));
        $this->auth->check_logged($this->router->class, $this->router->method);
    }

    public function index() {
        $dados = array(
            'tela' => "venda/venda",
        );
        $this->load->view('home', $dados);
    }

    public function Novo() {
        $dados = array(
            'USUARIO_ID' => $this->session->userdata('USUARIO_ID'),
            'PEDIDO_DATA' => date("Y-m-d h:i:s"),
            'PEDIDO_ESTATUS' => '1',
            'PEDIDO_LOCAL' => "l",
            'PEDIDO_TIPO' => "v");
        if ($this->crud_model->inserir('PEDIDOS', $dados) == TRUE) {
            $id_pedido = $this->db->insert_id();
        } else {
            $this->mensagem = "Erro ao grava pedido no banco de dados!";
        }
        echo json_encode($id_pedido);
    }

    public function AddCliente($IdPed = NULL, $IdCliente = NULL) {
        $atualizar = array('PES_ID' => $IdCliente);
        $condicao = array('PEDIDO_ID' => $IdPed);
        if ($this->crud_model->update("PEDIDOS", $atualizar, $condicao) == FALSE) {
            return "Erro: Problema ao adiciona cliente na compra!";
        }
    }

    public function Pagamento($id_pedido) {

        $this->form_validation->set_rules('NPARCELA', 'Numero de parcela', 'required');

        $post = $this->input->post();

        $this->form_validation->set_rules('PES_ID', 'cliente', 'required');
        $this->form_validation->set_message('required', 'Em vendas parceladas é obrigatoria a identificação do %s');

        $this->form_validation->set_rules('FPG', 'Forma de pagamento', 'required');

        $this->form_validation->set_error_delimiters('<span class="label label-danger">', '</span>');

        if ($this->form_validation->run() == TRUE) {

            $this->db->trans_begin();

            $pedido = $this->crud_model->pega("PEDIDOS", array('PEDIDO_ID' => $id_pedido))->row();
            $total = $this->geral_model->TotalPedido($id_pedido)->row();

            if ($this->geral_model->FechaVenda($id_pedido, $post['PES_ID']) > 0) {

                $Nparcela = $pedido->PEDIDO_NPARC;

                $FPG = $this->crud_model->pega("FORMA_PG", array('FPG_ID' => $post['FPG']))->row();
                $Jurus = ((($FPG->FPG_AJUSTE / 100) * $total->total) * $Nparcela);
                $TotalJurus = $Jurus + $total->total;

                $valor_parcela = floatval($TotalJurus / $Nparcela);

                $dias = 0;
                for ($i = 0; $i < $Nparcela; $i++) {
                    $dados = array(
                        'PEDIDO_ID' => $id_pedido,
                        'PES_ID' => $post['PES_ID'],
                        'DESREC_NATUREZA' => '1',
                        'DESREC_VALOR' => $valor_parcela,
                        'DESREC_VECIMENTO' => date('Y-m-d', strtotime($dias . " days", strtotime("now"))),
                        'DESCRE_ESTATUS' => 'AB'
                    );
                    if ($this->crud_model->inserir('DESPESA_RECEITA', $dados) !== TRUE) {
                        log_message('error', 'Erro ao grava parcela no banco de dados! Parcela:' . $i);
                    }
                    $dias += 30;
                }

                $atualizar = array(
                    'PEDIDO_OBS' => $post['PEDIDO_OBS'],
                    'PES_ID' => $post['PES_ID'],
                );
                $condicao = array('PEDIDO_ID' => $id_pedido);
                if ($this->crud_model->update("PEDIDOS", $atualizar, $condicao) == FALSE) {
                    log_message('error', 'Erro ao grava parcela no banco de dados!');
                }
            } else {
                $this->mensagem .= 'Esse pedido já foi fchado anteriormente!';
            }

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $this->mensagem .= 'Ouve algum problema na transação com o banco de dados!';
            } else {
                $this->db->trans_commit();
            }

            $dados = array(
                'tela' => "venda/recibo",
                'mensagem' => $this->mensagem,
                'pedido' => $pedido,
                'lista_pedido' => $this->join_model->ListaPedido($id_pedido)->result(),
                'total' => $total,
                'empresa' => $this->crud_model->pega_tudo("EMPRESAS")->row(),
            );

            $this->load->view('contente', $dados);
        } else {

            $pedido = $this->crud_model->pega("PEDIDOS", array('PEDIDO_ID' => $id_pedido))->row();
            if ($pedido == NULL) {
                $this->mensagem = 'Esse pedido já foi fechado anteriormente!';
                $dados = array(
                    'tela' => "venda/pagar",
                    'mensagem' => $this->mensagem,
                    'id_pedido' => $id_pedido,
                );
                $this->load->view('contente', $dados);
            } else {
                $dados = array(
                    'tela' => "venda/pagar",
                    'forma_pgs' => $this->crud_model->pega("FORMA_PG", array('FPG_STATUS' => 'a'))->result(),
                    'total' => $this->geral_model->TotalPedido($id_pedido)->row(),
                    'id_pedido' => $id_pedido,
                );
                $this->load->view('contente', $dados);
            }
        }
    }

    public function Listar($IdCliente) {

        $this->load->library('pagination');
        $config['base_url'] = base_url('venda/listar/' . $IdCliente);
        $config['total_rows'] = $this->geral_model->PedidosCliente($IdCliente)->num_rows();
        $config['per_page'] = 10;
        $config['uri_segment'] = 4;
        $config['num_links'] = 30;

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
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['first_link'] = 'Primeira';
        $config['last_link'] = 'Ultima';

        $this->uri->segment(4) != '' ? $inicial = $this->uri->segment(4) : $inicial = 0;

        $this->pagination->initialize($config);


        $dados = array(
            'pedidos_cliente' => $this->geral_model->PedidosCliente($IdCliente, $config['per_page'], $inicial, 'PEDIDO_DATA desc')->result(),
            'tela' => 'venda/listar',
            'paginacao' => $this->pagination->create_links(),
        );
        $this->load->view('contente', $dados);
    }

}
