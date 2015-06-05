<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Produto extends CI_Controller {

    var $mensagem;

    public function __construct() {
        parent::__construct();
        $this->load->model(array('crud_model', 'join_model'));
        $this->load->library(array('form_validation', 'table', 'convert'));
        $this->auth->check_logged($this->router->class, $this->router->method);
    }

    public function index() {
        // validar o formulario
        $this->form_validation->set_rules('PRO_DESCRICAO', 'DESCRIÇÃO DO PRODUTO', 'required|max_length[100]|is_unique[PRODUTOS.PRO_DESCRICAO]');
        $this->form_validation->set_message('is_unique', 'Essa %s já esta cadastrado no banco de dados!');
        $this->form_validation->set_rules('CATE_ID', 'CATEGORIA', 'required');
        $this->form_validation->set_rules('MEDI_ID', 'MEDIDA', 'required');

        $this->form_validation->set_error_delimiters('<span class="label label-danger">', '</span>');


        // se for valido ele chama o inserir dentro do produto_model
        if ($this->form_validation->run() == TRUE) {

            $dados = elements(array('PRO_DESCRICAO', 'PRO_CARAC_TEC', 'CATE_ID', 'MEDI_ID', 'PRO_PESO', 'PRO_TIPO', 'PRO_ESTATUS'), $this->input->post());
            $this->db->trans_begin();
            if ($this->crud_model->inserir('PRODUTOS', $dados) === TRUE) {
                $produto_id = $this->db->insert_id();
                $estoq_min = ($dados['PRO_TIPO'] == "s") ? -1 : 1;
                $estoq_atual = ($dados['PRO_TIPO'] == "s") ? -1 : NULL;
                $estoque = array(
                    'PRO_ID' => $produto_id,
                    'ESTOQ_PRECO' => "0",
                    'ESTOQ_MIN' => $estoq_min,
                    'ESTOQ_ATUAL' => $estoq_atual,
                    'ESTOQ_ENTRA' => date("Y-m-d h:i:s"));
                if ($this->crud_model->inserir('ESTOQUES', $estoque) === TRUE) {
                    $this->db->trans_commit();
                    $this->mensagem = "Produto/Serviço cadastrado com sucesso! <br>- Para permitir adiciona em venda e/ou serivço adicione o valor de venda do mesmo em Compras!";
                } else {
                    $this->db->trans_rollback();
                    $this->mensagem = "Erro: Problema no banco de dados";
                }
            } else {
                $this->mensagem = "Erro ao gravar no banco de dados! <br>- porfavor tente novamente mais tarde.";
            }
        }
        $dados = array(
            'tela' => 'produto/cadastro',
            'categorias' => $this->crud_model->pega_tudo("CATEGORIAS")->result(),
            'medidas' => $this->crud_model->pega_tudo("MEDIDAS")->result(),
            'mensagem' => $this->mensagem,
        );
        $this->load->view('contente', $dados);
    }

    public function Editar($id_produto) {

        $this->form_validation->set_rules('PRO_DESCRICAO', 'DESCRIÇÃO DO PRODUTO', 'required|max_length[100]');

        $this->form_validation->set_error_delimiters('<p class="text-error">', '</p>');


        // se for valido ele faz o update
        if ($this->form_validation->run() == TRUE) {
            // inicia a trasação
            $this->db->trans_begin();

            $dados = elements(array('PRO_DESCRICAO', 'PRO_CARAC_TEC', 'CATE_ID', 'MEDI_ID', 'PRO_PESO', 'PRO_TIPO', 'PRO_ESTATUS'), $this->input->post());
            $this->crud_model->update("PRODUTOS", $dados, array('PRO_ID' => $this->input->post('id_produto')));
            if ($dados['PRO_TIPO'] == "s") {
                $estoque = array('ESTOQ_MIN' => -1, 'ESTOQ_ATUAL' => 1);
            } else {
                $estoque = array('ESTOQ_MIN' => NULL);
            }
            $this->crud_model->update("ESTOQUES", $estoque, array('PRO_ID' => $this->input->post('id_produto')));
            $this->db->trans_commit();
            $this->mensagem = "Atualização feita com sucesso";

            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();
                $this->mensagem = "Atualização feita com sucesso";
            } else {
                $this->db->trans_rollback();
                $this->mensagem = "Problema ao atualizar";
            }
        }

        $dados = array(
            'tela' => "produto/editar",
            'mensagem' => $this->mensagem,
            'categorias' => $this->crud_model->pega_tudo("CATEGORIAS")->result(),
            'medidas' => $this->crud_model->pega_tudo("MEDIDAS")->result(),
            'query' => $this->crud_model->pega("PRODUTOS", array('PRO_ID' => $id_produto))->row(),
        );
        $this->load->view('contente', $dados);
    }

    public function Imagem($id_produto) {

        //$id_produto = $this->uri->segment(3);
        $this->form_validation->set_rules('id_produto', '', 'required');

        $this->load->library(array('image_lib', 'upload'));
        if ($this->form_validation->run() == TRUE) {

            $img['upload_path'] = 'assets/arquivos/produto/';
            $img['allowed_types'] = 'jpg';
            $img['file_ext_tolower'] = TRUE;
            $img['max_size'] = '2048';
            $img['file_name'] = $this->input->post('id_produto') . "-img";
            $img['max_filename_increment'] = '100';
            $img['overwrite'] = false;

            $this->upload->initialize($img);

            // se for valido ele chama o inserir dentro do produto_model
            if ($this->upload->do_upload() == TRUE) {

                $data = $this->upload->data();

                $thumb['image_library'] = "gd";
                $thumb['source_image'] = $data['file_path'] . $data['file_name'];
                $thumb['create_thumb'] = FALSE;
                $thumb['maintain_ratio'] = TRUE;
                $thumb['master_dim'] = "auto";
                $thumb['quality'] = "80%";
                $thumb['width'] = "120";
                $thumb['height'] = "120";
                $this->image_lib->initialize($thumb);
                $this->image_lib->resize();

                $ProdDados = $this->crud_model->pega("PRODUTOS", array('PRO_ID' => $this->input->post('id_produto')))->row();
                if ($ProdDados->PRO_IMG == NULL) {
                    if ($this->crud_model->update("PRODUTOS", array('PRO_IMG' => $data['file_name']), array('PRO_ID' => $this->input->post('id_produto'))) === TRUE) {
                        $this->mensagem = "Imagem alterada com sucesso";
                    } else {
                        $this->mensagem = "Erro: problema ao altera a imagem.";
                    }
                }

                $imgDados = array('PROIMG_NOME' => $data['file_name'], 'PRO_ID' => $this->input->post('id_produto'));
                if ($this->crud_model->inserir('PRODUTO_IMG', $imgDados)) {
                    $this->mensagem = "Imagem adicionada com sucesso!";
                } else {
                    $this->mensagem = "Erro: problema ao asiciona a imagem.";
                }
            }
        }

        $dados = array(
            'tela' => "produto/imagem",
            'id_produto' => $id_produto,
            'upload' => $this->upload->display_errors(),
            'thumb' => $this->image_lib->display_errors(),
            'imagens' => $this->crud_model->pega("PRODUTO_IMG", array('PRO_ID' => $id_produto))->result(),
            'mensagem' => $this->mensagem,
        );
        $this->load->view('contente', $dados);
    }

    public function ImagemCapa($id_pro, $img) {
        if ($this->crud_model->update("PRODUTOS", array('PRO_IMG' => $img), array('PRO_ID' => $id_pro)) === TRUE) {
            $this->mensagem = "Imagem padrão alterada com sucesso";
        } else {
            $this->mensagem = "Erro: problema ao altera a imagem padrão.";
        }
        $dados = array('query' => array('msg' => $this->mensagem));
        $this->load->view('json', $dados);
    }

    public function ImagemExcluir($id) {
        if ($this->input->post('id') > 0):
            $imagem = $this->crud_model->pega("PRODUTO_IMG", array('PROIMG_ID' => $id))->row();
            $produto = $this->crud_model->pega("PRODUTOS", array('PRO_IMG' => $imagem->PROIMG_NOME))->row();
            if ($produto) {
                $this->crud_model->update('PRODUTOS', array('PRO_IMG' => NULL), array('PRO_ID' => $produto->PRO_ID));
            }
            if ($this->crud_model->excluir("PRODUTO_IMG", array('PROIMG_ID' => $id)) === TRUE) {
                unlink("assets/arquivos/produto/" . $imagem->PROIMG_NOME);
                $this->mensagem = "Imagem removida com sucesso!";
            } else {
                $this->mensagem = "Erro: problema no banco de dados";
            }
        endif;

        $dados = array(
            'tela' => "produto/excluir_img",
            'mensagem' => $this->mensagem,
            'query' => $this->crud_model->pega("PRODUTO_IMG", array('PROIMG_ID' => $id))->row(),
        );
        $this->load->view('contente', $dados);
    }

    public function Excluir($id_produto) {
        if ($this->input->post('id_produto') > 0):
            if ($this->crud_model->excluir("PRODUTOS", array('PRO_ID' => $this->input->post('id_produto'))) === TRUE) {
                $this->mensagem = "Excluido com sucesso";
            } else {
                $this->mensagem = "Erro: problemas no banco de dados";
            }
        endif;

        $dados = array(
            'tela' => "produto/excluir",
            'mensagem' => $this->mensagem,
            'query' => $this->crud_model->pega("PRODUTOS", array('PRO_ID' => $id_produto))->row(),
        );
        $this->load->view('contente', $dados);
    }

    public function Busca() {
        $busca = $this->input->get('buscar', TRUE);
        $dados = array(
            'tela' => "produto/busca",
            'query' => $this->crud_model->buscar("PRODUTOS", array('PRO_ID' => $busca, 'PRO_DESCRICAO' => $busca, 'PRO_CARAC_TEC' => $busca))->result(),
        );
        $this->load->view('contente', $dados);
    }

    public function Exibir() {

        $id_produto = $this->uri->segment(3);

        if ($id_produto == NULL):
            $this->mensagem = 'ERRO NA URL! Tente novamente';
        endif;

        $dados = array(
            'tela' => "produto/exibir",
            'query' => $this->crud_model->pega("PRODUTOS", array('PRO_ID' => $id_produto))->row(),
            'mensagem' => $this->mensagem,
        );
        $this->load->view('contente', $dados);
    }

    public function Avaria() {
        $dados = array(
            'tela' => "prod_avaria",
        );
        $this->load->view('contente', $dados);
    }

    public function PegaProduto() {

        $busca = $this->input->get('buscar', TRUE);

        if ($this->uri->segment(3) == FALSE) {
            $rows = $this->join_model->ProdutoBusca($busca)->result();
        } else {
            $rows = $this->join_model->ProdutoBusca($busca, $this->uri->segment(3))->result();
        }

        $json_array = array();
        foreach ($rows as $row) {
            $estoq_atual = ($row->PRO_TIPO == "s") ? "Serviço" : $row->ESTOQ_ATUAL;
            array_push($json_array, array('id' => $row->PRO_ID, 'value' => $row->PRO_DESCRICAO . ' | ' . $estoq_atual . ' | ' . $this->convert->em_real($row->ESTOQ_PRECO)));
        }

        $dados = array('query' => $json_array);
        $this->load->view('json', $dados);
    }

}
