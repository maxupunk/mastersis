<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ferramentas extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('crud_model');
        //$this->auth->check_logged($this->router->class, $this->router->method);
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

        $this->db->cache_delete_all();

        $result = $this->dbutil->optimize_database();

        if ($result !== FALSE) {
            echo "<pre>";
            print_r($result);
            echo "</pre>";
        }
    }

    public function reparar_tabela($tabela = null) {
        echo "- Limpando o cache geral<br>";
        $this->db->cache_delete_all();
        if ($tabela == null) {
            $tabelas = $this->db->list_tables();

            foreach ($tabelas as $tabela) {
                if ($this->dbutil->repair_table($tabela)) {
                    echo '- A tabela ' . $tabela . ' foi reparada com sucesso!<br>';
                } else {
                    echo '- A tabela ' . $tabela . ' não pode ser reparada';
                }
            }
        } else {
            if ($this->dbutil->repair_table($tabela)) {
                echo 'A tabela ' . $tabela . ' foi reparada com sucesso!';
            } else {
                echo 'A tabela ' . $tabela . ' não pode ser reparada';
            }
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

    public function Cod_barra() {
        $this->load->library(array('barcode'));
        $valor = "12345678998098409840948049804984";
        $this->barcode->criabarra($valor);
    }

    public function ini() {
        $this->load->library(array('ini'));

        //$ini = $this->ini->set('config.ini');
        // Add new setting to section third_section
        $this->ini->data['principal']['app_name'] = "MasterSis3";

        // Udate settings
        //$ini->data['first_section']['animal'] = 'COW';
        // Save settings to file
        $this->ini->write('config.ini');

        echo "<pre>";
        print_r($this->ini->data);
        print_r($this->ini->data['principal']);
        print_r($this->ini->data['principal']['app_name']);
        echo "</pre>";
    }

}