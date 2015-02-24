<?php
require '../require/comun.php';

$bd = new BaseDatos();
$modelo = new ModeloProducto($bd);

$total = 0;
if (isset($_SESSION["__cesta"])) {
    $cesta = $_SESSION["__cesta"];
    if (sizeof($cesta) == 0) {
        header("Location: ../index.php");
    }
} else {
    header("Location: ../index.php");
}
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
                        <a href="../carro.php" >
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
                            <a href="../index.php"><span> </span>ver todos los Productos</a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <!----special-products-grids---->
                    <div class="special-products-grids">                   
                        <h2>Contenido de la cesta</h2>
                        <br/>
                        <table border="1">
                            <thead>
                                <tr>
                                    <th> Foto </th>
                                    <th> Nombre </th>
                                    <th> Precio sin Iva </th>
                                    <th> Iva </th>
                                    <th> Total Unitario </th>
                                    <th> Cantidad </th>                               
                                </tr>
                            </thead>
                            <?php
                            if (isset($_SESSION["__cesta"])) {
                                $cesta = $_SESSION["__cesta"];
                                ?> 
                                <tbody>
                                    <?php
                                    foreach ($cesta as $key => $detalleVenta) {
                                        $producto = $modelo->get($detalleVenta->getIdProducto());
                                        $total+=$producto->getPrecio() * $detalleVenta->getCantidad();
                                        ?>
                                        <tr>
                                            <td><img width="50%" src="../images/Imagenes/<?php echo $producto->getFoto(); ?>" title="barndlogo" /></td>
                                            <td><?php echo $producto->getNombre(); ?></td>

                                            <td><?php echo round($producto->getPrecio() / (1 + $producto->getIva() / 100), 2); ?>&euro;</td>
                                            <td><?php echo round($producto->getPrecio() / (1 + $producto->getIva() / 100) * $producto->getIva() / 100, 2); ?>&euro;</td>


                                            <td><?php echo $producto->getPrecio(); ?>&euro;</td>
                                            <td><?php echo $detalleVenta->getCantidad(); ?></td>
                                            <td>
                                                <a href="phpcartadd.php?idProducto=<?php echo $producto->getIdProducto(); ?>&destino=comprar"> A&ntilde;adir</a> 
                                            </td>
                                            <td>
                                                <a href="phpcartsup.php?idProducto=<?php echo $producto->getIdProducto(); ?>&destino=comprar">Restar</a>

                                            </td>
                                            <td>
                                                <a href="phpcartdel.php?idProducto=<?php echo $producto->getIdProducto(); ?>&destino=comprar">Eliminar</a>

                                            </td>
                                        </tr>                                      

                                        <?php
                                    }
                                    ?>
                                    <tr>
                                        <td>Total</td>
                                        <td></td>
                                        <td><?php echo round($total / (1 + $producto->getIva() / 100), 2); ?>&euro;</td>
                                        <td><?php echo round($total / (1 + $producto->getIva() / 100) * $producto->getIva() / 100, 2); ?>&euro;</td>
                                        <td><?php echo $total; ?>&euro;</td>
                                    </tr>
                                </tbody>
                                <?php
                            }
                            ?>
                        </table>
                        <h2>
                            Datos:
                        </h2>
                        <hr>
                        <br/>
                        <form method="POST" action="comprarpaypal.php">
                            <label>Nombre:</label>
                            <input type="text" name="nombre" value="" required />
                            <br/>
                            <br/>
                            <label>Direcci&oacute;n:</label>
                            <input type="text" name="direccion" value="" required/>
                            <br/>
                            <br/>
                            <input type="submit" value="Pagar" />
                        </form>

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