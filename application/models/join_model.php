<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Join_model extends CI_Model {

    public function join($tabela1, $tabela2, $join) {
        $this->db->select('*');
        $this->db->from($tabela1, $tabela2);
        $this->db->join($tabela2, $join);
        return $this->db->get();
    }
    
    public function endereco_completo($id_pessoa){
        $this->db->select('*');
        $this->db->from('PESSOAS', 'ENDERECOS', 'RUA', 'BAIRROS', 'CIDADES', 'ESTADOS');
        $this->db->join('ENDERECOS', 'PESSOAS.END_ID = ENDERECOS.END_ID');
        $this->db->join('RUA', 'ENDERECOS.RUA_ID = RUA.RUA_ID');
        $this->db->join('BAIRROS', 'RUA.BAIRRO_ID = BAIRROS.BAIRRO_ID');
        $this->db->join('CIDADES', 'BAIRROS.CIDA_ID = CIDADES.CIDA_ID');
        $this->db->join('ESTADOS', 'CIDADES.ESTA_ID = ESTADOS.ESTA_ID');
        $this->db->where('PESSOAS.PES_ID = '.$id_pessoa);
        return $this->db->get();
    }
    
    public function produto($id_produto){
        $this->db->select('*');
        $this->db->from('PRODUTOS', 'ESTOQUE', 'MEDIDAS', 'CATEGORIAS');
        $this->db->join('ESTOQUE', 'PRODUTOS.PRO_ID = ESTOQUE.PRO_ID');
        $this->db->where('PRODUTOS.PRO_ID = '.$id_produto);
        return $this->db->get();
    }

}