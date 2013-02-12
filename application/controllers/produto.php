<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Produto extends CI_Controller {

	public function index()
	{
            $dados = array(
              'titulo' => "Paginas Index do Produto.",
              'tela' => "",
            );
		$this->load->view('home',$dados);
	}
        
        public function cadastro()
	{
            
            $this->form_validation->set_rules('PRO_DESCRICAO','DESCRIÇÃO','required|max_length[45]|is_unique[PRODUTOS.PRO_DESCRICAO]');
            $this->form_validation->set_rules('PRO_CARAC_TEC','CARACTERISTICA TECNICA','required');
            
            if ( $this->form_validation->run() == TRUE ):
                echo "teste";
            endif;
            
            $dados = array(
              'titulo' => "Pagina de Cadastro.",
              'tela' => "cad_produto",
            );
		$this->load->view('home',$dados);
	}
        
        public function atualisar($dados, $condicao)
	{
            $dados = array(
              'titulo' => "Produto Atualiza",
              'tela' => "",
            );
		$this->load->view('home',$dados);
	}
        
        public function apagar($id=NULL)
	{
            $dados = array(
              'titulo' => "Produto apagar",
              'tela' => "",
            );
		$this->load->view('home',$dados);
	}
        
        public function lista_todas()
	{
            $dados = array(
              'titulo' => "Produto lista todas",
              'tela' => "",
            );
		$this->load->view('home',$dados);
	}
        
        public function busca($busca=NULL, $condicao)
	{
            $dados = array(
              'titulo' => "Produto busca",
              'tela' => "",
            );
		$this->load->view('home',$dados);
	}
        
}