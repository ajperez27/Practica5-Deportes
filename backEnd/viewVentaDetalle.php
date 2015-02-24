<?php
require '../require/comun.php';
$sesion->administrador("../index.php ");
$usuario = $sesion->getUsuario();
$idVenta = Leer::get("idVenta");

$pagina = 0;

if (Leer::get("pagina") != null) {
    $pagina = Leer::get("pagina");
}
$bd = new BaseDatos();
//$modeloVenta = new ModeloVenta($bd);
$modeloDetalleVenta = new ModeloDetalleVenta($bd);
$modeloProducto = new ModeloProducto($bd);
$detalleVenta = $modeloDetalleVenta->getList($pagina, Configuracion::RPP, "idVenta= $idVenta");

$precioTotal = 0;
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
                                <li><a class="login" href="#">Login</a>
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
                            <a href="../index.php"><span> </span>ver todos los productos</a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <!----special-products-grids---->
                    <div class="special-products-grids">
                        <br>
                        <h2>Bienvenido: <?php echo $usuario->getLogin(); ?> </h2>                        
                        <br>
                        <table border="1">
                            <thead>
                                <tr>
                                    <th>IdVenta</th>
                                    <th>IdDetalleVenta</th>
                                    <th>IdProducto</th>
                                    <th>Nombre</th>
                                    <th>Cantidad</th>
                                    <th>Precio</th>
                                    <th>Iva </th>
                                    <th>Total </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($detalleVenta as $indice => $venta) {
                                    //echo var_dump($venta);
                                    $producto = $modeloProducto->get($venta->getIdProducto());
                                    $precioTotal += $venta->getCantidad() * $venta->getPrecio();
                                    ?>
                                    <tr>
                                        <td> <?php echo $venta->getIdVenta(); ?></td>
                                        <td> <?php echo $venta->id; ?></td>
                                        <td> <?php echo $venta->getIdProducto(); ?></td>
                                        <td> <?php echo $producto->getNombre() ?></td>
                                        <td> <?php echo $venta->getCantidad(); ?></td>
                                        <td> <?php echo $venta->getPrecio(); ?>&euro;</td>
                                        <td> <?php echo $venta->getIva(); ?>%</td>
                                        <td> <?php echo $venta->getCantidad() * $venta->getPrecio(); ?>&euro;</td>                      
                                    </tr>  
                                    <?php
                                }
                                ?>
                                <tr>
                                    <td>TOTAL</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><?php echo $precioTotal; ?>&euro;</td>
                                </tr> 

                            </tbody>
                        </table>
                        <br>
                        <br>                        
                        <div class="add-cart-btn">
                            <a href="viewVentas.php"><input type="button" value="Volver   " /></a>
                        </div>
                        <br>
                        <br>
                        <div class="add-cart-btn">
                            <a href="phplogout.php"><input type="button" value="Salir" /></a>
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
                            <li><a href="#"> Contact</a> 
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