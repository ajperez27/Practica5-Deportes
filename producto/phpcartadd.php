<?php

function autoload($clase) {
    require '../clases/' . $clase . '.php';
}

spl_autoload_register('autoload');
$idProducto = Leer::get("idProducto");

session_start();
if (isset($_SESSION["__cesta"])) {
    $cesta = $_SESSION["__cesta"];
} else {
    $_SESSION["__cesta"] = array();
    $cesta = $_SESSION["__cesta"];
}
$bd = new BaseDatos();
$modelo = new ModeloProducto($bd);
$producto = $modelo->get($idProducto);
$destino = Leer::get("destino");

if (isset($cesta[$idProducto])) {
    $detalleVenta = $cesta[$idProducto];
    $detalleVenta->setCantidad($detalleVenta->getCantidad() + 1);
} else {
    $detalleVenta = new DetalleVenta(null, null, $idProducto, 1, null, null, null);
    $cesta[$idProducto] = $detalleVenta;
}

$_SESSION["__cesta"] = $cesta;

if ($destino == "carro"){
    header("Location: ../carro.php#aqui");
} 
elseif ($destino == "comprar"){
    header("Location: realizarcompra.php");
} 
else{
    header("Location: ../index.php");
}