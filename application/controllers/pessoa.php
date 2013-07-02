<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pessoa extends CI_Controller {

        
<<<<<<< HEAD
	public function __construct()
=======
        public function cadastro()
>>>>>>> parent of dd5c165... adicionado o faundation e ajax.
	{
		parent::__construct();
		$this->load->model('pessoa_model');
	}
		
//
//Função Cadastrar
//	    
    public function cadastrar()
	{
            // validar o formulario
            $this->form_validation->set_rules('PRO_DESCRICAO','DESCRIÇÃO DO PRODUTO','required|max_length[45]|strtoupper|is_unique[PRODUTOS.PRO_DESCRICAO]');
            $this->form_validation->set_message('is_unique','Essa %s já esta cadastrado no banco de dados!');
            $this->form_validation->set_rules('PRO_CARAC_TEC','CARACTERISTICA TECNICA','required');
			$this->form_validation->set_rules('PRO_VAL_CUST','PREÇO DE CUSTO','required');
			$this->form_validation->set_rules('PRO_VAL_VEND','PREÇO DE VENDA','required');
			
			// se for valido ele chama o inserir dentro do produto_model
            if ( $this->form_validation->run() == TRUE ):
                $dados = elements(array('PRO_DESCRICAO','PRO_CARAC_TEC','PRO_VAL_CUST','PRO_VAL_VEND'),$this->input->post());
				$this->produto_model->inserir($dados);
            endif;
            
		$this->load->view('telas/produto/cadastro');
	}
        
	public function lista_todas()
	{
            $dados = array(
              'produtos' => $this->produto_model->pega_tudo()->result(),
            );
		$this->load->view('telas/produto/lista',$dados);
	}
		
//
//Função Editar
//	
    public function editar()
	{
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
	}
    	
//
//Função Apagar
//	    
    public function excluir($id=NULL)
	{
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
	}

        
}