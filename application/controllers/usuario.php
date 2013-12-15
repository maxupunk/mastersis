<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Usuario extends CI_Controller {

    var $mensagem;

    public function __construct() {
        parent::__construct();
        $this->load->model('crud_model');
        $this->load->library(array('form_validation', 'table'));
        $this->auth->check_logged($this->router->class, $this->router->method);
    }

    public function index() {

        $dados = array(
            'tela' => "usuario",
        );
        $this->load->view('home', $dados);
    }

    public function cadastrar() {
        // validar o formulario
        $this->form_validation->set_rules('PES_ID', 'NOME DA PESSOA', 'required|is_unique[USUARIO.PES_ID]');
        $this->form_validation->set_rules('USUARIO_APELIDO', 'APELIDO', 'required');
        $this->form_validation->set_rules('USUARIO_LOGIN', 'LOGIN', 'required|is_unique[USUARIO.USUARIO_LOGIN]');
        $this->form_validation->set_rules('USUARIO_SENHA', 'SENHA', 'required');
        $this->form_validation->set_rules('USUARIO_SENHA_RE', 'REPITA A SENHA', 'required|matches[USUARIO_SENHA]');
        $this->form_validation->set_rules('CARG_ID', 'CARGO', 'required');
        $this->form_validation->set_message('is_unique', 'Já existe um usuario com esse %s cadastrado!');

        $this->form_validation->set_error_delimiters('<span class="label label-danger">', '</span>');


        // se for valido ele chama o inserir dentro do produto_model
        if ($this->form_validation->run() == TRUE):

            $formulario = $this->input->post();
            $senha = array('USUARIO_SENHA' => hash("sha512", $formulario['USUARIO_SENHA']));
            $novo_form = array_replace($formulario, $senha);

            $dados = elements(array('PES_ID', 'USUARIO_APELIDO', 'USUARIO_LOGIN', 'USUARIO_SENHA', 'CARG_ID'), $novo_form);
            if ($this->crud_model->inserir('USUARIO', $dados) === TRUE) {
                $this->mensagem = $this->lang->line("msg_cadastro_sucesso");
            } else {
                $this->mensagem = $this->lang->line("msg_cadastro_erro");
            }

        endif;
        $dados = array(
            'tela' => 'usuario_cadastro',
            'cargos' => $this->crud_model->pega_tudo("CARGOS")->result(),
            'mensagem' => $this->mensagem,
        );
        $this->load->view('contente', $dados);
    }

    public function busca() {
        $busca = $_GET['buscar'];
        $dados = array(
            'tela' => "usuario_busca",
            'query' => $this->crud_model->buscar("USUARIO", array('USUARIO_APELIDO' => $busca, 'USUARIO_LOGIN' => $busca))->result(),
        );
        $this->load->view('contente', $dados);
    }

    public function editar($id_usuario) {

        $this->form_validation->set_rules('USUARIO_APELIDO', 'APELIDO', 'required');
        $this->form_validation->set_rules('CARG_ID', 'CARGO', 'required');


        $this->form_validation->set_error_delimiters('<span class="label label-danger">', '</span>');


        // se for valido ele chama o inserir dentro do produto_model
        if ($this->form_validation->run() == TRUE):
            $dados = elements(array('USUARIO_APELIDO', 'CARG_ID', 'USUARIO_ESTATUS'), $this->input->post());
            if ($this->crud_model->update("USUARIO", $dados, array('USUARIO_ID' => $this->input->post('usuario_id'))) === TRUE) {
                $this->mensagem = $this->lang->line("msg_editar_sucesso");
            } else {
                $this->mensagem = $this->lang->line("msg_editar_erro");
            }
        endif;

        $dados = array(
            'tela' => 'usuario_editar',
            'id_usuario' => $id_usuario,
            'usuario' => $this->crud_model->pega("USUARIO", array('USUARIO_ID' => $id_usuario))->row(),
            'cargos' => $this->crud_model->pega_tudo("CARGOS")->result(),
            'mensagem' => $this->mensagem,
        );
        $this->load->view('contente', $dados);
    }

    public function listar() {

        $this->load->library('pagination');
        $config['base_url'] = base_url('usuario/listar');
        $config['total_rows'] = $this->crud_model->pega_tudo("USUARIO")->num_rows();
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
            'usuarios' => $this->crud_model->pega_tudo("USUARIO", $quant, $inicial)->result(),
            'tela' => 'usuario_listar',
            'total' => $this->crud_model->pega_tudo("USUARIO")->num_rows(),
            'paginacao' => $this->pagination->create_links(),
        );
        $this->load->view('contente', $dados);
    }

    public function pegausuario() {
        $busca = $_GET['buscar'];

        $rows = $this->crud_model->buscar("USUARIO", array('USUARIO_APELIDO' => $busca, 'USUARIO_LOGIN' => $busca))->result();

        $json_array = array();
        foreach ($rows as $row)
            array_push($json_array, array('id' => $row->USUARIO_ID, 'value' => $row->USUARIO_LOGIN));

        $dados = array(
            'query' => $json_array,
        );

        $this->load->view('json', $dados);
    }

}