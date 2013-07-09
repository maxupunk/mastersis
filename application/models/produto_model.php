<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Produto_model extends CI_Model {

//
//Inserir dados
//	
    public function inserir($dados = NULL) {
        if ($dados != NULL):
            $this->db->insert('PRODUTOS', $dados);
            $this->session->set_flashdata('cad_prod_ok', 'Cadastro efetuado com sucesso!');
            redirect(current_url());
        endif;
    }

//
//Update
//
    public function update($dados = NULL, $condicao = NULL) {
        if ($dados != NULL && $condicao != NULL):
            $this->db->update('PRODUTOS', $dados, $condicao);
            $this->session->set_flashdata('edit_prod_ok', 'Cadastro atualizado com sucesso!');
            redirect(current_url());
        endif;
    }

    public function excluir($condicao = NULL) {
        if ($condicao != NULL):
            $this->db->delete('PRODUTOS', $condicao);
            $this->session->set_flashdata('exclui_prod_ok', 'Cadastro excluido com sucesso!');
            redirect(current_url());
        endif;
    }

    public function pega_tudo($quant = 0, $inicial = 0) {
        if ($quant > 0)
            $this->db->limit($quant, $inicial);
        return $this->db->get('PRODUTOS');
    }

    public function pega_id($id = NULL) {
        if ($id != NULL):
            return $this->db->get_where('PRODUTOS', array('PRO_ID' => $id), 1);
        else:
            return FALSE;
        endif;
    }

    public function buscar($busca){        
            $this->db->like('PRO_DESCRICAO', $busca);
            $this->db->or_like('PRO_ID', $busca);
            $this->db->limit(10);
            return $this->db->get('PRODUTOS');

    }

}