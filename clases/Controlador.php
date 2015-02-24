<?php

function autoload($clase) {
    require $clase . '.php';
}

spl_autoload_register('autoload');

class Controlador {

    function viewCarrito() {
        $pagina = 0;
        if (Leer::get("pagina") != null) {
            $pagina = Leer::get("pagina");
        }
        $bd = new BaseDatos();
        $modelo = new ModeloProducto($bd);
        $paginas = $modelo->getNumeroPaginas();
        $total = $modelo->count();
        $enlaces = Paginacion::getEnlacesPaginacion($pagina, $total[0],  Configuracion::RPP);
        $productos = "";
        session_start();
        if (isset($_SESSION["__cesta"])) {
            $cesta = $_SESSION["__cesta"];
            if (!$cesta) {
                header("Location: index.php");
            }
            foreach ($cesta as $key => $detalleVenta) {
                $producto = $modelo->get($detalleVenta->getIdProducto());
                $datos = array(
                    "idProducto" => $producto->getIdProducto(),
                    "nombre" => $producto->getNombre(),
                    "descripcion" => $producto->getDescripcion(),
                    "precio" => $producto->getPrecio(),
                    "foto" => $producto->getFoto(),
                    "cantidad" => $detalleVenta->getCantidad()
                );
                $v = new Vista("plantillaCarroDetalle", $datos);
                $productos.= $v->renderData();
            }
        }
        $datos = array(
        "articulos" => $productos,
        "enlace1" => $enlaces["inicio"],
        "enlace2" => $enlaces["anterior"],
        "enlace3" => $enlaces["primero"],
        "enlace4" => $enlaces["segundo"],
        "enlace5" => $enlaces["actual"],
        "enlace6" => $enlaces["cuarto"],
        "enlace7" => $enlaces["quinto"],
        "enlace8" => $enlaces["siguiente"],
        "enlace9" => $enlaces["ultimo"], 
        );
        $v = new Vista("plantillaCarro", $datos);
        $v->render();
        exit();
    }

}
