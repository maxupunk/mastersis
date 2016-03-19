<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Convert {

    function em_real($campo = NULL) {
        if ($campo != NULL) {
            $vi = trim($campo);
            $vi = str_replace(",", "", $vi);
            return number_format($vi, 2, ",", ".");
        }
    }

    function somar_real($campo1, $campo2) {
        $campo1 = str_replace(",", "", $campo1);
        $campo2 = str_replace(",", "", $campo2);
        return $this->em_real($campo1 + $campo2);
    }

    function EmDecimal($campo = NULL) {
        $source = array('.', ',');
        $replace = array('', '.');
        $valor = str_replace($source, $replace, $campo);
        return $valor;
    }

    function DataParaDB($campo = NULL) {
        if ($campo != NULL) {
            return implode("-", array_reverse(explode("/", $campo)));
        }
    }

    function CompareData($dataInicio = NULL, $dataFinal = NULL) {
        // verifica se a data inicial é menor que a final
        if ($dataInicio != NULL and $dataFinal != NULL) {
            $dataInicio = implode("-", array_reverse(explode("/", $dataInicio)));
            $dataFinal = implode("-", array_reverse(explode("/", $dataFinal)));
            if ($dataInicio < $dataFinal) {
                return true;
            }
        }
    }

    function EstatusPedido($estatus) {
        switch ($estatus) {
            case '1':
                $retorno = 'EM ABERTO';
                break;
            case '2':
                $retorno = 'AGUARDANDO PAGAMENTO';
                break;
            case '3':
                $retorno = 'ENVIADO';
                break;
            case '4':
                $retorno = 'CONCLUIDO';
                break;
            case '5':
                $retorno = 'CANCELADA';
                break;
        }
        return $retorno;
    }

    public function EstatusOs($estatus) {
        switch ($estatus) {
            case '1':
                $retorno = 'ABERTO';
                break;
            case '2':
                $retorno = 'PENDENTE';
                break;
            case '3':
                $retorno = 'CONCLUIDO';
                break;
            case '4':
                $retorno = 'ENTREGUE';
                break;
        }
        return $retorno;
    }

}
