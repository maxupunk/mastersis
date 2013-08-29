<?php

/*
 * *****************************************************************************
 * 	Rotina para gerar c�digos de barra padr�o 2of5 .
 * 	Luciano Lima Silva 09/01/2003
 * 	netdinamica@netdinamica.com.br
 * 	Site: www.netdinamica.com.br
 *
 * Classe por: Glauber Portella Ornelas de Melo (22/11/2004)
 * 
 * Portado para o CI por Maxuel Aguiar
 * *****************************************************************************
 * modo de usar:
 * 
 *       $this->load->library(array('barcode'));
 *       $valor = "12345678998098409840948049804984";
 *       $this->barcode->criabarra($valor);
 */

class barcode {

    private $ci;

    public function __construct() {
        $this->ci = &get_instance();
        $base_url = base_url()."assets/img";
    }

    var $valor;     // n�mero do c�digo de barra (valor do c�digo 2of5)
    var $barra_preta;  // arquivo de imagem para barra preta
    var $barra_branca; // arquivo de imagem para barra branca
    // constantes para o padr�o 2 of 5
    var $fino = 1;
    var $largo = 3;
    var $altura = 50;
    var $html; // privado

    function criabarra($val, $bpreta = "p.gif", $bbranca = "b.gif", $gerar = true) {
        $this->setValor($val);
        $this->setBarraPreta(base_url()."assets/img/".$bpreta);
        $this->setBarraBranca(base_url()."assets/img/".$bbranca);

        if ($gerar) {
            $this->drawBarCode();
        }
    }

    function setValor($val) {
        $this->valor = $val;
    }

    function getValor() {
        return $this->valor;
    }

    function setBarraPreta($val) {
        $this->barra_preta = $val;
    }

    function getBarraPreta() {
        return $this->barra_preta;
    }

    function setBarraBranca($val) {
        $this->barra_branca = $val;
    }

    function getBarraBranca() {
        return $this->barra_branca;
    }

    function getHtml() {
        return $this->html;
    }

    function parseBarCode($draw = false) {
        $barcodes[0] = "00110";
        $barcodes[1] = "10001";
        $barcodes[2] = "01001";
        $barcodes[3] = "11000";
        $barcodes[4] = "00101";
        $barcodes[5] = "10100";
        $barcodes[6] = "01100";
        $barcodes[7] = "00011";
        $barcodes[8] = "10010";
        $barcodes[9] = "01010";

        for ($f1 = 9; $f1 >= 0; $f1--) {
            for ($f2 = 9; $f2 >= 0; $f2--) {
                $f = ($f1 * 10) + $f2;
                $texto = "";
                for ($i = 1; $i < 6; $i++) {
                    $texto .= substr($barcodes[$f1], ($i - 1), 1) . substr($barcodes[$f2], ($i - 1), 1);
                }
                $barcodes[$f] = $texto;
            }
        }
        // guarda inicial
        $this->html = "
		<img src='" . $this->barra_preta . "' width='" . $this->fino . "' height='" . $this->altura . "' border='0'><img 
		src='" . $this->barra_branca . "' width='" . $this->fino . "' height='" . $this->altura . "' border='0'><img 
		src='" . $this->barra_preta . "' width='" . $this->fino . "' height='" . $this->altura . "' border=0><img 
		src='" . $this->barra_branca . "' width='" . $this->fino . "' height='" . $this->altura . "' border=0><img 
		";

        $texto = $this->valor;
        if ((strlen($texto) % 2) <> 0) {
            $texto = "0" . $texto;
        }

        // Draw dos dados
        while (strlen($texto) > 0) {
            $i = round($this->_esquerda($texto, 2));
            $texto = $this->_direita($texto, strlen($texto) - 2);
            $f = $barcodes[$i];
            for ($i = 1; $i < 11; $i+=2) {
                if (substr($f, ($i - 1), 1) == "0") {
                    $f1 = $this->fino;
                } else {
                    $f1 = $this->largo;
                }

                $this->html .= "src='" . $this->barra_preta . "' width='" . $f1 . "' height='" . $this->altura . "' border='0'><img \n";

                if (substr($f, $i, 1) == "0") {
                    $f2 = $this->fino;
                } else {
                    $f2 = $this->largo;
                }

                $this->html .= "src='" . $this->barra_branca . "' width='" . $f2 . "' height='" . $this->altura . "' border='0'><img \n";
            }
        }

        // Draw guarda final
        $this->html .= "
		src='" . $this->barra_preta . "' width='" . $this->largo . "' height='" . $this->altura . "' border='0'><img
		src='" . $this->barra_branca . "' width='" . $this->fino . "' height='" . $this->altura . "' border='0'><img
		src='" . $this->barra_preta . "' width='1' height='" . $this->altura . "' border=0>
		";

        if ($draw) {
            echo $this->html;
        }
    }

// fun��o parseBarCode

    function drawBarCode() {
        $this->parseBarCode(true);
    }

    // privadas
    function _esquerda($entra, $comp) {
        return substr($entra, 0, $comp);
    }

    function _direita($entra, $comp) {
        return substr($entra, strlen($entra) - $comp, $comp);
    }

}

// classe BarCode
?>
