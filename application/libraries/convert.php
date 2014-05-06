<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Convert {

    function em_real($campo = NULL) {
        if ($campo != NULL){
            $vi = trim($campo);
            $vi = str_replace(",", "", $vi);
            return number_format($vi,2,",",".");
        }
    }
    
    function somar_real($campo1, $campo2){
        $campo1 = str_replace(",", "", $campo1);
        $campo2 = str_replace(",", "", $campo2);
        return $this->em_real($campo1+$campo2);
    }

}

?>
