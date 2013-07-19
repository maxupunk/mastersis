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

    public function pega_tudo($quant = 0, $inicial = 0) {
        if ($quant > 0)
            $this->db->limit($quant, $inicial);
        return $this->db->get('CATEGORIA');
    }

    public function buscar($busca) {
        $this->db->like('CATE_NOME', $busca);
        $this->db->or_like('CATE_ID', $busca);
        $this->db->limit(10);
        return $this->db->get('CATEGORIA');
    }

    public function update($dados = NULL, $condicao = NULL) {
        if ($dados != NULL && $condicao != NULL):
            $this->db->update('CATEGORIA', $dados, $condicao);
            $this->session->set_flashdata('edit_cate_ok', 'Alteração feita com sucesso!');
        endif;
    }
    
    public function pega_id($id = NULL) {
        if ($id != NULL):
            return $this->db->get_where('CATEGORIA', array('CATE_ID' => $id), 1);
        else:
            return FALSE;
        endif;
    }


}