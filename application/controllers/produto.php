<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Produto extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('produto_model');
	}

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
            
            $this->form_validation->set_rules('PRO_DESCRICAO','DESCRIÇÃO DO PRODUTO','required|max_length[45]|strtoupper|is_unique[PRODUTOS.PRO_DESCRICAO]');
            $this->form_validation->set_message('is_unique','Essa %s já esta cadastrado no banco de dados!');
            $this->form_validation->set_rules('PRO_CARAC_TEC','CARACTERISTICA TECNICA','required');
			$this->form_validation->set_rules('PRO_VAL_CUST','PREÇO DE CUSTO','required');
			$this->form_validation->set_rules('PRO_VAL_VEND','PREÇO DE VENDA','required');
			
            if ( $this->form_validation->run() == TRUE ):
                $dados = elements(array('PRO_DESCRICAO','PRO_CARAC_TEC','PRO_VAL_CUST','PRO_VAL_VEND'),$this->input->post());
				$dados = 
				$this->produto_model->inserir($dados);
            endif;
            
            $dados = array(
              'titulo' => "Pagina de Cadastro.",
              'tela' => "prod_cadastro",
            );
		$this->load->view('home',$dados);
	}
        
	public function lista_todas()
	{
            $dados = array(
              'titulo' => "Produto lista todas",
              'tela' => "prod_lista",
              'produtos' => $this->produto_model->pega_tudo()->result(),
            );
		$this->load->view('home',$dados);
	}
		
		
        public function editar($dados, $condicao)
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
                
        public function busca($busca=NULL, $condicao)
	{
            $dados = array(
              'titulo' => "Produto busca",
              'tela' => "",
            );
		$this->load->view('home',$dados);
	}
        
}