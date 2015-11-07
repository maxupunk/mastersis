<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('crud_model');
        $this->load->helper('url');
    }

    public function index() {
        $this->output->enable_profiler(TRUE);
        $this->load->view('widget');
    }

    public function login() {
        //echo md5("admin");
        $this->load->view('home_login');
    }

    public function dologin() {
        $usuario = $this->input->post('usuario');
        $senha = hash("sha512", $this->input->post('senha'));

        //echo hash("sha512", $this->input->post('senha'));

        if ($usuario == "" || $this->input->post('senha') == "") {
            redirect(base_url('home/login'), 'refresh');
            exit();
        }

        if (isset($_POST['lembrar'])) {
            setcookie("usuario", $usuario);
            //setcookie("lembrar", "checked");
        }

        $result = $this->crud_model->pega("USUARIOS", array('USUARIO_LOGIN' => $usuario, 'USUARIO_SENHA' => $senha, 'USUARIO_ESTATUS' => 'a'))->row();
        if (count($result) < 1) {
            $dados = array('mensagem' => "Login e/ou senha invalido ou usuario desativo no sistema!");
            $this->load->view('home_login', $dados);
        } else {
            $login = array(
                'USUARIO_ID' => $result->USUARIO_ID,
                'USUARIO_LOGIN' => $result->USUARIO_LOGIN,
                'USUARIO_APELIDO' => $result->USUARIO_APELIDO,
                'PES_ID' => $result->PES_ID,
                'DATA' => date("d/m/Y h:i:s"),
                'LOGGET_IN' => TRUE,
            );


            $data['USUARIO_ID'] = $result->USUARIO_ID;
            $data['LOG_ACESS_IP'] = getenv("REMOTE_ADDR");
            $data['LOG_ACESS_DATA'] = date("Y-m-d h:i:s");
            $this->db->insert('LOG_ACESSOS', $data);

            $this->session->set_userdata($login);
            redirect('home');
        }
    }

    public function logout() {
        $this->session->sess_destroy();
        $this->login();
    }

    public function download() {
        // local file that should be send to the client
        $local_file = 'teste.zip';

// filename that the user gets as default
        $download_file = 'your-download-name.zip';

// set the download rate limit (=> 20,5 kb/s)
        $download_rate = 20.5;

        if (file_exists($local_file) && is_file($local_file)) {

            // send headers
            header('Cache-control: private');
            header('Content-Type: application/octet-stream');
            header('Content-Length: ' . filesize($local_file));
            header('Content-Disposition: filename=' . $download_file);

            // flush content
            flush();

            // open file stream
            $file = fopen($local_file, "r");

            while (!feof($file)) {

                // send the current file part to the browser
                print fread($file, round($download_rate * 1024));

                // flush the content to the browser
                flush();

                // sleep one second
                sleep(1);
            }

            // close file stream
            fclose($file);
        } else {
            die('Error: The file ' . $local_file . ' does not exist!');
        }
    }

}
