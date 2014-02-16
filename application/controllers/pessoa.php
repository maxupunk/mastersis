<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pessoa extends CI_Controller {

    var $mensagem;
    public function __construct() {
        parent::__construct();
        $this->load->model(array('crud_model', 'join_model'));
        $this->load->library(array('form_validation', 'table'));
        $this->auth->check_logged($this->router->class , $this->router->method);
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

                // faz a atualização do array com os dados assima
                $post_pessoa = array_replace($post_pessoa, $id_ende);
                $post_pessoa = array_replace($post_pessoa, $data_nasc);
                $post_pessoa = array_replace($post_pessoa, $data_atual);


                $pessoa = elements(array('PES_NOME', 'PES_CPF_CNPJ', 'PES_NOME_PAI', 'PES_NOME_MAE', 'PES_NASC_DATA', 'PES_FONE', 'PES_CEL1', 'PES_CEL2', 'END_ID', 'PES_DATA', 'PES_EMAIL'), $post_pessoa);
                if ($this->crud_model->inserir('PESSOAS', $pessoa) === TRUE) {
                    $this->mensagem = $this->lang->line("msg_cadastro_sucesso");
                } else {
                    $this->mensagem = $this->lang->line("msg_cadastro_erro");
                }
            }
        }


        $dados = array(
            'tela' => 'pessoa_cadastro',
            'estados' => $this->crud_model->pega_tudo("ESTADOS")->result(),
            'mensagem' => $this->mensagem,
        );
        $this->load->view('contente', $dados);
    }

    public function listar() {

        $this->load->library('pagination');
        $config['base_url'] = base_url('produto/listar');
        $config['total_rows'] = $this->crud_model->pega_tudo("PRODUTOS")->num_rows();
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
            'produtos' => $this->crud_model->pega_tudo("PRODUTOS", $config['per_page'], $inicial)->result(),
            'tela' => 'prod_listar',
            'total' => $this->crud_model->pega_tudo("PRODUTOS")->num_rows(),
            'paginacao' => $this->pagination->create_links(),
        );
        $this->load->view('contente', $dados);
    }

    public function editar($id_pessoa) {

        $this->form_validation->set_rules('PES_NOME', 'NOME DE PESSOA', 'required|strtoupper');

        if ($this->input->post('PES_TIPO') === 'f') {
            $this->form_validation->set_rules('PES_NOME_PAI', 'NOME DO PAI', 'required|strtoupper');
            $this->form_validation->set_rules('PES_NOME_MAE', 'NOME DA MAE', 'required|strtoupper');
            $this->form_validation->set_rules('PES_NASC_DATA', 'DATA DE NASCIMENTO', 'required');
        }
        
        
        // se for valido ele chama o inserir dentro do produto_model
        if ($this->form_validation->run() == TRUE):

            $pessoa = elements(array('PES_NOME', 'PES_CPF_CNPJ', 'PES_NOME_PAI', 'PES_NOME_MAE', 'PES_NASC_DATA', 'PES_FONE', 'PES_CEL1', 'PES_CEL2', 'PES_DATA', 'PES_EMAIL', 'PES_TIPO'), $this->input->post());
            if ($this->crud_model->update("PESSOAS", $pessoa, array('PES_ID' => $this->input->post('id_pessoa'))) === TRUE) {
                $this->mensagem = $this->lang->line("msg_editar_sucesso");

                $endereco = elements(array('END_NUMERO', 'END_REFERENCIA'), $this->input->post());
                if ($this->crud_model->update("ENDERECOS", $endereco, array('END_ID' => $this->input->post('id_pessoa'))) === TRUE) {
                    $this->mensagem .= $this->lang->line("msg_editar_sucesso");
                } else {
                    $this->mensagem .= $this->lang->line("msg_editar_erro");
                }
            } else {
                $this->mensagem = $this->lang->line("msg_editar_erro");
            }
        endif;

        $dados = array(
            'tela' => "pessoa_editar",
            'mensagem' => $this->mensagem,
            'query' => $this->join_model->EnderecoCompleto($id_pessoa)->row(),
            'estados' => $this->crud_model->pega_tudo("ESTADOS")->result(),
        );
        $this->load->view('contente', $dados);
    }

    public function excluir($id_pessoa) {
        
        if ($this->input->post('id_pessoa') > 0):
            if ($this->crud_model->excluir("PESSOAS", array('PES_ID' => $this->input->post('id_pessoa'))) === TRUE) {
                $this->mensagem = $this->lang->line("msg_excluir_sucesso");
            } else {
                $this->mensagem = $this->lang->line("msg_excluir_erro");
            }
        endif;

        $dados = array(
            'tela' => "pessoa_excluir",
            'mensagem' => $this->mensagem,
            'query' => $this->crud_model->pega("PESSOAS", array('PES_ID' => $id_pessoa))->row(),
        );
        $this->load->view('contente', $dados);
    }

    public function busca() {
        $busca = $_GET['buscar'];
        $dados = array(
            'tela' => "pessoa_busca",
            'query' => $this->crud_model->buscar("PESSOAS", array('PES_ID' => $busca, 'PES_NOME' => $busca, 'PES_CPF_CNPJ' => $busca, 'PES_EMAIL' => $busca))->result(),
        );
        $this->load->view('contente', $dados);
    }

    public function pegapessoa() {
        $busca = $_GET['buscar'];
        
        $rows = $this->crud_model->buscar("PESSOAS", array('PES_ID' => $busca, 'PES_NOME' => $busca, 'PES_CPF_CNPJ' => $busca))->result();

        $json_array = array();
        foreach ($rows as $row)
            array_push($json_array, array('id' => $row->PES_ID, 'value' => $row->PES_NOME));

        $dados = array(
            'query' => $json_array,
        );
        
        $this->load->view('json', $dados);
    }

}