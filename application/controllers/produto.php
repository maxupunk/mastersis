<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Produto extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('produto_model');
	}
<<<<<<< HEAD
		
//
//Função Cadastrar
//	    
    public function cadastrar()
=======

	public function index()
	{
            $dados = array(
              'titulo' => "Paginas Index do Produto.",
              'tela' => "",
            );
		$this->load->view('home',$dados);
	}
        
    public function cadastro()
>>>>>>> parent of dd5c165... adicionado o faundation e ajax.
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
            
<<<<<<< HEAD
		$this->load->view('telas/produto/cadastro');
=======
            $dados = array(
              'titulo' => "Pagina de Cadastro.",
              'tela' => "prod_cadastro",
            );
		$this->load->view('home',$dados);
>>>>>>> parent of dd5c165... adicionado o faundation e ajax.
	}
        
	public function lista_todas()
	{
            $dados = array(
              'titulo' => "Produto lista todas",
              'tela' => "prod_lista",
              'produtos' => $this->produto_model->pega_tudo()->result(),
            );
<<<<<<< HEAD
		$this->load->view('telas/produto/lista',$dados);
=======
		$this->load->view('home',$dados);
>>>>>>> parent of dd5c165... adicionado o faundation e ajax.
	}
		
		
        public function editar($dados, $condicao)
	{
<<<<<<< HEAD
        // validar o formulario
            $this->form_validation->set_rules('PRO_DESCRICAO','DESCRIÇÃO DO PRODUTO','required|max_length[45]|strtoupper');
            $this->form_validation->set_rules('PRO_CARAC_TEC','CARACTERISTICA TECNICA','required');
			$this->form_validation->set_rules('PRO_VAL_VEND','PREÇO DE VENDA','required');
			
			// se for valido ele chama o inserir dentro do produto_model
            if ( $this->form_validation->run() == TRUE ):
                $dados = elements(array('PRO_DESCRICAO','PRO_CARAC_TEC','PRO_VAL_CUST','PRO_VAL_VEND'),$this->input->post());
				$this->produto_model->update($dados,array('PRO_ID' => $this->input->post('id_produto')));
            endif;

		$this->load->view('telas/produto/editar');
=======
            $dados = array(
              'titulo' => "Produto Atualiza",
              'tela' => "",
            );
		$this->load->view('home',$dados);
>>>>>>> parent of dd5c165... adicionado o faundation e ajax.
	}
        
        public function apagar($id=NULL)
	{
<<<<<<< HEAD
		if($this->input->post('id_produto')>0):
			$this->produto_model->excluir(array('PRO_ID' => $this->input->post('id_produto')));
		endif;
			
		$this->load->view('telas/produto/excluir');
	}

//
//Função Apagar
//	    
    public function buscar()
	{		
		$this->load->view('telas/produto/buscar');
=======
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
>>>>>>> parent of dd5c165... adicionado o faundation e ajax.
	}
		
		
}