<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pessoa extends CI_Controller {

    var $mensagem;

    public function __construct() {
        parent::__construct();
        $this->load->model(array('crud_model', 'join_model'));
        $this->load->library(array('form_validation', 'table', 'convert'));
        $this->auth->check_logged($this->router->class, $this->router->method);
    }

    public function index() {
        // validar o formulario

        $this->form_validation->set_rules('PES_NOME', 'NOME DE PESSOA', 'required|is_unique[PESSOAS.PES_NOME]');

        $this->form_validation->set_rules('PES_CPF_CNPJ', 'CPF/CNPJ', 'required|is_unique[PESSOAS.PES_CPF_CNPJ]');
        $this->form_validation->set_message('is_unique', 'Esse %s já esta cadastrado no banco de dados!');
        $this->form_validation->set_rules('PES_EMAIL', 'E-MAIL', 'valid_email');

        if ($this->input->post('PES_TIPO') == 'f') {
            $this->form_validation->set_rules('PES_NOME_PAI', 'NOME DO PAI', 'required');
            $this->form_validation->set_rules('PES_NOME_MAE', 'NOME DA MAE', 'required');
            $this->form_validation->set_rules('PES_NASC_DATA', 'DATA DE NASCIMENTO', 'required');
        }

        $this->form_validation->set_rules('PES_CEL1', 'CELULAR 1', 'required');
        $this->form_validation->set_rules('RUA_ID', 'RUA', 'required');

        $this->form_validation->set_error_delimiters('<span class="label label-danger">', '</span>');

        // se for valido ele chama o inserir dentro do produto_model
        if ($this->form_validation->run() == TRUE) {

            $this->db->trans_begin();
            $endereco = elements(array('END_NUMERO', 'END_REFERENCIA', 'RUA_ID'), $this->input->post());
            if ($this->crud_model->inserir('ENDERECOS', $endereco) === TRUE) {

                $post_pessoa = $this->input->post();

                // pega id do endereço
                $id_ende = array('END_ID' => $this->db->insert_id());

                //pega a data atual
                $data_atual = array('PES_DATA' => date("Y-m-d h:i:s"));

                // converte a data pra inserir no db
                if ($this->input->post('PES_TIPO') == 'f') {
                    $data_nasc = array('PES_NASC_DATA' => $this->convert->DataParaDB($this->input->post('PES_NASC_DATA')));
                    $post_pessoa = array_replace($post_pessoa, $data_nasc);
                }
                // faz a atualização do array com o ID do endereço e a data atual
                $pessoa_array = array_replace($post_pessoa, $id_ende, $data_atual);

                $elemento = elements(array('PES_NOME', 'PES_CPF_CNPJ', 'PES_NOME_PAI', 'PES_NOME_MAE', 'PES_NASC_DATA', 'PES_FONE', 'PES_CEL1', 'PES_CEL2', 'END_ID', 'PES_DATA', 'PES_EMAIL'), $pessoa_array);
                if ($this->crud_model->inserir('PESSOAS', $elemento) === TRUE) {
                    $this->mensagem = "Cadastrado com sucesso!";
                } else {
                    $this->mensagem = "Erro: problema ao gravar no banco de dados";
                }
            }
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $this->mensagem .= 'Ouve algum problema na transação com o banco de dados!';
            } else {
                $this->db->trans_commit();
            }
        }


        $dados = array(
            'tela' => 'pessoa/cadastro',
            'estados' => $this->crud_model->pega_tudo("ESTADOS")->result(),
            'mensagem' => $this->mensagem,
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

                $PessDados = $this->crud_model->pega("PESSOAS", array('PES_ID' => $this->input->post('id_pessoa')))->row();
                $endereco = elements(array('END_NUMERO', 'END_REFERENCIA'), $this->input->post());
                if ($this->crud_model->update("ENDERECOS", $endereco, array('END_ID' => $PessDados->END_ID)) === TRUE) {
                    $this->mensagem .= "Alterações salvas com sucesso!";
                } else {
                    $this->mensagem .= "Erro: Falha ao gravar no banco de dados!";
                }
            } else {
                $this->mensagem = "Erro: Falha ao gravar no banco de dados!";
            }
        endif;

        $dados = array(
            'tela' => "pessoa/editar",
            'mensagem' => $this->mensagem,
            'query' => $this->join_model->EnderecoCompleto($id_pessoa)->row(),
            'estados' => $this->crud_model->pega_tudo("ESTADOS")->result(),
        );
        $this->load->view('contente', $dados);
    }

    public function excluir($id_pessoa) {

        if ($this->input->post('pessoa_id') > 0 AND $this->input->post('pessoa_id') > 0):
            if ($this->crud_model->excluir("PESSOAS", array('PES_ID' => $this->input->post('pessoa_id'))) === TRUE) {
                $this->mensagem .= "Pessoa excluido com sucesso | ";
                if ($this->crud_model->excluir("ENDERECOS", array('END_ID' => $this->input->post('endereco_id'))) === TRUE) {
                    $this->mensagem .= "Endereço excluido com sucesso";
                } else {
                    $this->mensagem .= "Erro: Problema a excluir o endereço. N: " . $this->input->post('endereco_id');
                }
            } else {
                $this->mensagem = "Erro: Problema ao tenta excluir";
            }
        endif;

        $dados = array(
            'tela' => "pessoa/excluir",
            'mensagem' => $this->mensagem,
            'query' => $this->crud_model->pega("PESSOAS", array('PES_ID' => $id_pessoa))->row(),
        );
        $this->load->view('contente', $dados);
    }

    public function busca() {
        $busca = $this->input->get('buscar', TRUE);
        $dados = array(
            'tela' => "pessoa/busca",
            'query' => $this->crud_model->buscar("PESSOAS", array('PES_ID' => $busca, 'PES_NOME' => $busca, 'PES_CPF_CNPJ' => $busca, 'PES_EMAIL' => $busca))->result(),
        );
        $this->load->view('contente', $dados);
    }

    public function pegapessoa() {
        $busca = $this->input->get('buscar', TRUE);

        $this->db->cache_on();
        $rows = $this->crud_model->buscar("PESSOAS", array('PES_ID' => $busca, 'PES_NOME' => $busca, 'PES_CPF_CNPJ' => $busca))->result();

        $json_array = array();
        foreach ($rows as $row) {
            array_push($json_array, array('id' => $row->PES_ID, 'value' => $row->PES_NOME));
        }


        $this->load->view('json', array('query' => $json_array));
    }

}
