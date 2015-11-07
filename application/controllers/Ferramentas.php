<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ferramentas extends CI_Controller {

    var $mensagem;

    public function __construct() {
        parent::__construct();
        $this->load->model('crud_model');
//$this->auth->check_logged($this->router->class, $this->router->method);
        $this->load->dbutil();
    }

    public function index() {
        $dados = array(
            'tela' => "ferramentas/ferramentas",
        );
        $this->load->view('home', $dados);
    }

    public function LogSistema() {
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

    public function OtimizarDB() {

        $this->db->cache_delete_all();

        $result = $this->dbutil->optimize_database();

        if ($result !== FALSE) {
            echo "<pre>";
            print_r($result);
            echo "</pre>";
        }
    }

    public function RepararTabela($tabela = null) {
        echo "- Limpando o cache geral<br>";
        $this->db->cache_delete_all();
        if ($tabela == null) {
            $tabelas = $this->db->list_tables();

            foreach ($tabelas as $tabela) {
                if ($this->dbutil->repair_table($tabela)) {
                    echo '- A tabela ' . $tabela . ' foi reparada com sucesso!<br>';
                } else {
                    echo '- A tabela ' . $tabela . ' não pode ser reparada <br>';
                }
            }
        } else {
            if ($this->dbutil->repair_table($tabela)) {
                echo 'A tabela ' . $tabela . ' foi reparada com sucesso! <br>';
            } else {
                echo 'A tabela ' . $tabela . ' não pode ser reparada <br>';
            }
        }
    }

    public function BackupSistema() {
        $this->load->library('zip');
        $this->zip->read_dir('.');
        $this->zip->download(date("Y-m-d-h_i_s") . '.zip');
    }

    public function BackupDB() {
        $this->load->helper('download');

        $this->load->dbutil();

        $prefs = array(
            'format' => 'txt', // gzip, zip, txt
            'add_drop' => TRUE, // Whether to add DROP TABLE statements to backup file
            'add_insert' => TRUE, // Whether to add INSERT data to backup file
            'newline' => "\n"                         // Newline character used in backup file
        );

        $backup = $this->dbutil->backup($prefs);

        $NomeArq = date("Y-m-d-h_i_s") . '.sql';

        force_download($NomeArq, $backup);
    }

    public function RestareDB() {

        $config['upload_path'] = sys_get_temp_dir();
        $config['allowed_types'] = '*';
        $config['overwrite'] = TRUE;

        $this->load->library('upload', $config);

        if ($this->upload->do_upload() == TRUE) {

            $data = $this->upload->data();

            $this->RetouraSQL($data['file_path'] . $data['file_name']);
        }

        $dados = array(
            'tela' => "ferramentas/restauraDB",
            'upload' => $this->upload->display_errors(),
            'mensagem' => $this->mensagem
        );
        $this->load->view('contente', $dados);
    }

    public function InstalacaoDB() {
        //$this->load->dbforge();
        //if (!$this->dbforge->drop_database($this->db->database)) {
        //    echo 'Erro ao apagar o DB!';
        //}
        // Cria o banco de dados
        if (!$this->dbforge->create_database($this->db->database)) {
            echo 'Erro ao crear o DB';
        }

        if (!$this->RetouraSQL("sql/estrutura.sql")) {
            $this->mensagem .= "sql/estrutura.sql recuperada!<br>";
        }
        if (!$this->RetouraSQL("sql/EstadosCidadesBrasil.sql")) {
            $this->mensagem .= "sql/EstadosCidadesBrasil.sql recuperada<br>";
        }
        if (!$this->RetouraSQL("sql/administrador.sql")) {
            $this->mensagem .= "sql/administrador.sql recuperada<br>";
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

    private function DownloadLimit($src_file, $filename, $rate = 20) {
        // set the download rate limit (=> 20 kb/s)

        if (file_exists($src_file) && is_file($src_file)) {

            // send headers
            header('Cache-control: private');
            header('Content-Type: application/octet-stream');
            header('Content-Length: ' . filesize($src_file));
            header('Content-Disposition: filename=' . $filename);

            // flush content
            flush();

            // open file stream
            $file = fopen($src_file, "r");
            while (!feof($file)) {
                // send the current file part to the browser
                print fread($file, round($rate * 1024));
                // flush the content to the browser
                flush();
                // sleep one second
                sleep(1);
            }
            // close file stream
            fclose($file);
        } else {
            die('Error: O orquivo ' . $src_file . ' não existe!');
        }
    }

    private function RetouraSQL($arquivo) {
        $templine = null;
        $lines = file($arquivo);
        foreach ($lines as $line) {
// Skip it if it's a comment
            if (substr($line, 0, 2) == '--' || $line == '') {
                continue;
            }

            $templine .= $line;
            if (substr(trim($line), -1, 1) == ';') {
                !$this->db->query($templine);
                $templine = null;
            }
        }
    }

}
