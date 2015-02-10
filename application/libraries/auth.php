<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Auth {

    private $CI;

    public function __construct() {
        $this->CI = & get_instance();
    }

    function check_logged($classe, $metodo) {
        /*
         * Criando uma instância do CodeIgniter para poder acessar
         * banco de dados, sessionns, models, etc...
         */
        
        inicio:
        /**
         * Buscando a classe e metodo da tabela sys_metodos
         */
        $array = array('METOD_CLASS' => $classe, 'METOD_METODO' => $metodo);
        $this->CI->db->where($array);
        $query = $this->CI->db->get('METODOS');
        $result = $query->result();


        // Se este metodo ainda não existir na tabela sera cadastrado
        if (count($result) == 0) {
            $data = array(
                'METOD_CLASS' => $classe,
                'METOD_METODO' => $metodo,
                'METOD_APELIDO' => $classe . '/' . $metodo,
                'METOD_PRIVADO' => 0
            );
            $this->CI->db->insert('METODOS', $data);
            // volta para o inicio da funçao
            goto inicio;
            
        } else {
            //Se ja existir tras as informacoes de publico ou privado
            if ($result[0]->METOD_PRIVADO == 0) {
                // Escapa da validacao e mostra o metodo.
                return false;
            } else {
                // Se for privado, verifica o login
                $nome = $this->CI->session->userdata('USUARIO_APELIDO');
                $logged_in = $this->CI->session->userdata('LOGGET_IN');
                $id_usuario = $this->CI->session->userdata('USUARIO_ID');

                $id_sys_metodos = $result[0]->METOD_ID;

                // Se o usuario estiver logado vai verificar se tem permissao na tabela.
                if ($nome && $logged_in && $id_usuario) {

                    $array = array('METOD_ID' => $id_sys_metodos, 'USUARIO_ID' => $id_usuario);
                    $this->CI->db->where($array);
                    $query2 = $this->CI->db->get('PERMISSOES');
                    $result2 = $query2->result();

                    // Se não vier nenhum resultado da consulta, manda para página de
                    // usuario sem permissão.
                    if (count($result2) == 0) {
                        show_error("VOCÊ NÃO TEM PERMICÃO DE ACESSAR ESSA PAGINA!", 401, "AREA RESTRITA");
                    } else {
                        return true;
                    }
                    // Se não estiver logado, sera redirecionado para o login.
                } else {
                    redirect(base_url('home/login'), 'refresh');
                }
            }
        }
    }

    /**
     * Método auxiliar para autenticar entradas em menu.
     * Não faz parte do plugin como um todo.
     */
    function check_menu($classe, $metodo) {
        $this->CI = & get_instance();
        $sql = "SELECT SQL_CACHE
                count(PERMISSOES.PREM_ID) as found
                FROM
                PERMISSOES
                INNER JOIN METODOS
                ON METODOS.METOD_ID = PERMISSOES.METOD_ID
                WHERE USUARIO_ID = '" . $this->CI->session->userdata('id_usuario') . "'
                AND METOD_CLASS = '" . $classe . "'
                AND METOD_METODO = '" . $metodo . "'";
        $query = $this->CI->db->query($sql);
        $result = $query->result();
        return $result[0]->found;
    }

}
