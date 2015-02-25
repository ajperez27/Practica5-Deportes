<?php

require '../require/comun.php';

$bd = new BaseDatos();

$itemname = "";
$texto = "";
$paymentstatus = "";

$respuesta = "";
$verificado = "";
$pago = "no";

foreach ($_POST as $nombre => $valor) {
    if ($nombre == "item_name") {
        $itemname = $valor;
    }
    if ($nombre == "payment_status") {
        $paymentstatus = $valor;
    }
    $texto.="$nombre : $valor\n";
}
$texto.="********************************\n";

$req = 'cmd=_notify-validate';
foreach ($_POST as $clave => $valor) {
    $valor = urlencode(stripslashes($valor));
    $req .= "&$clave=$valor";
}

$header = "POST /cgi-bin/webscr HTTP/1.0\r\n";
$header .= "Host: www.sandbox.paypal.com\r\n";
$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
$fp = fsockopen('ssl://www.sandbox.paypal.com', 443, $errno, $errstr, 30);
if (!$fp) {//error de conexi贸n
    $respuesta = "error";
    $texto.="********************************\n";
    $texto.="*********ERROR DE CONEXIÓN********\n";
    $texto.="********************************\n";
} else {
    fputs($fp, $header . $req);
    while (!feof($fp)) {
        $res = fgets($fp, 1024);
        if (strcmp($res, "VERIFIED") == 0) { //OK
            $respuesta = "ok";
            $texto.="**********************************\n";
            $texto.="*********COMPRA VERIFICADA********\n";
            $texto.="********************************\n";
        } else if (strcmp($res, "INVALID") == 0) { //ERROR
            $respuesta = "no validado";
            $texto.="**********************************\n";
            $texto.="*********COMPRA INVALIDADA********\n";
            $texto.="********************************\n";
        }
    }

    fclose($fp);
}
file_put_contents("log.txt", $texto, FILE_APPEND);

if ($respuesta == "ok") {
    if ($paymentstatus == "Completed" || $paymentstatus == "Created" || $paymentstatus == "Reversed" || $paymentstatus == "Processed") {
        $verificado = 'verificado';
        $pago = "si";
    } else if ($paymentstatus == "Pending") {
        $verificado = 'verificado';
        $pago = 'duda';
    } else {
        $verificado = 'verificado';
        $pago = 'no';
    }
} else if ($respuesta == "error") {
    $verificado = 'con error';
    $pago = 'duda';
} else {
    $verificado = 'no verificado';
    $pago = 'duda';
}

$modeloVenta = new ModeloVenta($bd);
$idVenta = (int) $itemname;
$venta = $modeloVenta->get($idVenta);
$venta->setPago($pago);
$rVenta = $modeloVenta->edit($venta);

if ($rVenta != 1) {
    $verificado = 'id no válida';
    $pago = 'duda';
}

$paypal = new Paypal(null, $idVenta, $verificado);
$modeloPaypal = new ModeloPaypal($bd);
$rPaypal = $modeloPaypal->add($paypal);

$idPaypal = $paypal->getIdPaypal();
$itemNamePaypal = $paypal->getItemname();
$verifivacionPaypal = $paypal->getVerificado();
$texto.="idVenta: $idVenta***rVenta: $rVenta***itemName: $itemname***Respuesta: $respuesta"
        . "***Verificado: $verificado***Pago: $pago***rPaypal: $rPaypal****idPaypal: $idPaypal"
        . "***itemNamePaypal:$itemNamePaypal***VerifivacionPaypal: $verifivacionPaypal"
        . "*****rPaypal: $rPaypal\n";

file_put_contents("log.txt", $texto, FILE_APPEND);
 $bd->closeConexion();
?>