<?php

/**
 * Class ModeloDetalleVenta
 *
 * @version 1.01
 * @author Antonio Javier Pérez Medina
 * @license http://...
 * @copyright izvbycv
 * Esta clase gestiona los productos con la base de datos.
 */
class ModeloDetalleVenta {

    private $bd;
    private $tabla = "detalleVenta";

    function __construct(BaseDatos $bd) {
        $this->bd = $bd;
    }

    /**
     * Devuelve -1 si no añade correctamente
     * @access public
     * @return int 
     */
    function add(DetalleVenta $objeto) {
        $sql = "insert into $this->tabla values(null, :idVenta, :idProducto, :cantidad, :precio, :iva);";
        $parametros["idVenta"] = $objeto->getIdVenta();
        $parametros["idProducto"] = $objeto->getIdProducto();
        $parametros["cantidad"] = $objeto->getCantidad();
        $parametros["precio"] = $objeto->getPrecio();
        $parametros["iva"] = $objeto->getIva();
        $r = $this->bd->setConsulta($sql, $parametros);
        if (!$r) {
            return -1;
        }
        return $this->bd->getAutonumerico();
    }

    /**
     * Devuelve -1 si no borra correctamente
     * @access public
     * @return int 
     */
    function delete(DetalleVenta $objeto) {
        $sql = "delete from $this->tabla where idDetalleVenta = :idDetalleVenta;";
        $parametros["idDetalleVenta"] = $objeto->getIdDetalleVenta();
        $r = $this->bd->setConsulta($sql, $parametros);
        if (!$r) {
            return -1;
        }
        return $this->bd->getNumeroFilas();
    }

    /**
     * Devuelve el resultado del borrado
     * @access public
     * @return int 
     */
    function deletePorId($idDetalleVenta) {
        return $this->delete(new DetalleVenta($idDetalleVenta));
    }

    /**
     * Devuelve -1 si no edita correctamente
     * @access public
     * @return int 
     */
    function edit(DetalleVenta $objeto) {
        $sql = "update $this->tabla  set idVenta = :idVenta, idProducto = :idProducto, "
                . "cantidad = :cantidad, precio = :precio, iva = :iva "
                . "where idDetalleVenta = :idDetalleVenta";
        $parametros["idVenta"] = $objeto->getIdVenta();
        $parametros["idProducto"] = $objeto->getIdProducto();
        $parametros["cantidad"] = $objeto->getCantidad();
        $parametros["precio"] = $objeto->getPrecio();
        $parametros["iva"] = $objeto->getIva();
        $parametros["idDetalleVenta"] = $objeto->getIdDetalleVenta();
        $r = $this->bd->setConsulta($sql, $parametros);
        if (!$r) {
            return -1;
        }
        return $this->bd->getNumeroFilas();
    }

    /**
     * Devuelve -1 si no edita correctamente por la primary key antigua
     * @access public
     * @return int 
     */
    function editPK(DetalleVenta $objetoOriginal, DetalleVenta $objetoNuevo) {
        $sql = "update $this->tabla  set idVenta = :idVenta, idProducto = :idProducto, "
                . "cantidad = :cantidad, precio = :precio, iva = :iva where idDetalleVenta = :idDetalleVentapk";
        $parametros["idVenta"] = $objetoNuevo->getIdVenta();
        $parametros["idProducto"] = $objetoNuevo->getIdProducto();
        $parametros["cantidad"] = $objetoNuevo->getCantidad();
        $parametros["precio"] = $objetoNuevo->getPrecio();
        $parametros["iva"] = $objetoNuevo->getIva();
        $parametros["idDetalleVenta"] = $objetoNuevo->getIdDetalleVenta();
        $parametros["idDetalleVentapk"] = $objetoOriginal->getIdDetalleVenta();
        $r = $this->bd->setConsulta($sql, $parametros);
        if (!$r) {
            return -1;
        }
        return $this->bd->getNumeroFilas();
    }

    /**
     * Devuelve el detalleVenta buscado
     * @access public
     * @return Plato $plato
     */
    function get($idDetalleVenta) {
        $sql = "select * from $this->tabla where idDetalleVenta = :idDetalleVenta";
        $parametros["idDetalleVenta"] = $idDetalleVenta;
        $r = $this->bd->setConsulta($sql, $parametros);
        if ($r) {
            $detalleVenta = new DetalleVenta();
            $detalleVenta->set($this->bd->getFila());
            return $detalleVenta;
        }
        return null;
    }
    
        /**
     * Devuelve el detalleVenta buscado
     * @access public
     * @return Plato $plato
     */
    function getPorIdVenta($idVenta) {
        $sql = "select * from $this->tabla where idVenta = :idVenta";
        $parametros["idVenta"] = $idVenta;
        $r = $this->bd->setConsulta($sql, $parametros);
        if ($r) {
            $detalleVenta = new DetalleVenta();
            $detalleVenta->set($this->bd->getFila());
            return $detalleVenta;
        }
        return null;
    }

    /**
     * Devuelve -1 si no realiza la consulta corectamente
     * @access public
     * @return int 
     */
    function count($condicion = "1=1", $parametros = array()) {
        $sql = "select count(*) from $this->tabla where $condicion";
        $r = $this->bd->setConsulta($sql, $parametros);
        if ($r) {
            $aux = $this->bd->getFila();
            return $aux[0];
        }
        return -1;
    }

    /**
     * Devuelve el numeo de paginas
     * @access public
     * @return int 
     */
    function getNumeroPaginas($rpp = Configuracion::RPP) {
        $lista = $this->count();
        return (ceil($lista[0] / $rpp) - 1);
    }

     /**
     * Devuelve un array con los detalles de la venta
     * @access public
     * @return array $list
     */
    function getList($pagina = 0, $rpp = Configuracion::RPP, $condicion = "1=1", $parametros = array(), $orderby = "1") {
        $list = array();
        $principio = $pagina * $rpp;
        $sql = "select * from $this->tabla where $condicion order by $orderby limit $principio,$rpp";
        $r = $this->bd->setConsulta($sql, $parametros);
        if ($r) {
            while ($fila = $this->bd->getFila()) {
                $detalleVenta = new DetalleVenta();
                $detalleVenta->set($fila);
                $list[] = $detalleVenta;
            }
        } else {
            return null;
        }
        return $list;
    }

     /**
     * Devuelve un array con los detalles de la venta de una página
     * @access public
     * @return array $list
     */
    
    function getListPagina($pagina = 0, $rpp = 10, $condicion = "1=1", $parametros = array(), $orderby = "1") {
        $pos = $pagina * $rpp;
        $sql = "select * from "
                . $this->tabla .
                " where $condicion order by $orderby limit $pos, $rpp";
        $r = $this->bd->setConsulta($sql, $parametros);
        $respuesta = array();
        while ($fila = $this->bd->getFila()) {
            $objeto = new DetalleVenta();
            $objeto->set($fila);
            $respuesta[] = $objeto;
        }
        return $respuesta;
    }

 /**
     * Devuelve un selct con los detalles de las ventas
     * @access public
     * @return array $list
     */
    function selectHtml($idDetalleVenta, $name, $condicion, $parametros, $orderby = 1, $valorSeleccionado = "", $blanco = true, $textoBlanco = "&nbsp;") {
        $select = "<select name='$name' $idDetalleVenta='$idDetalleVenta'>";
        $select .="</select>";
        if ($blanco) {
            $select .="<option value=''>$textoBlanco</option>";
        }
        $lista = $this->getList($condicion, $parametros, $orderby);
        foreach ($lista as $objeto) {
            $selected = "";
            if ($objeto->getIdDetalleVenta() == $valorSeleccionado) {
                $selected = "selected";
            }
            $select .="<option $selected value='" . $objeto->getIdDetalleVenta() . "'>" . $objeto->getIdVenta() . ", " . $objeto->getIdProducto() . ", " . $objeto->getCantidad() . ", " . $objeto->getPrecio() . ", " . $objeto->getIva() . "</option>";
        }
        $select .= "</select>";
        return $select;
    }
    
   /**
     * Devuelve el nombre de la tabla 
     * @access public
     * @return string tabla
     */
    function getTabla() {
        return $this->tabla;
    }

    function getJSON($idDetalleVenta) {
        return $this->get($idDetalleVenta)->getJSON();
    }
    
     /**
     * Devuelve una lista con los detalles de las ventas en formato Json
     * @access public
     * @return int 
     */
    function getListJSON($pagina = 0, $rpp = Configuracion::RPP, $condicion = "1=1", $parametros = array(), $orderby = "1") {
        $pos = $pagina * $rpp;
        $sql = "select * from $this->tabla where $condicion order by $orderby limit $pos, $rpp";
        $this->bd->setConsulta($sql, $parametros);
        $r = "[ ";
        while ($fila = $this->bd->getFila()) {
            $objeto = new DetalleVenta();
            $objeto->set($fila);
            $r .=$objeto->getJSON() . ",";
        }

        $r = substr($r, 0, -1) . "]";
        return $r;
    }
}

?>
