<?php

/**
 * Class ModeloVenta
 *
 * @version 1.01
 * @author Antonio Javier Pérez Medina
 * @license http://...
 * @copyright izvbycv
 * Esta clase gestiona las ventas con la base de datos.
 */
class ModeloVenta {

    private $bd;
    private $tabla = "venta";

    function __construct(BaseDatos $bd) {
        $this->bd = $bd;
    }

    /**
     * Devuelve -1 si no añade correctamente
     * @access public
     * @return int 
     */
    function add(Venta $objeto) {
        $sql = "insert into $this->tabla values(null, :fecha, :hora, :pago, :nombre, :direccion, :precio);";
        $parametros["fecha"] = $objeto->getFecha();
        $parametros["hora"] = $objeto->getHora();
        $parametros["pago"] = $objeto->getPago();
        $parametros["nombre"] = $objeto->getNombre();
        $parametros["direccion"] = $objeto->getDireccion();
        $parametros["precio"] = $objeto->getPrecio();
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
    function delete(Venta $objeto) {
        $sql = "delete from $this->tabla where idVenta = :idVenta;";
        $parametros["idVenta"] = $objeto->getIdVenta();
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
    function deletePorId($idVenta) {
        return $this->delete(new Venta($idVenta));
    }

   /**
     * Devuelve -1 si no edita correctamente
     * @access public
     * @return int 
     */
    
    
     function edit(Venta $objeto) {
        $sql = "update $this->tabla  set fecha = :fecha, hora = :hora, pago = :pago,"
                . " nombre = :nombre, direccion = :direccion,"
                . " precio = :precio "
                . "where idVenta = :idVenta";
        $parametros["fecha"] = $objeto->getFecha();
        $parametros["hora"] = $objeto->getHora();
        $parametros["pago"] = $objeto->getPago();
        $parametros["nombre"] = $objeto->getNombre();
        $parametros["direccion"] = $objeto->getDireccion();
        $parametros["precio"] = $objeto->getPrecio();
        $parametros["idVenta"] = $objeto->getIdVenta();
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
    function editPK(Venta $objetoOriginal, Venta $objetoNuevo) {
        $sql = "update $this->tabla  set fecha = :fecha, hora = :hora, pago = :pago, "
                . "nombre = :nombre, direccion = :direccion, "
                . "precio = :precio "
                . "where idVenta = :idVentapk";
        $parametros["fecha"] = $objetoNuevo->getFecha();
        $parametros["hora"] = $objetoNuevo->getHora();
        $parametros["pago"] = $objetoNuevo->getPago();
        $parametros["nombre"] = $objetoNuevo->getNombre();
        $parametros["direccion"] = $objetoNuevo->getDireccion();
        $parametros["idVenta"] = $objetoNuevo->getIdVenta();
        $parametros["precio"] = $objetoNuevo->getPrecio();
        $parametros["idVentapk"] = $objetoOriginal->getIdVenta();
        $r = $this->bd->setConsulta($sql, $parametros);
        if (!$r) {
            return -1;
        }
        return $this->bd->getNumeroFilas();
    }

  /**
     * Devuelve la venta buscada
     * @access public
     * @return Plato $plato
     */
    function get($idVenta) {
        $sql = "select * from $this->tabla where idVenta = :idVenta";
        $parametros["idVenta"] = $idVenta;
        $r = $this->bd->setConsulta($sql, $parametros);
        if ($r) {
            $venta = new Venta();
            $venta->set($this->bd->getFila());
            return $venta;
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
     * Devuelve un array con las ventas
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
                $venta = new Venta();
                $venta->set($fila);
                $list[] = $venta;
            }
        } else {
            return null;
        }
        return $list;
    }

    function getListPagina($pagina = 0, $rpp = Configuracion::RPP, $condicion = "1=1", $parametros = array(), $orderby = "1") {
        $pos = $pagina * $rpp;
        $sql = "select * from "
                . $this->tabla .
                " where $condicion order by $orderby limit $pos, $rpp";
        $r = $this->bd->setConsulta($sql, $parametros);
        $respuesta = array();
        while ($fila = $this->bd->getFila()) {
            $objeto = new Venta();
            $objeto->set($fila);
            $respuesta[] = $objeto;
        }
        return $respuesta;
    }

    function getTabla() {
        return $this->tabla;
    }

        /**
     * Devuelve una lista con los productos en formato Json
     * @access public
     * @return int 
     */
    function getListJSON($pagina = 0, $rpp = Configuracion::RPP, $condicion = "1=1", $parametros = array(), $orderby = "1") {
        $pos = $pagina * $rpp;
        $sql = "select * from $this->tabla where $condicion order by $orderby limit $pos, $rpp";
        $this->bd->setConsulta($sql, $parametros);
        $r = "[ ";
        while ($fila = $this->bd->getFila()) {
            $objeto = new Venta();
            $objeto->set($fila);
            $r .=$objeto->getJSON() . ",";
        }

        $r = substr($r, 0, -1) . "]";
        return $r;
    }

    function getJSON($id) {
        return $this->get($id)->getJSON();
    }

  /**
     * Devuelve un los select con las ventas
     * @access public
     * @return array $list
     */
    function selectHtml($idVenta, $name, $condicion, $parametros, $orderby = 1, $valorSeleccionado = "", $blanco = true, $textoBlanco = "&nbsp;") {
        $select = "<select name='$name' idVenta='$idVenta'>";
        $select .="</select>";
        if ($blanco) {
            $select .="<option value=''>$textoBlanco</option>";
        }
        $lista = $this->getList($condicion, $parametros, $orderby);
        foreach ($lista as $objeto) {
            $selected = "";
            if ($objeto->getIdVenta() == $valorSeleccionado) {
                $selected = "selected";
            }
            $select .="<option $selected value='" . $objeto->getIdVenta() . "'>" . $objeto->getFecha() . ", " . $objeto->getHora() . ", " . $objeto->getPago() . ", " . $objeto->getNombre() . ", " . $objeto->getDireccion() . ", " . $objeto->getPrecio() . "</option>";
        }
        $select .= "</select>";
        return $select;
    }
}
?>
