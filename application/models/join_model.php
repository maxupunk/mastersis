<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Join_model extends CI_Model {

    public function EnderecoCompleto($id_pessoa) {
        $this->db->select('*');
        $this->db->from('PESSOAS', 'ENDERECOS', 'RUAS', 'BAIRROS', 'CIDADES', 'ESTADOS');
        $this->db->join('ENDERECOS', 'PESSOAS.END_ID = ENDERECOS.END_ID');
        $this->db->join('RUAS', 'ENDERECOS.RUA_ID = RUAS.RUA_ID');
        $this->db->join('BAIRROS', 'RUAS.BAIRRO_ID = BAIRROS.BAIRRO_ID');
        $this->db->join('CIDADES', 'BAIRROS.CIDA_ID = CIDADES.CIDA_ID');
        $this->db->join('ESTADOS', 'CIDADES.ESTA_ID = ESTADOS.ESTA_ID');
        $this->db->where('PESSOAS.PES_ID = ' . $id_pessoa);
        return $this->db->get();
    }

    public function Endereco($busca) {
        $this->db->select('*');
        $this->db->from('RUAS', 'BAIRROS', 'CIDADES', 'ESTADOS');
        $this->db->join('BAIRROS', 'RUAS.BAIRRO_ID = BAIRROS.BAIRRO_ID');
        $this->db->join('CIDADES', 'BAIRROS.CIDA_ID = CIDADES.CIDA_ID');
        $this->db->join('ESTADOS', 'CIDADES.ESTA_ID = ESTADOS.ESTA_ID');
        $this->db->or_like('RUAS.RUA_NOME', $busca, 'both');
        return $this->db->get();
    }

    public function ProdutoEstoque($id_produto) {
        $this->db->select('*');
        $this->db->from('PRODUTOS', 'ESTOQUES');
        $this->db->join('ESTOQUES', 'PRODUTOS.PRO_ID = ESTOQUES.PRO_ID');
        $this->db->where('PRODUTOS.PRO_ID = ', $id_produto);
        return $this->db->get();
    }

    public function ProdutoBusca($busca, $regra = "v") {
        $this->db->select('PRODUTOS.PRO_ID, PRODUTOS.PRO_DESCRICAO, PRODUTOS.PRO_TIPO, ESTOQUES.ESTOQ_ATUAL, ESTOQUES.ESTOQ_PRECO');
        $this->db->from('PRODUTOS', 'ESTOQUES');
        $this->db->join('ESTOQUES', 'PRODUTOS.PRO_ID = ESTOQUES.PRO_ID');
        $this->db->or_like('PRODUTOS.PRO_DESCRICAO', $busca);
        $this->db->or_like('PRODUTOS.PRO_CARAC_TEC', $busca);
        if ($regra == "v" or $regra == "os") {
            $this->db->where('PRODUTOS.PRO_ESTATUS', "a");
        }

        return $this->db->get();
    }

    public function PedidoBusca($busca) {
        $this->db->select('*');
        $this->db->from('PEDIDOS', 'PESSOAS', 'USUARIOS');
        $this->db->join('PESSOAS', 'PEDIDOS.PES_ID = PESSOAS.PES_ID');
        $this->db->join('USUARIOS', 'PEDIDOS.USUARIO_ID = USUARIOS.USUARIO_ID');
        $this->db->or_like('PESSOAS.PES_CPF_CNPJ', $busca);
        $this->db->or_like('PESSOAS.PES_NOME', $busca);
        return $this->db->get();
    }

    // lista os produtos em venda
    public function ListaPedido($id_pedido) {
        $this->db->select('*');
        $this->db->from('PRODUTOS', 'ESTOQUES', 'LISTA_PRODUTOS', 'MEDIDAS');
        $this->db->join('ESTOQUES', 'PRODUTOS.PRO_ID = ESTOQUES.PRO_ID');
        $this->db->join('LISTA_PRODUTOS', 'ESTOQUES.ESTOQ_ID = LISTA_PRODUTOS.ESTOQ_ID');
        $this->db->join('MEDIDAS', 'PRODUTOS.MEDI_ID = MEDIDAS.MEDI_ID');
        $this->db->where('LISTA_PRODUTOS.PEDIDO_ID = ', $id_pedido);
        return $this->db->get();
    }

    public function PedidoProduto($id_lista) {
        $this->db->select('*');
        $this->db->from('PRODUTOS', 'ESTOQUES', 'LISTA_PRODUTOS', 'MEDIDAS');
        $this->db->join('ESTOQUES', 'PRODUTOS.PRO_ID = ESTOQUES.PRO_ID');
        $this->db->join('LISTA_PRODUTOS', 'ESTOQUES.ESTOQ_ID = LISTA_PRODUTOS.ESTOQ_ID');
        $this->db->join('MEDIDAS', 'PRODUTOS.MEDI_ID = MEDIDAS.MEDI_ID');
        $this->db->where('LISTA_PRODUTOS.LIST_PED_ID = ', $id_lista);
        return $this->db->get();
    }

    // lista os produtos em venda
    public function ListaProdOs($id_os) {
        $this->db->select('*');
        $this->db->from('PRODUTOS', 'ESTOQUES', 'LISTA_PRODUTOS', 'MEDIDAS');
        $this->db->join('ESTOQUES', 'PRODUTOS.PRO_ID = ESTOQUES.PRO_ID');
        $this->db->join('LISTA_PRODUTOS', 'ESTOQUES.ESTOQ_ID = LISTA_PRODUTOS.ESTOQ_ID');
        $this->db->join('MEDIDAS', 'PRODUTOS.MEDI_ID = MEDIDAS.MEDI_ID');
        $this->db->where('LISTA_PRODUTOS.OS_ID = ', $id_os);
        return $this->db->get();
    }

    public function OsStatus($status, $ordeby = NULL, $limit = NULL) {
        $this->db->select('*');
        $this->db->from('PESSOAS', 'ORDEM_SERV');
        $this->db->join('ORDEM_SERV', 'PESSOAS.PES_ID = ORDEM_SERV.PES_ID');

        if ($ordeby != NULL) {
            $this->db->order_by($ordeby);
        }

        if ($limit != NULL) {
            $this->db->limit($limit);
        }

        $this->db->where('ORDEM_SERV.OS_ESTATUS =' . $status);
        return $this->db->get();
    }

    public function OsDados($id) {
        $this->db->select('*');
        $this->db->from('PESSOAS', 'ORDEM_SERV');
        $this->db->join('ORDEM_SERV', 'PESSOAS.PES_ID = ORDEM_SERV.PES_ID');
        $this->db->where('ORDEM_SERV.OS_ID =' . $id);
        return $this->db->get();
    }

    public function ReceitaDespesa($natureza, $ordeby = NULL, $limit = NULL) {
        $this->db->select('*');
        $this->db->from('DESPESA_RECEITA', 'PESSOAS');
        $this->db->join('PESSOAS', 'DESPESA_RECEITA.PES_ID = PESSOAS.PES_ID', 'left');

        if ($ordeby != NULL) {
            $this->db->order_by($ordeby);
        }

        if ($limit != NULL) {
            $this->db->limit($limit);
        }

        $this->db->where('DESPESA_RECEITA.DESREC_NATUREZA', $natureza);
        $this->db->where('DESPESA_RECEITA.DESCRE_ESTATUS', 'ab');
        return $this->db->get();
    }

    public function RecDesTudo($id) {
        $this->db->select('*');
        $this->db->from('DESPESA_RECEITA', 'PESSOAS', 'PEDIDOS', 'ORDEM_SERV');
        $this->db->join('PESSOAS', 'DESPESA_RECEITA.PES_ID = PESSOAS.PES_ID', 'left');
        $this->db->join('PEDIDOS', 'DESPESA_RECEITA.PEDIDO_ID = PEDIDOS.PEDIDO_ID', 'left');
        $this->db->join('ORDEM_SERV', 'DESPESA_RECEITA.OS_ID = ORDEM_SERV.OS_ID', 'left');
        $this->db->where('DESPESA_RECEITA.DESREC_ID', $id);
        return $this->db->get();
    }

    public function RecDesBusca($busca, $estatus = 'ab', $quant = 0, $natureza = 1) {
        $this->db->select('*');
        $this->db->from('DESPESA_RECEITA', 'PESSOAS', 'PEDIDOS', 'ORDEM_SERV');
        $this->db->join('PESSOAS', 'DESPESA_RECEITA.PES_ID = PESSOAS.PES_ID', 'left');
        $this->db->join('PEDIDOS', 'DESPESA_RECEITA.PEDIDO_ID = PEDIDOS.PEDIDO_ID', 'left');
        $this->db->join('ORDEM_SERV', 'DESPESA_RECEITA.OS_ID = ORDEM_SERV.OS_ID', 'left');
        $this->db->like('PESSOAS.PES_NOME', $busca);
        $this->db->where('DESPESA_RECEITA.DESCRE_ESTATUS', $estatus);
        $this->db->where('DESPESA_RECEITA.DESREC_NATUREZA', $natureza);
        $this->db->order_by("DESPESA_RECEITA.DESREC_VECIMENTO", "asc");
        if ($quant !== 0) {
            $this->db->limit($quant);
        }
        return $this->db->get();
    }

    public function Historico($id, $selecao) {
        $this->db->select('USUARIO_LOGIN, HISTORICO_CMD, HISTORICO_DATA');
        $this->db->from('HISTORICO', 'USUARIOS');
        $this->db->join('USUARIOS', 'HISTORICO.USUARIO_ID = USUARIOS.USUARIO_ID');
        switch ($selecao) {
            case 'dr':
                $this->db->where('HISTORICO.DESREC_ID', $id);
                break;
            case 'pd':
                $this->db->where('HISTORICO.PEDIDO_ID', $id);
                break;
            case 'os':
                $this->db->where('HISTORICO.OS_ID', $id);
                break;
            case 'et':
                $this->db->where('HISTORICO.ESTOQ_ID', $id);
                break;
        }
        return $this->db->get();
    }

}
