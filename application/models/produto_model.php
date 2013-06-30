<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Produto_model extends CI_Model {
<<<<<<< HEAD

//
//Inserir dados
//	
=======
		
>>>>>>> parent of dd5c165... adicionado o faundation e ajax.
	public function inserir($dados=NULL)
	{
            if ($dados!=NULL):
				$this->db->insert('PRODUTOS',$dados);
				$this->session->set_flashdata('cad_prod_ok','Cadastro efetuado com sucesso!');
				redirect('produto/cadastro');
			endif;
	}
	
	public function pega_tudo()
	{
			return $this->db->get('PRODUTOS');
	}
	
<<<<<<< HEAD
	public function pega_id($id=NULL)
	{
		if($id!=NULL):
			return $this->db->get_where('PRODUTOS', array('PRO_ID' => $id), 1);
		else:
			return FALSE;
		endif;
	}


	public function buscar($busca=NULL)
	{
		if($busca!=NULL):
			
			$this->db->like('PRO_DESCRICAO', $busca);
			
			return $this->db->get('PRODUTOS');
	
		else:
			return FALSE;
		endif;
	}

=======
>>>>>>> parent of dd5c165... adicionado o faundation e ajax.
}