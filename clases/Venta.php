<?php
/**
 * Class Producto
 *
 * @version 1.01
 * @author Antonio Javier Pérez Medina
 * @license http://...
 * @copyright izvbycv
 * Esta clase gestiona ventas.
 */

class Venta {
    
private $idVenta;
private $fecha;
private $hora;
private $pago; 
private $nombre;
private $direccion;
private $precio;

function __construct($idVenta = null, $fecha = null, $hora = null, $pago = 'no', $nombre = null, $direccion = null, $precio = 0) {
    $this->idVenta = $idVenta;
    $this->fecha = $fecha;
    $this->hora = $hora;
    $this->pago = $pago;
    $this->nombre = $nombre;
    $this->direccion = $direccion;
    $this->precio = $precio;
}

    function set($datos, $inicio = 0) {
        $this->idVenta = $datos[0 + $inicio];
        $this->fecha = $datos[1 + $inicio];
        $this->hora = $datos[2 + $inicio];
        $this->pago = $datos[3 + $inicio];
        $this->nombre = $datos[4 + $inicio];
        $this->direccion = $datos[5 + $inicio];
        $this->precio= $datos[6 + $inicio];
    }

    function getIdVenta() {
        return $this->idVenta;
    }

    function getFecha() {
        return $this->fecha;
    }

    function getHora() {
        return $this->hora;
    }

    function getPago() {
        return $this->pago;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getDireccion() {
        return $this->direccion;
    }

    function getPrecio() {
        return $this->precio;
    }

    function setIdVenta($idVenta) {
        $this->idVenta = $idVenta;
    }

    function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    function setHora($hora) {
        $this->hora = $hora;
    }

    function setPago($pago) {
        $this->pago = $pago;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setDireccion($direccion) {
        $this->direccion = $direccion;
    }

    function setPrecio($precio) {
        $this->precio = $precio;
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
            $resp.='"' . $key . '":' . json_encode(htmlspecialchars_decode($value)) . ',';
        }
        $resp = substr($resp, 0, -1) . "}";
        return $resp;
    }
}

?>
