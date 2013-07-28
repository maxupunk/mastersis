<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pessoa extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('crud_model');
        $this->load->library(array('form_validation', 'table'));
    }

    public function index() {
        $dados = array(
            'tela' => "pessoa",
        );
        $this->load->view('home', $dados);
    }

    public function cadastrar() {
        // validar o formulario

        $this->form_validation->set_rules('PES_NOME', 'NOME DE PESSOA', 'required|strtoupper');

        $this->form_validation->set_rules('PES_CPF_CNPJ', 'CPF/CNPJ', 'required|strtoupper|is_unique[PESSOAS.PES_CPF_CNPJ]');
        $this->form_validation->set_message('is_unique', 'Esse %s já esta cadastrado no banco de dados!');

        if ($this->input->post('PES_TIPO') === 'f') {
            $this->form_validation->set_rules('PES_NOME_PAI', 'NOME DO PAI', 'required|strtoupper');
            $this->form_validation->set_rules('PES_NOME_MAE', 'NOME DA MAE', 'required|strtoupper');
            $this->form_validation->set_rules('PES_NASC_DATA', 'DATA DE NASCIMENTO', 'required');
        }

        $this->form_validation->set_rules('PES_CEL1', 'CELULAR 1', 'required');
        $this->form_validation->set_rules('RUA_ID', 'RUA', 'required');

        $this->form_validation->set_error_delimiters('<span class="label label-danger">', '</span>');

        // se for valido ele chama o inserir dentro do produto_model
        if ($this->form_validation->run() == TRUE) {

            $endereco = elements(array('END_NUMERO', 'END_REFERENCIA', 'RUA_ID'), $this->input->post());
            if ($this->crud_model->inserir('ENDERECOS', $endereco) === TRUE) {

                $post_pessoa = $this->input->post();

                // pega id do endereço
                $id_ende = array('END_ID' => $this->db->insert_id());

                //pega a data atual
                $data_atual = array('PES_DATA' => date("Y-m-d h:i:s"));

                // converte a data pra inserir no db
                $data_nasc = array('PES_NASC_DATA' => implode("-", array_reverse(explode("/", $post_pessoa['PES_NASC_DATA']))));

                //Desfazer a conversão de data
                //$data = implode("/",array_reverse(explode("-",$data)));
                // faz a atualização do array com os dados assima
                $post_pessoa = array_replace($post_pessoa, $id_ende);
                $post_pessoa = array_replace($post_pessoa, $data_nasc);
                $post_pessoa = array_replace($post_pessoa, $data_atual);


                $pessoa = elements(array('PES_NOME', 'PES_CPF_CNPJ', 'PES_NOME_PAI', 'PES_NOME_MAE', 'PES_NASC_DATA', 'PES_FONE', 'PES_CEL1', 'PES_CEL2', 'END_ID', 'PES_DATA', 'PES_EMAIL'), $post_pessoa);
                if ($this->crud_model->inserir('PESSOAS', $pessoa) === TRUE) {
                    $mensagem = $this->lang->line("msg_cadastro_sucesso");
                } else {
                    $mensagem = $this->lang->line("msg_cadastro_erro");
                }
            }
        }


        $dados = array(
            'tela' => 'pessoa_cadastro',
            'estados' => $this->crud_model->pega_tudo("ESTADOS")->result(),
            'mensagem' => @$mensagem,
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

    public function editar() {

        $this->form_validation->set_rules('PRO_DESCRICAO', 'DESCRIÇÃO DO PRODUTO', 'required|max_length[100]');

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

    public function imagem() {
        // validar o formulario
        $this->load->library(array('image_lib', 'upload'));

        $img['upload_path'] = APPPATH . 'views/img_produto/';
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
            'mensagem' => @$mensagem,
        );
        $this->load->view('contente', $dados);
    }

    public function excluir() {
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
        );
        $this->load->view('contente', $dados);
    }

    public function busca() {
        $dados = array(
            'tela' => "prod_busca",
        );
        $this->load->view('contente', $dados);
    }

    public function exibir() {
        $dados = array(
            'tela' => "prod_exibir",
        );
        $this->load->view('contente', $dados);
    }

}