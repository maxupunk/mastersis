<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ferramentas extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('crud_model');
        $this->load->dbutil();
    }

    public function index() {
        $dados = array(
            'tela' => "configuracoes",
        );
        $this->load->view('home', $dados);
    }

    public function logsistema() {
        $this->load->helper('file');

        $local = $this->config->item('log_path');
        $lista = get_filenames($local);

        foreach ($lista as $value) {
            if (get_mime_by_extension($local . '/' . $value) == 'application/x-httpd-php') {

                echo $value . '<pre>';
                $conteudo = highlight_file($local . '/' . $value, TRUE);
                echo $conteudo . '</pre>';
            }
        }
    }

    public function otimizar_db() {
        $result = $this->dbutil->optimize_database();

        if ($result !== FALSE) {
            echo "<pre>";
            print_r($result);
            echo "</pre>";
        }
    }

    public function reparar_tabela($tabela) {
        if ($this->dbutil->repair_table($tabela)) {
            echo 'A tabela ' . $tabela . ' foi reparada com sucesso!';
        }
    }

    public function backup_db() {
        $this->load->helper('download');

        $backup = & $this->dbutil->backup();
        $local = date("Y-m-d-his") . '.gz';

        force_download($local, $backup);
    }

    public function restoque_db() {
        // em contrução
        $backup = read_file('path/to/file.sql');

        $sql_clean = '';
        foreach (explode("\n", $backup) as $line) {

            if (isset($line[0]) && $line[0] != "#") {
                $sql_clean .= $line . "\n";
            }
        }

        //echo $sql_clean;

        foreach (explode(";\n", $sql_clean) as $sql) {
            $sql = trim($sql);
            //echo  $sql.'<br/>============<br/>';
            if ($sql) {
                $this->db->query($sql);
            }
        }
    }

    public function teste() {
        
    }

}