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
            
		$dados = array(
              'produtos' => $this->produto_model->pega_tudo()->result(),
              'tela' => 'prod_cadastro',
            );	
		$this->load->view('home',$dados);
	}
        
	public function lista_todas()
	{
			$this->load->library('pagination');
			$config['base_url'] = base_url('produto/lista_todas');
			$config['total_rows'] = $this->produto_model->pega_tudo()->num_rows();
			$config['per_page'] = 2;
			$quant = $config['per_page'];
			
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li class="disabled"><a>';
			$config['cur_tag_close'] = '</a></li>';
			$config['next_link'] = '&gt;';
			$config['next_tag_open'] = '<li>';
			$config['next_tag_close'] = '</li>';
			$config['prev_link'] = '&lt;';
			$config['prev_tag_open'] = '<li>';
			$config['prev_tag_close'] = '</li>';
			
			$this->uri->segment(3) != '' ? $inicial = $this->uri->segment(3) : $inicial = 0;
			
			$this->pagination->initialize($config);
			
            $dados = array(
              'produtos' => $this->produto_model->pega_tudo($quant,$inicial)->result(),
              'tela' => 'prod_lista',
              'paginacao' => $this->pagination->create_links(),
            );
		$this->load->view('home',$dados);
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

		$this->load->view('telas/prod_editar');
	}
    	
//
//Função Apagar
//	    
    public function excluir($id=NULL)
	{
		if($this->input->post('id_produto')>0):
			$this->produto_model->excluir(array('PRO_ID' => $this->input->post('id_produto')));
		endif;
			
		$this->load->view('telas/prod_excluir');
	}
		
//
//Função Buscar
//	            
    public function busca($busca=NULL, $condicao)
	{
            $dados = array(
              'titulo' => "Produto busca",
              'tela' => "",
            );
		$this->load->view('home',$dados);
	}
        
}