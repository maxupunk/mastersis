<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Produto extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('produto_model');
    }

    public function index() {
        $dados = array(
            'titulo' => "Paginas Index do Produto.",
            'tela' => "produto",
        );
        $this->load->view('home', $dados);
    }

//
//Função Cadastrar
//	    
    public function cadastrar() {
        // validar o formulario
        $this->form_validation->set_rules('PRO_DESCRICAO', 'DESCRIÇÃO DO PRODUTO', 'required|max_length[45]|strtoupper|is_unique[PRODUTOS.PRO_DESCRICAO]');
        $this->form_validation->set_message('is_unique', 'Essa %s já esta cadastrado no banco de dados!');
        $this->form_validation->set_rules('PRO_CARAC_TEC', 'CARACTERISTICA TECNICA');
        $this->form_validation->set_rules('PRO_VAL_CUST', 'PREÇO DE CUSTO');
        $this->form_validation->set_rules('PRO_VAL_VEND', 'PREÇO DE VENDA');

        // se for valido ele chama o inserir dentro do produto_model        
        if ($this->form_validation->run() == TRUE):
            $formulario = $this->input->post();

            $source = array('.', ',');
            $replace = array('', '.');

            $custo = $formulario['PRO_VAL_CUST'];
            $custo = str_replace($source, $replace, $custo);

            $venda = $formulario['PRO_VAL_VEND'];
            $venda = str_replace($source, $replace, $venda);

            $atualiza = array('PRO_VAL_VEND' => $venda, 'PRO_VAL_CUST' => $custo);

            $novo_form = array_replace($formulario, $atualiza);

            $dados = elements(array('PRO_DESCRICAO', 'PRO_CARAC_TEC', 'PRO_VAL_CUST', 'PRO_VAL_VEND'), $novo_form);
            $this->produto_model->inserir($dados);
        endif;

        $dados = array(
            'produtos' => $this->produto_model->pega_tudo()->result(),
            'tela' => 'prod_cadastro',
        );
        $this->load->view('contente', $dados);
    }

    public function lista() {
        $this->load->library('pagination');
        $config['base_url'] = base_url('produto/lista');
        $config['total_rows'] = $this->produto_model->pega_tudo()->num_rows();
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
            'produtos' => $this->produto_model->pega_tudo($quant, $inicial)->result(),
            'tela' => 'prod_lista',
            'paginacao' => $this->pagination->create_links(),
        );
        $this->load->view('contente', $dados);
    }

//
//Função Editar
//	
    public function editar() {
        // validar o formulario
        $this->form_validation->set_rules('PRO_DESCRICAO', 'DESCRIÇÃO DO PRODUTO', 'required|max_length[45]|strtoupper|is_unique[PRODUTOS.PRO_DESCRICAO]');
        $this->form_validation->set_message('is_unique', 'Essa %s já esta cadastrado no banco de dados!');

        // se for valido ele chama o inserir dentro do produto_model
        if ($this->form_validation->run() == TRUE):
            $dados = elements(array('PRO_DESCRICAO', 'PRO_CARAC_TEC', 'PRO_VAL_CUST', 'PRO_VAL_VEND'), $this->input->post());
            $this->produto_model->update($dados, array('PRO_ID' => $this->input->post('id_produto')));
        endif;

        $dados = array(
            'tela' => "prod_editar",
        );
        $this->load->view('contente', $dados);
    }

//
//Função Editar
//	
    public function adiciona_img() {
        // validar o formulario
        $this->load->model('funcoes');

        $config['upload_path'] = APPPATH . 'views/produto_img/';
        $config['allowed_types'] = 'jpg';
        $config['max_size'] = '2048';
        $config['file_name'] = $this->input->post('id_produto');
        $config['overwrite'] = TRUE;
        $config['max_width'] = '1024';
        $config['max_heigh'] = '768';

        $this->load->library('upload', $config);

        // se for valido ele chama o inserir dentro do produto_model
        if ($this->upload->do_upload()):
            $data = $this->upload->data();
            $this->funcoes->createThumbnail($data['file_name'], $config['upload_path']);
            $this->produto_model->update(array('PRO_IMG' => $data['file_name']), array('PRO_ID' => $this->input->post('id_produto')));
            $mensagem = "Imagem alterada com sucesso!";
        else:
            $mensagem = $this->upload->display_errors();
        endif;

        $dados = array(
            'tela' => "mensagem",
            'mensagem' => $mensagem,
        );
        $this->load->view('contente', $dados);
    }

//
//Função Excluir
//	    
    public function excluir() {
        if ($this->input->post('id_produto') > 0):
            $this->produto_model->excluir(array('PRO_ID' => $this->input->post('id_produto')));
        endif;

        $dados = array(
            'tela' => "prod_excluir",
        );
        $this->load->view('contente', $dados);
    }

//
//Função Buscar
//	            
    public function busca() {
        $dados = array(
            'titulo' => "Produto busca",
            'tela' => "prod_busca",
        );
        $this->load->view('contente', $dados);
    }

}