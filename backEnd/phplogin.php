<?php

require '../require/comun.php';
$bd = new BaseDatos();

$login = Leer::post("login");
$clave = Leer::post("clave");

echo $login;
echo $clave;
$modelo = new ModeloUsuario($bd);
$r = $modelo->autentifica($login, $clave);
echo var_dump($r);

if ($r instanceof Usuario) {
    $sesion->setUsuario($r);
    $bd->closeConexion();
    if ($r->getRol() == "administrador") {
        header("Location: viewVentas.php");
    } 
} else {
    $sesion->cerrar();
    $bd->closeConexion();
    header("Location: index.php?error=Datos Incorrectos&r=-1");
}

