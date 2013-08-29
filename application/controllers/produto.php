<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Produto extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('crud_model');
        $this->load->library(array('form_validation', 'table'));
        $this->auth->check_logged($this->router->class, $this->router->method);
    }

    public function index() {
        $dados = array(
            'tela' => "produto",
        );
        $this->load->view('home', $dados);
    }

    public function cadastrar() {
        // validar o formulario
        $this->form_validation->set_rules('PRO_DESCRICAO', 'DESCRIÇÃO DO PRODUTO', 'required|max_length[100]|strtoupper|is_unique[PRODUTOS.PRO_DESCRICAO]');
        $this->form_validation->set_message('is_unique', 'Essa %s já esta cadastrado no banco de dados!');
        $this->form_validation->set_rules('CATE_ID', 'CATEGORIA', 'required');
        $this->form_validation->set_rules('MEDI_ID', 'MEDIDA', 'required');

        $this->form_validation->set_error_delimiters('<span class="label label-danger">', '</span>');
        
        $mensagem = NULL;
        // se for valido ele chama o inserir dentro do produto_model
        if ($this->form_validation->run() == TRUE):

            $dados = elements(array('PRO_DESCRICAO', 'PRO_CARAC_TEC', 'CATE_ID', 'MEDI_ID', 'PRO_PESO'), $this->input->post());
            if ($this->crud_model->inserir('PRODUTOS', $dados) === TRUE) {
                $mensagem = $this->lang->line("msg_cadastro_sucesso");
            } else {
                $mensagem = $this->lang->line("msg_cadastro_erro");
            }

        endif;
        $dados = array(
            'tela' => 'prod_cadastro',
            'categorias' => $this->crud_model->pega_tudo("CATEGORIA")->result(),
            'medidas' => $this->crud_model->pega_tudo("MEDIDAS")->result(),
            'mensagem' => $mensagem,
        );
        $this->load->view('contente', $dados);
    }

    public function listar() {

        $this->load->library('pagination');
        $config['base_url'] = base_url('produto/listar');
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

    public function editar($id_produto) {

        $this->form_validation->set_rules('PRO_DESCRICAO', 'DESCRIÇÃO DO PRODUTO', 'required|max_length[100]');

        $this->form_validation->set_error_delimiters('<p class="text-error">', '</p>');

        $mensagem = NULL;
        // se for valido ele chama o inserir dentro do produto_model
        if ($this->form_validation->run() == TRUE):

            $dados = elements(array('PRO_DESCRICAO', 'PRO_CARAC_TEC', 'PRO_ESTATUS', 'PRO_PESO'), $this->input->post());
            if ($this->crud_model->update("PRODUTOS", $dados, array('PRO_ID' => $this->input->post('id_produto'))) === TRUE) {
                $mensagem = $this->lang->line("msg_editar_sucesso");
            } else {
                $mensagem = $this->lang->line("msg_editar_erro");
            }
        endif;

        $dados = array(
            'tela' => "prod_editar",
            'mensagem' => $mensagem,
            'query' => $this->crud_model->pega("PRODUTOS", array('PRO_ID' => $id_produto))->row(),
        );
        $this->load->view('contente', $dados);
    }

    public function imagem() {
        $mensagem = NULL;
        // validar o formulario
        $this->load->library(array('image_lib', 'upload'));

        $img['upload_path'] = 'assets/img_produto/';
        $img['allowed_types'] = 'jpg';
        $img['max_size'] = '2048';
        $img['file_name'] = $this->input->post('id_produto');
        $img['overwrite'] = TRUE;
        $img['max_width'] = '1024';
        $img['max_heigh'] = '768';

        $this->upload->initialize($img);

        // se for valido ele chama o inserir dentro do produto_model
        if ($this->upload->do_upload() == TRUE):

            $data = $this->upload->data();

            $thumb['image_library'] = "gd";
            $thumb['source_image'] = $data['file_path'] . $data['file_name'];
            $thumb['create_thumb'] = TRUE;
            $thumb['maintain_ratio'] = TRUE;
            $thumb['master_dim'] = "auto";
            $thumb['quality'] = "100%";
            $thumb['width'] = "120";
            $thumb['height'] = "120";
            $this->image_lib->initialize($thumb);
            $this->image_lib->resize();

            if ($this->crud_model->update("PRODUTOS", array('PRO_IMG' => $data['file_name']), array('PRO_ID' => $this->input->post('id_produto'))) === TRUE) {
                $mensagem = $this->lang->line("msg_imagem_sucesso");
            } else {
                $mensagem = $this->lang->line("msg_imagem_erro");
            }

        endif;

        $dados = array(
            'tela' => "prod_imagem",
            'upload' => $this->upload->display_errors(),
            'thumb' => $this->image_lib->display_errors(),
            'mensagem' => $mensagem,
        );
        $this->load->view('contente', $dados);
    }

    public function excluir($id_produto) {
        $mensagem = NULL;
        if ($this->input->post('id_produto') > 0):
            if ($this->crud_model->excluir("PRODUTOS", array('PRO_ID' => $this->input->post('id_produto'))) === TRUE) {
                $mensagem = $this->lang->line("msg_excluir_sucesso");
            } else {
                $mensagem = $this->lang->line("msg_excluir_sucesso");
            }
        endif;

        $dados = array(
            'tela' => "prod_excluir",
            'mensagem' => $mensagem,
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
        $dados = array(
            'tela' => "prod_exibir",
        );
        $this->load->view('contente', $dados);
    }

    public function pegaproduto() {
        $this->load->model('join_model');
        
        $busca = $_GET['buscar'];        
        $rows = $this->join_model->produto_busca($busca)->result();
        
        setlocale(LC_MONETARY, "pt_BR");
        
        $json_array = array();
        foreach ($rows as $row)
            array_push($json_array, array('id' => $row->PRO_ID, 'value' => $row->PRO_DESCRICAO.' | '. $row->ESTOQ_ATUAL.' | '.money_format('%n', $row->ESTOQ_PRECO)));

        $dados = array(
            'query' => $json_array,
        );


        $this->load->view('json', $dados);
    }

}