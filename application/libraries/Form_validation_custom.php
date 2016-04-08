<?php

class MY_Form_validation extends CI_Form_validation{    
     function __construct($config = array()){
          parent::__construct($config);
     }

    
     /**
     *
     * valid_cpf
     *
     * Verifica CPF é válido
     * @access	public
     * @param	string
     * @return	bool
     */
    function valid_cpf($cpf)
    {
        $CI =& get_instance();
        
        $CI->form_validation->set_message('valid_cpf', 'O %s informado não é válido.');
        $cpf = preg_replace('/[^0-9]/','',$cpf);
        if(strlen($cpf) != 11 || preg_match('/^([0-9])\1+$/', $cpf))
        {
            return false;
        }
        // 9 primeiros digitos do cpf
        $digit = substr($cpf, 0, 9);
        // calculo dos 2 digitos verificadores
        for($j=10; $j <= 11; $j++)
        {
            $sum = 0;
            for($i=0; $i< $j-1; $i++)
            {
                $sum += ($j-$i) * ((int) $digit[$i]);
            }
            $summod11 = $sum % 11;
            $digit[$j-1] = $summod11 < 2 ? 0 : 11 - $summod11;
        }
        
        return $digit[9] == ((int)$cpf[9]) && $digit[10] == ((int)$cpf[10]);
    }

    function cnpj($cnpj) {
	$calcular = 0;
        $calcularDois = 0;
	for ($i = 0, $x = 5; $i <= 11; $i++, $x--) {
		$x = ($x < 2) ? 9 : $x;
		$number = substr($cnpj, $i, 1);
		$calcular += $number * $x;
	}
        
        for ($i = 0, $x = 6; $i <= 12; $i++, $x--) {
		$x = ($x < 2) ? 9 : $x;
		$numberDois = substr($cnpj, $i, 1);
		$calcularDois += $numberDois * $x;
	}

	$digitoUm = (($calcular % 11) < 2) ? 0 : 11 - ($calcular % 11);
	$digitoDois = (($calcularDois % 11) < 2) ? 0 : 11 - ($calcularDois % 11);

	if ($digitoUm <> substr($cnpj, 12, 1) || $digitoDois <> substr($cnpj, 13, 1)) {
		return false;
	} else {
		return true;
        }
    }
        
}