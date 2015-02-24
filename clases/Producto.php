<?php
/**
 * Class Producto
 *
 * @version 1.01
 * @author Antonio Javier Pérez Medina
 * @license http://...
 * @copyright izvbycv
 * Esta clase crea los productos.
 */
class Producto {
    private $idProducto;
    private $nombre;
    private $descripcion;
    private $precio; 
    private $iva; 
    private $foto;

    function __construct($idProducto = null, $nombre = null, $descripcion = null, $precio = null, $iva = null, $foto = null) {
        $this->idProducto = $idProducto;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->precio = $precio;
        $this->iva = $iva;
        $this->foto = $foto;
    }

    function set($datos, $inicio = 0) {
        $this->idProducto = $datos[0 + $inicio];
        $this->nombre = $datos[1 + $inicio];
        $this->descripcion = $datos[2 + $inicio];
        $this->precio = $datos[3 + $inicio];
        $this->iva = $datos[4 + $inicio];
        $this->foto = $datos[5 + $inicio];
    }

    function getIdProducto() {
        return $this->idProducto;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getDescripcion() {
        return $this->descripcion;
    }

    function getPrecio() {
        return $this->precio;
    }

    function getIva() {
        return $this->iva;
    }

    function getFoto() {
        return $this->foto;
    }

    function setIdProducto($idProducto) {
        $this->idProducto = $idProducto;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    function setPrecio($precio) {
        $this->precio = $precio;
    }

    function setIva($iva) {
        $this->iva = $iva;
    }

    function setFoto($foto) {
        $this->foto = $foto;
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
?>
