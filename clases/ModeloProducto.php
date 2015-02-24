<?php

/**
 * Class ModeloProducto
 *
 * @version 1.01
 * @author Antonio Javier Pérez Medina
 * @license http://...
 * @copyright izvbycv
 * Esta clase gestiona los productos con la base de datos.
 */
class ModeloProducto {

    private $bd;
    private $tabla = "producto";

    function __construct(BaseDatos $bd) {
        $this->bd = $bd;
    }

    /**
     * Devuelve -1 si no añade correctamente
     * @access public
     * @return int 
     */
    function add(Producto $objeto) {
        $sql = "insert into $this->tabla values (null, :nombre, :descripcion, "
                . ":precio, :iva, :foto);";
        $parametros["nombre"] = $objeto->getNombre();
        $parametros["descripcion"] = $objeto->getDescripcion();
        $parametros["precio"] = $objeto->getPrecio();
        $parametros["iva"] = $objeto->getIva();
        $parametros["foto"] = $objeto->getFoto();
        $r = $this->bd->setConsulta($sql, $parametros);
        if (!$r) {
            return -1;
        }
        return $this->bd->getAutonumerico(); //0         
    }

    /**
     * Devuelve -1 si no borra correctamente
     * @access public
     * @return int 
     */
    function delete(Producto $objeto) {
        $sql = "delete from $this->tabla where idProducto = :idProducto";
        $parametros["idProducto"] = $objeto->getIdProducto();
        $r = $this->bd->setConsulta($sql, $parametros);

        if (!$r) {
            return -1;
        }
        return $this->bd->getNumeroFilas(); //0    
    }

    /**
     * Devuelve el resultado del borrado
     * @access public
     * @return int 
     */
    function deletePorId($idProducto) {
        return $this->delete(new Producto($idProducto));
    }

    /**
     * Devuelve -1 si no edita correctamente
     * @access public
     * @return int 
     */
    function edit(Producto $objeto) {
        $sql = "update $this->tabla set nombre = :nombre, descripcion = :descripcion,"
                . "precio = :precio, iva = :iva, foto = :foto "
                . "where idProducto= :idProducto;";
        $parametros["nombre"] = $objeto->getNombre();
        $parametros["descripcion"] = $objeto->getDescripcion();
        $parametros["precio"] = $objeto->getPrecio();
        $parametros["iva"] = $objeto->getIva();
        $parametros["precio"] = $objeto->getPrecio();
        $parametros["foto"] = $objeto->getFoto();
        $r = $this->bd->setConsulta($sql, $parametros);

        if (!$r) {
            return -1;
        }
        return $this->bd->getNumeroFilas(); //0
    }

    /**
     * Devuelve -1 si no edita correctamente por la primary key antigua
     * @access public
     * @return int 
     */
    function editPK(Producto $objetoOriginal, Producto $objetoNuevo) {
        $sql = "update $this->tabla set nombre = :nombre, descripcion = :descripcion,"
                . "precio = :precio,iva = :iva ,foto = :foto where idProducto= :idProductopk;";
        $parametros["nombre"] = $objetoNuevo->getNombre();
        $parametros["descripcion"] = $objetoNuevo->getDescripcion();
        $parametros["precio"] = $objetoNuevo->getPrecio();
        $parametros["iva"] = $objetoNuevo->getIva();
        $parametros["foto"] = $objetoNuevo->getFoto();
        $parametros["idProducto"] = $objetoNuevo->getIdProducto();
        $parametros["idProductopk"] = $objetoOriginal->getIdProducto();
        $r = $this->bd->setConsulta($sql, $parametros);

        if (!$r) {
            return -1;
        }
        return $this->bd->getNumeroFilas(); //0
    }

    /**
     * Devuelve el producto buscado
     * @access public
     * @return Producto $producto
     */
    function get($idProducto) {
        $sql = "select * from $this->tabla where idProducto= :idProducto";
        $parametros["idProducto"] = $idProducto;
        $r = $this->bd->setConsulta($sql, $parametros);
        if ($r) {
            $producto = new Producto();
            $producto->set($this->bd->getFila());
            return $producto;
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
     * Devuelve un array con los productos
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
                $producto = new Producto();
                $producto->set($fila);
                $list[] = $producto;
            }
        } else {
            return null;
        }
        return $list;
    }

    /**
     * Devuelve un array con los productos
     * @access public
     * @return array $list
     */
    function selectHtml($idProducto, $name, $condicion, $parametros, $valorSeleccionado = "", $blanco = true, $orderby = "1") {
        $select = "<select  name='$name' id='$idProducto'>";
        if ($blanco) {
            $select.= "<option value='' />&nbsp $ </option>";
        }
        $lista = $this->getList($condicion, $parametros, $orderby);
        foreach ($lista as $objeto) {
            $selected = "";
            if ($objeto->getIdProducto() == $valorSeleccionado) {
                $selected = "selected";
            }

            $select = "<option $selected value='" . $objeto->getIdProducto() . "' >" . $objeto->getNombre() . "," . $objeto->getDescripcion() .
                    $objeto->getPrecio() .$objeto->getIva() .$objeto->getFoto() . "</option>";
        }

        $select.="</select>";
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
    
      function getJSON($idProducto) {
        return $this->get($idProducto)->getJSON();
    }
    
    
        /**
     * Devuelve una lista con los productos en formato Json
     * @access public
     * @return int 
     */
    function getListJSON($pagina = 0, $rpp = 3, $condicion = "1=1", $parametros = array(), $orderby = "1") {
        $post = $pagina * $rpp;
        $sql = "select * from $this->tabla where $condicion order by $orderby limit $post, $rpp";

        $this->bd->setConsulta($sql, $parametros);
        $r = "[ ";
        while ($fila = $this->bd->getFila()) {
            $objeto = new Producto();
            $objeto->set($fila);
            $r .= $objeto->getJSON() . ",";
        }
        $r = substr($r, 0, -1) . "]";
        return $r;
    }
}

?>
