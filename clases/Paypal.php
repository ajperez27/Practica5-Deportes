<?php

/**
 * Class Paypal
 *
 * @version 1.01
 * @author Antonio Javier Pérez Medina
 * @license http://...
 * @copyright izvbycv
 * Esta clase gestiona paypal.
 */

class Paypal {
    
    private $idPaypal;
    private $itemname;
    private $verificado;
 

    function __construct($idPaypal = null, $itemname = null, $verificado = 'no verificado') {
        $this->idPaypal = $idPaypal;
        $this->itemname = $itemname;
        $this->verificado = $verificado; 
    }

    function set($datos, $inicio = 0) {
        $this->idPaypal = $datos[0 + $inicio];
        $this->itemname = $datos[1 + $inicio];
        $this->verificado = $datos[2 + $inicio]; 
    }

    function getIdPaypal() {
        return $this->idPaypal;
    }

    function getItemname() {
        return $this->itemname;
    }

    function getVerificado() {
        return $this->verificado;
    }

    function setIdPaypal($idPaypal) {
        $this->idPaypal = $idPaypal;
    }

    function setItemname($itemname) {
        $this->itemname = $itemname;
    }

    function setVerificado($verificado) {
        $this->verificado = $verificado;
    }

        
      /**
     * Devuelve un objeto en formato JSON
     * @access public
     * @return int 
     */
    
    public function getJSON() {
        $prop = get_object_vars($this);
        $resp = "{ ";
        foreach ($prop as $key => $value) {
            $resp.= '"' . $key . '":' . json_encode(htmlspecialchars_decode($value)) . ',';
        }
        $resp = substr($resp, 0, -1) . "}";
        return $resp;
    }
   
}
