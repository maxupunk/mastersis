<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Categoria_model extends CI_Model {

//
//Inserir dados
//	
    public function inserir($dados = NULL) {
        if ($dados != NULL):
            $this->db->insert('CATEGORIA', $dados);
            $this->session->set_flashdata('cad_cate_ok', 'Cadastro efetuado com sucesso!');
            redirect(current_url());
        endif;
    }

}