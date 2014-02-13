<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ordemservico extends CI_Controller {

    var $mensagem;

    public function __construct() {
        parent::__construct();
        $this->load->model(array('crud_model', 'join_model', 'geral_model'));
        $this->load->library(array('form_validation', 'table'));
        $this->auth->check_logged($this->router->class, $this->router->method);
    }

    public function index() {
        
        $dados = array(
            'tela' => "ordem_servico",
            'emabertos' => $this->join_model->OsStatus('1')->result(),
            'pendentes' => $this->join_model->OsStatus('2')->result(),
            'concluidos' => $this->join_model->OsStatus('3')->result(),
        );
        $this->load->view('home', $dados);
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
                $this->mensagem = $this->lang->line("msg_cadastro_os_sucesso").$this->db->insert_id();
            } else {
                $this->mensagem = $this->lang->line("msg_cadastro_os_erro");
            }
        endif;

        $dados = array(
            'tela' => "os_cadastro",
            'mensagem' => $this->mensagem,
        );
        $this->load->view('contente', $dados);
    }
    
    public function detalhes($id) {
        $dados = array(
            'tela' => "os_detalhes",
            'Detalhes' => $this->join_model->OsDetalhes($id)->row(),
            'ListaProduto' => $this->join_model->ListaProduto($id)->result(),
            'ListaProdutoTotal' => $this->geral_model->TotalProduto($id)->row(),
            'ListaServico' => $this->join_model->ListaServico($id)->result(),
            'ListaServicoTotal' => $this->geral_model->TotalServico($id)->row(),
        );
        $this->load->view('contente', $dados);
    }
    
    public function teste(){
        echo "<pre>";
        print_r($this->join_model->ListaServico(40)->result());
        echo "</pre>";
    }

}