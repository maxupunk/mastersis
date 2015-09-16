<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Geral_model extends CI_Model {

    public function ExcluirPedido($id_pedido) {
        $this->db->delete('LISTA_PRODUTOS', array('PEDIDO_ID' => $id_pedido));
        $this->db->delete('PEDIDOS', array('PEDIDO_ID' => $id_pedido));
        return $this->db->trans_status();
    }

    // Soma toda lista de pedidos com o valor de venda
    public function TotalPedido($id_pedido) {
        $this->db->select('format(SUM(LIST_PED_QNT * LIST_PED_PRECO), 2) as total', FALSE);
        $this->db->from('LISTA_PRODUTOS');
        $this->db->where('LISTA_PRODUTOS.PEDIDO_ID', $id_pedido);
        return $this->db->get();
    }

    // Soma toda lista de pedidos com o valor de compra
    public function TotalPedComp($id_pedido) {
        $this->db->select('format(SUM(LIST_PED_QNT * LIST_PED_COMP), 2) as total', FALSE);
        $this->db->from('LISTA_PRODUTOS');
        $this->db->where('LISTA_PRODUTOS.PEDIDO_ID', $id_pedido);
        return $this->db->get();
    }

    //soma toda a lista de produto na ordem de seviço
    public function TotalProdOs($id) {
        $this->db->select('format(SUM(LIST_PED_QNT * LIST_PED_PRECO), 2) as total', FALSE);
        $this->db->from('LISTA_PRODUTOS');
        $this->db->where('LISTA_PRODUTOS.OS_ID', $id);
        return $this->db->get();
    }

    public function ParcelasRestante($id, $selecao) {
        $this->db->select('COUNT(*) AS qnt');
        $this->db->from('DESPESA_RECEITA');
        $this->db->where('DESPESA_RECEITA.DESCRE_ESTATUS', 'ab');
        switch ($selecao) {
            case 'dr':
                $this->db->where('DESPESA_RECEITA.DESREC_ID', $id);
                break;
            case 'pd':
                $this->db->where('DESPESA_RECEITA.PEDIDO_ID', $id);
                break;
            case 'os':
                $this->db->where('DESPESA_RECEITA.OS_ID', $id);
                break;
        }
        return $this->db->get();
    }

    public function ExcluirOs($id) {
        $this->db->delete('LISTA_PRODUTOS', array('OS_ID' => $id));
        $this->db->delete('ORDEM_SERV', array('OS_ID' => $id));
        return $this->db->trans_status();
    }

    public function FechaVenda($id_pedido, $ped_id, $estatus = 4) {

        $this->db->query('UPDATE ESTOQUES, LISTA_PRODUTOS, PEDIDOS
            SET ESTOQUES.ESTOQ_ATUAL = ESTOQUES.ESTOQ_ATUAL - LISTA_PRODUTOS.LIST_PED_QNT,
            PEDIDOS.PEDIDO_ESTATUS = ' . $estatus . ', PEDIDOS.PEDIDO_DATA = NOW(),
            PEDIDOS.PES_ID=' . $ped_id . '
            WHERE PEDIDOS.PEDIDO_ID=' . $id_pedido . ' AND LISTA_PRODUTOS.PEDIDO_ID=' . $id_pedido . '
            AND ESTOQUES.ESTOQ_MIN!=-1
            AND PEDIDOS.PEDIDO_ESTATUS=1
            AND ESTOQUES.ESTOQ_ID = LISTA_PRODUTOS.ESTOQ_ID');

        return $this->db->affected_rows();
    }

    public function AddCompraEstoq($id_pedido, $estatus = 4) {

        $this->db->query('UPDATE ESTOQUES, LISTA_PRODUTOS, PEDIDOS
            SET 
            ESTOQUES.ESTOQ_ATUAL = ESTOQUES.ESTOQ_ATUAL + LISTA_PRODUTOS.LIST_PED_QNT,
            ESTOQUES.ESTOQ_CUSTO = LISTA_PRODUTOS.LIST_PED_COMP,
            ESTOQUES.ESTOQ_PRECO = LISTA_PRODUTOS.LIST_PED_PRECO,
            PEDIDOS.PEDIDO_DATA = NOW(),
            PEDIDOS.PEDIDO_ESTATUS = ' . $estatus . '
            WHERE
            PEDIDOS.PEDIDO_ID=' . $id_pedido . ' AND LISTA_PRODUTOS.PEDIDO_ID=' . $id_pedido . '
            AND PEDIDOS.PEDIDO_ESTATUS<=3 AND ESTOQUES.ESTOQ_ID = LISTA_PRODUTOS.ESTOQ_ID');

        return $this->db->affected_rows();
    }

    public function ReabrirPedido($id_pedido, $estatus = 1) {

        $this->db->query('UPDATE ESTOQUES, LISTA_PRODUTOS, PEDIDOS
            SET ESTOQUES.ESTOQ_ATUAL = ESTOQUES.ESTOQ_ATUAL + LISTA_PRODUTOS.LIST_PED_QNT,
            PEDIDOS.PEDIDO_ESTATUS = ' . $estatus . '
            WHERE PEDIDOS.PEDIDO_ID=' . $id_pedido . ' AND LISTA_PRODUTOS.PEDIDO_ID=' . $id_pedido . '
            AND ESTOQUES.ESTOQ_MIN!=-1 AND PEDIDOS.PEDIDO_ESTATUS>=2');

        return $this->db->affected_rows();
    }

    public function FechaOs($id_pedido) {

        $this->db->query('UPDATE ESTOQUES, LISTA_PRODUTOS, ORDEM_SERV, PEDIDOS
            SET ESTOQUES.ESTOQ_ATUAL = ESTOQUES.ESTOQ_ATUAL - LISTA_PRODUTOS.LIST_PED_QNT,
            ORDEM_SERV.OS_ESTATUS = 4, ORDEM_SERV.OS_DATA_SAI = NOW()
            WHERE ORDEM_SERV.OS_ID=' . $id_pedido . ' AND LISTA_PRODUTOS.OS_ID=' . $id_pedido . '
            AND ESTOQUES.ESTOQ_MIN!=-1 AND ORDEM_SERV.OS_ESTATUS<=3');

        return $this->db->affected_rows();
    }

    public function ReabrirOs($id_pedido, $estatus = 2) {

        $this->db->query('UPDATE ESTOQUES, LISTA_PRODUTOS, ORDEM_SERV, PEDIDOS
            SET ESTOQUES.ESTOQ_ATUAL = ESTOQUES.ESTOQ_ATUAL + LISTA_PRODUTOS.LIST_PED_QNT,
            ORDEM_SERV.OS_ESTATUS = ' . $estatus . '
            WHERE ORDEM_SERV.OS_ID=' . $id_pedido . ' AND LISTA_PRODUTOS.OS_ID=' . $id_pedido . '
            AND ESTOQUES.ESTOQ_MIN!=-1 AND ORDEM_SERV.OS_ESTATUS=4');

        return $this->db->affected_rows();
    }

    public function PedidosCliente($id_cliente, $quant = 0, $inicial = 0, $ordeby = NULL) {
        if ($id_cliente != NULL) {
            if ($ordeby != NULL) {
                $this->db->order_by($ordeby);
            }
            if ($quant > 0) {
                $this->db->limit($quant, $inicial);
            }

            $this->db->where('PEDIDOS.PES_ID', $id_cliente);
            $this->db->where('PEDIDOS.PEDIDO_ESTATUS >=', '2');
            return $this->db->get('PEDIDOS');
        }
    }

    public function PedidosFornecedor($quant = 0, $inicial = 0, $ordeby = NULL) {
        if ($ordeby != NULL)
            $this->db->order_by($ordeby);
        if ($quant > 0)
            $this->db->limit($quant, $inicial);

        $this->db->where('PEDIDOS.PEDIDO_TIPO', 'c');
        $this->db->where('PEDIDOS.PEDIDO_ESTATUS <=', '3');
        return $this->db->get('PEDIDOS');
    }

    public function BaixaPg($desrec_id, $estatus = 'pg') {

        $this->db->query('UPDATE DESPESA_RECEITA SET
            DESPESA_RECEITA.DESCRE_ESTATUS = "' . $estatus . '",
            DESPESA_RECEITA.DESCRE_DATA_PG = NOW()
            WHERE DESPESA_RECEITA.DESREC_ID=' . $desrec_id . ' AND DESPESA_RECEITA.DESCRE_ESTATUS="ab"');

        return $this->db->affected_rows();
    }

}
