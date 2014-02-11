<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Categoria extends CI_Controller {

    var $mensagem;
    public function __construct() {
        parent::__construct();
        $this->load->model('crud_model');
        $this->load->library(array('form_validation', 'table'));
        $this->auth->check_logged($this->router->class , $this->router->method);
    }

    public function index() {
        $dados = array(
            'tela' => "categoria",
        );
        $this->load->view('home', $dados);
    }
    
    public function cadastrar() {

        $this->form_validation->set_rules('CATE_NOME', 'CATEGORIA', 'required|max_length[20]|strtoupper|is_unique[CATEGORIA.CATE_NOME]');
        $this->form_validation->set_message('is_unique', 'Essa %s já esta cadastrado no banco de dados!');

        $this->form_validation->set_error_delimiters('<span class="label label-danger">', '</span>');
        
        
        //verifica se passou na validação
        if ($this->form_validation->run() == TRUE):

            $dados = elements(array('CATE_NOME', 'CATE_DESCRIC'), $this->input->post());
            if ($this->crud_model->inserir("CATEGORIA", $dados) == TRUE) {
                $this->mensagem = $this->lang->line("msg_cadastro_sucesso");
            } else {
                $this->mensagem = $this->lang->line("msg_cadastro_erro");
            }
        endif;

        $dados = array(
            'tela' => "categ_cadastro",
            'mensagem' => $this->mensagem,
        );
        $this->load->view('contente', $dados);
    }

    public function listar() {
        $this->load->library('pagination');

        $config['base_url'] = base_url('categoria/listar');
        $config['total_rows'] = $this->crud_model->pega_tudo('CATEGORIA')->num_rows();
        $config['per_page'] = 10;

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

        $this->uri->segment(3) != '' ? $inicial = $this->uri->segment(3) : $inicial = 0;

        $this->pagination->initialize($config);

        $dados = array(
            'categoria' => $this->crud_model->pega_tudo("CATEGORIA", $config['per_page'], $inicial)->result(),
            'tela' => 'categ_listar',
            'total' => $this->crud_model->pega_tudo("CATEGORIA")->num_rows(),
            'paginacao' => $this->pagination->create_links(),
        );
        $this->load->view('contente', $dados);
    }

    public function busca() {
        $busca = $_GET['buscar'];
        $dados = array(
            'tela' => "categ_busca",
            'query' => $query = $this->crud_model->buscar("CATEGORIA", array('CATE_ID' => $busca, 'CATE_NOME' => $busca))->result(),

        );
        $this->load->view('contente', $dados);
    }

    public function editar($id_categoria) {

        $this->form_validation->set_rules('CATE_NOME', 'NOME CATEGORIA', 'required|max_length[45]');

        $this->form_validation->set_error_delimiters('<span class="label label-danger">', '</span>');

        
        // se for valido ele chama o inserir dentro do produto_model
        if ($this->form_validation->run() == TRUE):

            $dados = elements(array('CATE_NOME', 'CATE_DESCRIC', 'CATE_ESTATUS'), $this->input->post());
            if ($this->crud_model->update("CATEGORIA", $dados, array('CATE_ID' => $this->input->post('id_categoria'))) === TRUE) {
                $this->mensagem = $this->lang->line("msg_editar_sucesso");
            } else {
                $this->mensagem = $this->lang->line("msg_ediatr_erro");
            }

        endif;

        $dados = array(
            'tela' => "categ_editar",
            'mensagem' => $this->mensagem,
            'query' => $this->crud_model->pega("CATEGORIA", array('CATE_ID' => $id_categoria))->row(),
        );
        $this->load->view('contente', $dados);
    }

    public function imagem() {
        // validar o formulario
        $this->load->library(array('image_lib', 'upload'));

        $img['upload_path'] = 'assets/img_categoria/';
        $img['allowed_types'] = 'jpg';
        $img['max_size'] = '2048';
        $img['file_name'] = $this->input->post('id_categoria');
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

            if ($this->crud_model->update("CATEGORIA", array('CATE_IMG' => $data['file_name']), array('CATE_ID' => $this->input->post('id_categoria'))) === TRUE) {
                $this->mensagem = $this->lang->line("msg_imagem_sucesso");
            } else {
                $this->mensagem = $this->lang->line("msg_imagem_erro");
            }

        endif;

        $dados = array(
            'tela' => "categ_imagem",
            'upload' => @$this->upload->display_errors(),
            'thumb' => @$this->image_lib->display_errors(),
            'mensagem' => $this->mensagem,
        );
        $this->load->view('contente', $dados);
    }

}