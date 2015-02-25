<?php

function autoload($clase) {
    require '../clases/' . $clase . '.php';
}

spl_autoload_register('autoload');
$idProducto = Leer::get("idProducto");
$destino = Leer::get("destino");
echo $destino;

session_start();
if (isset($_SESSION["__cesta"])) {
    $cesta = $_SESSION["__cesta"];
} else {
    $bd->closeConexion();
    header("Location: ../index.php");
    exit();
}
unset($cesta[$idProducto]);

$_SESSION["__cesta"] = $cesta;

if ($destino == "comprar") {
    $bd->closeConexion();
    header("Location: realizarcompra.php");
} else {
    $bd->closeConexion();
    header("Location: ../carro.php#aqui");
}