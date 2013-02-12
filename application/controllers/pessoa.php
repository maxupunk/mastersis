<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pessoa extends CI_Controller {

	public function index()
	{
            $dados = array(
              'titulo' => "Paginas Index Pessoa.",
              'tela' => "",
            );
		$this->load->view('home',$dados);
	}
        
        public function cadastro()
	{
            $dados = array(
              'titulo' => "Pagina de Cadastro de pessoa.",
              'tela' => "",
            );
		$this->load->view('home',$dados);
	}
        
        public function atualisar($dados, $condicao)
	{
            $dados = array(
              'titulo' => "Pessoa Atualiza",
              'tela' => "",
            );
		$this->load->view('home',$dados);
	}
        
        public function apagar($id=NULL)
	{
            $dados = array(
              'titulo' => "Pessoa apagar",
              'tela' => "",
            );
		$this->load->view('home',$dados);
	}
        
        public function lista_todas()
	{
            $dados = array(
              'titulo' => "Pessoa Lista",
              'tela' => "",
            );
		$this->load->view('home',$dados);
	}
        
        public function busca($busca=NULL, $condicao)
	{
            $dados = array(
              'titulo' => "Pessoa busca",
              'tela' => "",
            );
		$this->load->view('home',$dados);
	}
        
}