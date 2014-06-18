<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Geral_model extends CI_Model {

    public function ExcluirPedido($id_pedido) {
        $this->db->delete('LISTA_PRODUTO', array('PEDIDO_ID' => $id_pedido));
        $this->db->delete('PEDIDO', array('PEDIDO_ID' => $id_pedido));
        return $this->db->trans_status();
    }

    // Soma toda lista de pedidos
    public function TotalPedido($id_pedido) {
        $this->db->select('format(SUM(LIST_PED_QNT * LIST_PED_PRECO), 2) as total', FALSE);
        $this->db->from('LISTA_PRODUTO');
        $this->db->where('LISTA_PRODUTO.PEDIDO_ID', $id_pedido);
        return $this->db->get();
    }

    // soma toda a lista de produto na Ordem de Seviço
    public function TotalProdOs($id) {
        $this->db->select('format(SUM(LIST_PED_QNT * LIST_PED_PRECO), 2) as total', FALSE);
        $this->db->from('LISTA_PRODUTO');
        $this->db->where('LISTA_PRODUTO.OS_ID', $id);
        return $this->db->get();
    }

    public function TotalServico($id) {
        $this->db->select('format(SUM(LIST_SRV_QNT * LIST_SRV_PRECO), 2) as total', FALSE);
        $this->db->from('LISTA_SERVICO');
        $this->db->where('LISTA_SERVICO.OS_ID', $id);
        return $this->db->get();
    }

    public function ExcluirOs($id) {
        $this->db->delete('LISTA_PRODUTO_OS', array('OS_ID' => $id));
        $this->db->delete('LISTA_SERVICO_OS', array('OS_ID' => $id));
        $this->db->delete('ORDEM_SERV', array('OS_ID' => $id));
        return $this->db->trans_status();
    }

    public function FechaPedido($id_pedido) {

        $this->db->query('UPDATE ESTOQUE, LISTA_PRODUTO, PEDIDO
            SET ESTOQUE.ESTOQ_ATUAL = ESTOQUE.ESTOQ_ATUAL - LISTA_PRODUTO.LIST_PED_QNT,
            PEDIDO.PEDIDO_ESTATUS = 2
            WHERE LISTA_PRODUTO.PEDIDO_ID=' . $id_pedido . ' AND PEDIDO.PEDIDO_ID=' . $id_pedido . ' AND PEDIDO.PEDIDO_ESTATUS=1');

        return $this->db->affected_rows();
    }

    public function PedidosCliente($id_cliente, $quant = 0, $inicial = 0, $ordeby = NULL) {
        if ($id_cliente != NULL) {
            if ($ordeby != NULL)
                $this->db->order_by($ordeby);
            if ($quant > 0)
                $this->db->limit($quant, $inicial);
            
            $this->db->where('PEDIDO.PES_ID', $id_cliente);
            $this->db->where('PEDIDO.PEDIDO_ESTATUS >=', '2');
            return $this->db->get('PEDIDO');
        }
    }

}