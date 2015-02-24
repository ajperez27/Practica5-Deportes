<?php

/**
 * Class DetalleVenta
 *
 * @version 1.01
 * @author Antonio Javier Pérez Medina
 * @license http://...
 * @copyright izvbycv
 * Esta clase gestiona los detalles de las ventas con la base de datos.
 */
class DetalleVenta {
    
 private $idDetalleVenta;
 private $idVenta;
 private $idProducto;
 private $cantidad;
 private $precio;
 private $iva; 
 
 function __construct($idDetalleVenta = null, $idVenta= null, $idProducto = null, $cantidad = 0, $precio = 0, $iva = 0) {
     $this->idDetalleVenta = $idDetalleVenta;
     $this->idVenta = $idVenta;
     $this->idProducto = $idProducto;
     $this->cantidad = $cantidad;
     $this->precio = $precio;
     $this->iva = $iva;
 }

    function set($datos, $inicio = 0) {
        $this->id = $datos[0 + $inicio];
        $this->idVenta = $datos[1 + $inicio];
        $this->idProducto = $datos[2 + $inicio];
        $this->cantidad = $datos[3 + $inicio];
        $this->precio = $datos[4 + $inicio];
        $this->iva = $datos[5 + $inicio];
    }

    function getIdDetalleVenta() {
        return $this->idDetalleVenta;
    }

    function getIdVenta() {
        return $this->idVenta;
    }

    function getIdProducto() {
        return $this->idProducto;
    }

    function getCantidad() {
        return $this->cantidad;
    }

    function getPrecio() {
        return $this->precio;
    }

    function getIva() {
        return $this->iva;
    }

    function setIdDetalleVenta($idDetalleVenta) {
        $this->idDetalleVenta = $idDetalleVenta;
    }

    function setIdVenta($idVenta) {
        $this->idVenta = $idVenta;
    }

    function setIdProducto($idProducto) {
        $this->idProducto = $idProducto;
    }

    function setCantidad($cantidad) {
        $this->cantidad = $cantidad;
    }

    function setPrecio($precio) {
        $this->precio = $precio;
    }

    function setIva($iva) {
        $this->iva = $iva;
    }    
        
    public function getJSON() {
        $prop = get_object_vars($this);
        $resp = '{ ';
        foreach ($prop as $key => $value) {
            $resp.='"' . $key . '":' . json_encode(htmlspecialchars_decode($value)) . ',';
        }
        $resp = substr($resp, 0, -1) . "}";
        return $resp;
    }
}

?>
