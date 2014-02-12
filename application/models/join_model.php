<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Join_model extends CI_Model {

    public function EnderecoCompleto($id_pessoa) {
        $this->db->select('*');
        $this->db->from('PESSOAS', 'ENDERECOS', 'RUA', 'BAIRROS', 'CIDADES', 'ESTADOS');
        $this->db->join('ENDERECOS', 'PESSOAS.END_ID = ENDERECOS.END_ID');
        $this->db->join('RUA', 'ENDERECOS.RUA_ID = RUA.RUA_ID');
        $this->db->join('BAIRROS', 'RUA.BAIRRO_ID = BAIRROS.BAIRRO_ID');
        $this->db->join('CIDADES', 'BAIRROS.CIDA_ID = CIDADES.CIDA_ID');
        $this->db->join('ESTADOS', 'CIDADES.ESTA_ID = ESTADOS.ESTA_ID');
        $this->db->where('PESSOAS.PES_ID = ' . $id_pessoa);
        return $this->db->get();
    }

    public function Endereco($busca) {
        $this->db->select('*');
        $this->db->from('RUA', 'BAIRROS', 'CIDADES', 'ESTADOS');
        $this->db->join('BAIRROS', 'RUA.BAIRRO_ID = BAIRROS.BAIRRO_ID');
        $this->db->join('CIDADES', 'BAIRROS.CIDA_ID = CIDADES.CIDA_ID');
        $this->db->join('ESTADOS', 'CIDADES.ESTA_ID = ESTADOS.ESTA_ID');
        $this->db->or_like('RUA.RUA_NOME', $busca, 'both');
        return $this->db->get();
    }

    public function ProdutoEstoque($id_produto) {
        $this->db->select('*');
        $this->db->from('PRODUTOS', 'ESTOQUE');
        $this->db->join('ESTOQUE', 'PRODUTOS.PRO_ID = ESTOQUE.PRO_ID');
        $this->db->where('PRODUTOS.PRO_ID = ', $id_produto);
        return $this->db->get();
    }

    public function ProdutoBusca($busca) {
        $this->db->select('*');
        $this->db->from('PRODUTOS', 'ESTOQUE');
        $this->db->join('ESTOQUE', 'PRODUTOS.PRO_ID = ESTOQUE.PRO_ID');
        $this->db->where('PRODUTOS.PRO_ESTATUS', 'a');
        $this->db->where('ESTOQUE.ESTOQ_ATUAL >=', 1);
        $this->db->or_like('PRODUTOS.PRO_DESCRICAO', $busca);
        $this->db->or_like('PRODUTOS.PRO_CARAC_TEC', $busca);
        return $this->db->get();
    }

    public function PedidoBusca($busca) {
        $this->db->select('*');
        $this->db->from('PEDIDO', 'PESSOAS', 'USUARIO');
        $this->db->join('PESSOAS', 'PEDIDO.PES_ID = PESSOAS.PES_ID');
        $this->db->join('USUARIO', 'PEDIDO.USUARIO_ID = USUARIO.USUARIO_ID');
        $this->db->or_like('PESSOAS.PES_CPF_CNPJ', $busca);
        $this->db->or_like('PESSOAS.PES_NOME', $busca);
        return $this->db->get();
    }
    // lista os produtos em venda
    public function ListaPedido($id_pedido) {
        $this->db->select('*');
        $this->db->from('PRODUTOS', 'ESTOQUE', 'LISTA_PEDIDO', 'MEDIDAS');
        $this->db->join('ESTOQUE', 'PRODUTOS.PRO_ID = ESTOQUE.PRO_ID');
        $this->db->join('LISTA_PEDIDO', 'ESTOQUE.ESTOQ_ID = LISTA_PEDIDO.ESTOQ_ID');
        $this->db->join('MEDIDAS', 'PRODUTOS.MEDI_ID = MEDIDAS.MEDI_ID');
        $this->db->where('LISTA_PEDIDO.PEDIDO_ID = ', $id_pedido);
        return $this->db->get();
    }
    
    // Lista de produtos na ordem de serviço
    public function ListaProduto($id_pedido) {
        $this->db->select('*');
        $this->db->from('PRODUTOS', 'ESTOQUE', 'LISTA_PRODUTO_OS', 'MEDIDAS');
        $this->db->join('ESTOQUE', 'PRODUTOS.PRO_ID = ESTOQUE.PRO_ID');
        $this->db->join('LISTA_PRODUTO_OS', 'ESTOQUE.ESTOQ_ID = LISTA_PRODUTO_OS.ESTOQ_ID');
        $this->db->join('MEDIDAS', 'PRODUTOS.MEDI_ID = MEDIDAS.MEDI_ID');
        $this->db->where('LISTA_PRODUTO_OS.OS_ID = ', $id_pedido);
        return $this->db->get();
    }
    // Lista os serviços
    public function ListaServico($id_pedido) {
        $this->db->select('*');
        $this->db->from('SERVICOS', 'LISTA_SERVICO_OS');
        $this->db->join('LISTA_SERVICO_OS', 'SERVICOS.SERV_ID = LISTA_SERVICO_OS.SERV_ID');
        $this->db->where('LISTA_SERVICO_OS.OS_ID = ', $id_pedido);
        return $this->db->get();
    }

    public function OsStatus($status) {
        $this->db->select('*');
        $this->db->from('PESSOAS', 'ORDEM_SERV');
        $this->db->join('ORDEM_SERV', 'PESSOAS.PES_ID = ORDEM_SERV.PES_ID');
        $this->db->order_by("OS_DATA_ENT", "desc");
        $this->db->where('ORDEM_SERV.OS_ESTATUS =' . $status);
        return $this->db->get();
    }
    
    public function OsDetalhes($id) {
        $this->db->select('*');
        $this->db->from('PESSOAS', 'ORDEM_SERV');
        $this->db->join('ORDEM_SERV', 'PESSOAS.PES_ID = ORDEM_SERV.PES_ID');
        $this->db->where('ORDEM_SERV.OS_ID =' . $id);
        return $this->db->get();
    }
    
}