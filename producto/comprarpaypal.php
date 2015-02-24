<?php
require '../require/comun.php';

$cesta = array();
if (isset($_SESSION["__cesta"])) {
    $cesta = $_SESSION["__cesta"];
}

$bd = new BaseDatos();
$modeloProducto = new ModeloProducto($bd);
$modeloVenta = new ModeloVenta($bd);
$modeloDetalle = new ModeloDetalleVenta($bd);

$nombre = Leer::post("nombre");
$direccion = Leer::post("direccion");

date_default_timezone_set('Europe/Paris');
$fecha = date("d.m.y");
$hora = date("H:i:s");

$precioTotal = 0;
$precio = 0;

foreach ($cesta as $key => $detalleVenta) {
    $precioProducto = $modeloProducto->get($detalleVenta->getIdProducto())->getPrecio();
    $precio += $detalleVenta->getCantidad() * $precioProducto;
}
$precioTotal += $precio;

$venta = new Venta(null, $fecha, $hora, "no", $nombre, $direccion, $precioTotal);
$modeloVenta->add($venta);
$idVenta = $bd->getAutonumerico();

foreach ($cesta as $key => $detalleVenta) {
    $producto = $modeloProducto->get($detalleVenta->getIdProducto());
    $idProducto = $producto->getIdProducto();
    $cantidad = $detalleVenta->getCantidad();
    $precio = $producto->getPrecio();
    $iva = $producto->getIva();
    $detalle = new DetalleVenta(null, $idVenta, $idProducto, $cantidad, $precio, $iva);
    $modeloDetalle->add($detalle);
}

file_put_contents("../ventas/venta.txt", "Nombre: " . $nombre . "\n", FILE_APPEND);

foreach ($cesta as $key => $detalleVenta) {
    file_put_contents("../ventas/venta.txt", "Nombre: " . $modeloProducto->get($detalleVenta->getIdProducto())->getNombre() . " ", FILE_APPEND);
    file_put_contents("../ventas/venta.txt", "Precio: " . $modeloProducto->get($detalleVenta->getIdProducto())->getPrecio() . " ", FILE_APPEND);
    file_put_contents("../ventas/venta.txt", "Cantidad: " . $detalleVenta->getCantidad() . "\n", FILE_APPEND);
}
file_put_contents("../ventas/venta.txt", "\n idVenta: $idVenta  Total: $precioTotal \n", FILE_APPEND);
file_put_contents("../ventas/venta.txt", "\n ***************************** \n", FILE_APPEND);
session_destroy();
?>


<!DOCTYPE HTML>
<html>
    <head>
        <title>Tienda de Deportes</title>
        <link href="../css/bootstrap.css" rel='stylesheet' type='text/css' />
        <link href="../css/style.css" rel='stylesheet' type='text/css' />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!----webfonts--->
        <link href='http://fonts.googleapis.com/css?family=Lato:100,300,400,700,900,100italic,300italic,400italic,700italic,900italic' rel='stylesheet' type='text/css'>
        <!---//webfonts--->
    </head>

    <body>
        <!----container---->
        <div class="container">
            <!----top-header---->
            <div class="top-header">
                <div class="logo">
                    <a href="#">
                        <img src="../images/logo.png" title="barndlogo" />
                    </a>
                </div>
                <div class="top-header-info">
                    <div class="top-contact-info">
                        <ul class="unstyled-list list-inline">
                            <li><span class="phone"> </span>090 - 223 44 66</li>
                            <li><span class="mail"> </span><a href="#">help@trendd.com</a>
                            </li>
                            <div class="clearfix"></div>
                        </ul>
                    </div>
                    <div class="cart-details">
                        <a href="#" >
                            <div class="add-to-cart">
                                <ul class="unstyled-list list-inline">
                                    <li><span class="cart"> </span>

                                    </li>
                                </ul>
                            </div>
                        </a>
                        <div class="login-rigister">
                            <ul class="unstyled-list list-inline">
                                <li><a class="login" href="../backEnd/index.php">Login</a>
                                </li>
                                <li><a class="rigister" href="#">REGISTER <span> </span></a>
                                </li>
                                <div class="clearfix"></div>
                            </ul>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>

        <!----content---->
        <div class="content">
            <!---top-row--->
            <div class="container">
                <!----speical-products---->
                <div class="special-products">
                    <div class="s-products-head">
                        <div class="s-products-head-left">
                            <h3>SPECIAL <span>PRODUCTS</span></h3>
                        </div>
                        <div class="s-products-head-right">
                            <a href="../index.php"><span> </span>Ver todos los Productos</a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <!----special-products-grids---->
                    <div class="special-products-grids">
                        <h2>Verificar compra</h2>
                        <br/>
                        <form name="_xclick" method="post"
                              action="https://www.sandbox.paypal.com/cgi-bin/webscr" >
                            <input type="hidden" name="cmd" value="_xclick">
                            <input type="hidden" name="business" value="antoniop6000-facilitator@hotmail.com">
                            <input type="hidden" name="currency_code" value="EUR">
                            <input type="hidden" name="item_name" value="<?php echo $idVenta ?>">
                            <input type="hidden" name="amount" value="<?php echo $precioTotal ?>">
                            <input type="hidden" name="return" value="http://ajperez27.x10host.com/Practica5-Deportes/producto/gracias.php">
                            <input type="hidden" name="notify_url" value="http://ajperez27.x10host.com/Practica5-Deportes/producto/getpago.php">
                            <input type="image" border="0" name="submit"  src="http://www.paypal.com/es_ES/i/btn/btn_buynow_LG.gif" >
                        </form>     
                        <br/>
                        <br/>
                        <div class="add-cart-btn">
                            <a href="../index.php"><input type="button" value="Volver    " /></a>
                        </div> 
                        <div class="clearfix"></div>
                    </div>
                    <!---//special-products-grids---->
                </div>
                <!---//speical-products---->
            </div>
            <!----content---->
            <!----footer--->
            <div class="footer">
                <div class="container">
                    <div class="col-md-3 footer-logo">
                        <a href="#">
                            <img src="../images/flogo.png" title="brand-logo" />
                        </a>
                    </div>
                    <div class="col-md-7 footer-links">
                        <ul class="unstyled-list list-inline">
                            <li><a href="#"> Faq</a>  <span> </span>
                            </li>
                            <li><a href="#"> Terms and Conditions</a>  <span> </span>
                            </li>
                            <li><a href="#"> Secure Payments</a>  <span> </span>
                            </li>
                            <li><a href="#"> Shipping</a>  <span> </span>
                            </li>
                            <li><a href="contact.html"> Contact</a> 
                            </li>
                            <div class="clearfix"></div>
                        </ul>
                    </div>
                    <div class="col-md-2 footer-social">
                        <ul class="unstyled-list list-inline">
                            <li><a class="pin" href="#"><span> </span></a>
                            </li>
                            <li><a class="twitter" href="#"><span> </span></a>
                            </li>
                            <li><a class="facebook" href="#"><span> </span></a>
                            </li>
                            <div class="clearfix"></div>
                        </ul>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="clearfix"></div>
            <!---//footer--->
            <!---copy-right--->
            <div class="copy-right">
                <div class="container">
                    <p>Template by <a href="http://w3layouts.com/">W3layouts</a>
                    </p>   
                    <a href="#" id="toTop" style="display: block;"> <span id="toTopHover" style="opacity: 1;"> </span>
                    </a>
                </div>
            </div>
            <!--//copy-right--->
        </div>
        <!----container---->
    </body>
</html>