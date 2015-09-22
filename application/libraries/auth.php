<?php

//
// Control de permisão e altenticação baseado em um codigo fonte liberado na internet
// totalmente alterado e melhorado para um maior desempenho e segurança
// ainda em TESTE
// By Maxuel Alcântara Aguiar
//
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Auth {

    private $CI;
    //sim privado for TRUE todos os novos metodos vão ser gravado como privado
    private $privado = false;

    public function __construct() {
        $this->CI = & get_instance();
    }

    function check_logged($classe, $metodo) {

        //verifica se já existe e traz as informacoes de publico ou privado
        if ($this->check_tabela($classe, $metodo)) {
            // Se for privado, verifica o login
            $nome = $this->CI->session->userdata('USUARIO_APELIDO');
            $logged_in = $this->CI->session->userdata('LOGGET_IN');
            $id_usuario = $this->CI->session->userdata('USUARIO_ID');

            // Se o usuario estiver logado vai verificar se tem permissao na tabela.
            if ($nome && $logged_in && $id_usuario) {
                // verifica se o usuario tem permisão, se não manda mensagem de erro.
                if ($this->check_permissao($classe, $metodo)) {
                    return true;
                } else {
                    show_error("VOCÊ NÃO TEM PERMICÃO DE ACESSAR ESSA PAGINA!", 401, "AREA RESTRITA");
                }
            } else {
                // Se não estiver logado, sera redirecionado para o login.
                redirect(base_url('home/login'));
            }
        } else {
            // Escapa da validacao e mostra o metodo.
            return false;
        }
    }

    /**
     * Método auxiliar para autenticar entradas em menu.
     * Não faz parte do plugin como um todo.
     */
    function check_permissao($classe, $metodo) {
        $sql = "SELECT SQL_CACHE
                count(PERMISSOES.PERM_ID) as found
                FROM
                PERMISSOES
                INNER JOIN METODOS
                ON METODOS.METOD_ID = PERMISSOES.METOD_ID
                WHERE USUARIO_ID = '" . $this->CI->session->userdata('USUARIO_ID') . "'
                AND METOD_CLASS = '" . $classe . "'
                AND METOD_METODO = '" . $metodo . "'";
        $result = $this->CI->db->query($sql)->row();
        return $result->found;
    }

    // Verifica se já existe a MEDOTO e CLASS na tabela
    function check_tabela($classe, $metodo) {
        
        $this->CI->db->where(array('METOD_CLASS' => $classe, 'METOD_METODO' => $metodo));
        $result = $this->CI->db->get('METODOS')->row();
        // Se este metodo ainda não existir na tabela será cadastrado
        if (count($result) == 0) {
            $data['METOD_CLASS'] = $classe;
            $data['METOD_METODO'] = $metodo;
            $data['METOD_PRIVADO'] = $this->privado;
            $this->CI->db->insert('METODOS', $data);
            return $data['METOD_PRIVADO'];
        } else {
            return $result->METOD_PRIVADO;
        }
    }

    // Log no DB
    function log($metod_id) {
        $data['USUARIO_ID'] = $this->CI->session->userdata('USUARIO_ID');
        $data['LOG_ACESS_IP'] = getenv("REMOTE_ADDR");
        $data['LOG_ACESS_DATA'] = date("Y-m-d h:i:s");
        $data['METOD_ID'] = $metod_id;
        $this->CI->db->insert('LOG_ACESSOS', $data);
    }

}
