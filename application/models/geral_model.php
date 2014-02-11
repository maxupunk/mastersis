<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Geral_model extends CI_Model {

    public function ExcluirPedido($id_pedido) {
        $this->db->delete('LISTA_PEDIDO', array('PEDIDO_ID' => $id_pedido));
        $this->db->delete('PEDIDO', array('PEDIDO_ID' => $id_pedido));
        return $this->db->trans_status();
    }

    public function TotalPedido($id_pedido) {
        $this->db->select('format(SUM(LIST_PED_QNT * LIST_PED_PRECO), 2) as total', FALSE);
        $this->db->from('LISTA_PEDIDO');
        $this->db->where('LISTA_PEDIDO.PEDIDO_ID = ', $id_pedido);
        return $this->db->get();
    }

    public function FechaPedido($id_pedido) {

        $this->db->query('UPDATE ESTOQUE, LISTA_PEDIDO, PEDIDO
            SET ESTOQUE.ESTOQ_ATUAL = ESTOQUE.ESTOQ_ATUAL - LISTA_PEDIDO.LIST_PED_QNT,
            PEDIDO.PEDIDO_ESTATUS = 2
            WHERE LISTA_PEDIDO.PEDIDO_ID=' . $id_pedido . ' AND PEDIDO.PEDIDO_ID=' . $id_pedido . ' AND PEDIDO.PEDIDO_ESTATUS=1');

        return $this->db->affected_rows();
    }

    public function PedidosCliente($id_cliente, $quant = 0, $inicial = 0, $ordeby = NULL) {
        if ($id_cliente != NULL) {
            if ($ordeby != NULL)
                $this->db->order_by($ordeby, "asc");
            if ($quant > 0)
                $this->db->limit($quant, $inicial);

            return $this->db->get_where('PEDIDO', array('PES_ID' => $id_cliente));
        }
    }

}