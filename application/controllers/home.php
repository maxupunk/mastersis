<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('crud_model');
        $this->load->helper('url');
        $this->auth->check_logged($this->router->class, $this->router->method);
    }

    public function index() {
        $this->output->enable_profiler(TRUE);
        $this->load->view('gadget');
    }

    public function sempermissao() {
        $this->load->view('home_sem_permicoa');
    }

    public function login() {
        //echo md5("admin");
        $this->load->view('home_login');
    }

    function dologin() {
        $usuario = $this->input->post('usuario');
        $senha = md5($this->input->post('senha'));

        if ($usuario == "" || $this->input->post('senha') == "") {
            redirect(base_url() . 'home/login', 'refresh');
            exit();
        }

        if (isset($_POST['lembrar'])) {
            setcookie("usuario", $usuario);
            setcookie("lembrar", "checked");
        }

        $result = $this->crud_model->pega("USUARIO", array('USUARIO_LOGIN' => $usuario, 'USUARIO_SENHA' => $senha, 'USUARIO_ESTATUS' => 'a'))->row();
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
            $data['LOG_ACESS_DATA'] = date("d/m/Y h:i:s");
            $this->db->insert('LOG_ACESSO', $data);

            $this->session->set_userdata($login);
            redirect(base_url() . 'home', 'refresh');
        }
    }

    function logout() {
        $this->session->sess_destroy();
        $this->login();
    }

}