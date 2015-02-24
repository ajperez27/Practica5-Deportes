<?php

/**
 * Class ModeloPaypal
 *
 * @version 1.01
 * @author Antonio Javier Pérez Medina
 * @license http://...
 * @copyright izvbycv
 * Esta clase gestiona los objetos paypal con la base de datos.
 */
class ModeloPaypal {

    private $bd;
    private $tabla = "paypal";

    function __construct(BaseDatos $bd) {
        $this->bd = $bd;
    }

    /**
     * Devuelve -1 si no añade correctamente
     * @access public
     * @return int 
     */
    function add(Paypal $objeto) {
        $sql = "insert into $this->tabla values (null, :itemname, :verificado);";
        $parametros["itemname"] = $objeto->getItemname();
        $parametros["verificado"] = $objeto->getVerificado();      
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
    function delete(Paypal $objeto) {
        $sql = "delete from $this->tabla where idPaypal = :idPaypal";
        $parametros["idPaypal"] = $objeto->getIdPaypal();
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
    function deletePorId($idPaypal) {
        return $this->delete(new Paypal($idPaypal));
    }

    /**
     * Devuelve -1 si no edita correctamente
     * @access public
     * @return int 
     */
    function edit(Paypal $objeto) {
        $sql = "update $this->tabla set itemname = :itemname, verificado = :verificado,"               
                . "where idPaypal= :idPaypal;";
        $parametros["itemname"] = $objeto->getItemname();
        $parametros["verificado"] = $objeto->getVerificado();
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
    function editPK(Paypal $objetoOriginal, Paypal $objetoNuevo) {
        $sql = "update $this->tabla set itemname = :itemname, verificado = :verificado,"
                . "where idPaypal= :idPaypalpk;";
        $parametros["itemname"] = $objetoNuevo->getItemname();
        $parametros["verificado"] = $objetoNuevo->getVerificado();
        $parametros["idPaypal"] = $objetoNuevo->getIdPaypal();
        $parametros["idPaypalpk"] = $objetoOriginal->getIdPaypal();
        $r = $this->bd->setConsulta($sql, $parametros);

        if (!$r) {
            return -1;
        }
        return $this->bd->getNumeroFilas(); //0
    }

    /**
     * Devuelve el paypal buscado
     * @access public
     * @return Paypal $paypal
     */
    function get($idPaypal) {
        $sql = "select * from $this->tabla where idPaypal= :idPaypal";
        $parametros["idPaypal"] = $idPaypal;
        $r = $this->bd->setConsulta($sql, $parametros);
        if ($r) {
            $paypal = new Paypal();
            $paypal->set($this->bd->getFila());
            return $paypal;
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
     * Devuelve un array con los paypal
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
                $paypal = new Paypal();
                $paypal->set($fila);
                $list[] = $paypal;
            }
        } else {
            return null;
        }
        return $list;
    }

    /**
     * Devuelve un array con los paypal
     * @access public
     * @return array $list
     */
    function selectHtml($idPaypal, $name, $condicion, $parametros, $valorSeleccionado = "", $blanco = true, $orderby = "1") {
        $select = "<select  name='$name' idPaypal='$idPaypal'>";
        if ($blanco) {
            $select.= "<option value='' />&nbsp $ </option>";
        }
        $lista = $this->getList($condicion, $parametros, $orderby);
        foreach ($lista as $objeto) {
            $selected = "";
            if ($objeto->getIdPaypal() == $valorSeleccionado) {
                $selected = "selected";
            }

            $select = "<option $selected value='" . $objeto->getIdPaypal() . "' >" . $objeto->getItemname() . "," 
                    . $objeto->getVerificado() . "</option>";
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

    function getJSON($idPaypal) {
        return $this->get($idPaypal)->getJSON();
    }

    /**
     * Devuelve una lista con los productos en formato Json
     * @access public
     * @return int 
     */
    function getListJSON($pagina = 0, $rpp = Configuracion::RPP, $condicion = "1=1", $parametros = array(), $orderby = "1") {
        $post = $pagina * $rpp;
        $sql = "select * from $this->tabla where $condicion order by $orderby limit $post, $rpp";

        $this->bd->setConsulta($sql, $parametros);
        $r = "[ ";
        while ($fila = $this->bd->getFila()) {
            $objeto = new Paypal();
            $objeto->set($fila);
            $r .= $objeto->getJSON() . ",";
        }
        $r = substr($r, 0, -1) . "]";
        return $r;
    }
    
        /**
     * Devuelve el paypal buscado por itemname
     * @access public
     * @return Paypal $paypal
     */
    function getPorItemName($itemname) {
        $sql = "select * from $this->tabla where itemname= :itemname";
        $parametros["itemname"] = $itemname;
        $r = $this->bd->setConsulta($sql, $parametros);
        if ($r) {
            $paypal = new Paypal();
            $paypal->set($this->bd->getFila());
            return $paypal;
        }
        return null;
    }
}