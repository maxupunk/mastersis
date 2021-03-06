<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Crud_model extends CI_Model {

    public function inserir($tabela, $dados = NULL) {
        if ($dados != NULL):
            $this->db->insert($tabela, $dados);
            return $this->db->trans_status();
        endif;
    }

    public function update($tabela, $dados = NULL, $condicao = NULL) {
        if ($dados != NULL && $condicao != NULL):
            $this->db->update($tabela, $dados, $condicao);
            return $this->db->trans_status();
        endif;
    }

    public function excluir($tabela, $condicao = NULL) {
        if ($condicao != NULL):
            $this->db->delete($tabela, $condicao);
            return $this->db->trans_status();
        endif;
    }

    public function pega_tudo($tabela, $quant = 0, $inicial = 0, $ordeby = NULL) {
        if ($ordeby != NULL)
            $this->db->order_by($ordeby);
        if ($quant > 0)
            $this->db->limit($quant, $inicial);

        return $this->db->get($tabela);
    }

    public function pega($tabela, $id = NULL, $ordeby = 0) {
        if ($id != NULL) {
            
            if ($ordeby != 0)
                $this->db->order_by($ordeby, "asc");
            
            return $this->db->get_where($tabela, $id);
        }
    }

    public function buscar($tabela, $busca, $limit = 15) {
        $this->db->or_like($busca);
        $this->db->limit($limit);
        return $this->db->get($tabela);
    }

}