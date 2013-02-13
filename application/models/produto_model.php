<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Produto_model extends CI_Model {
		
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
	
}