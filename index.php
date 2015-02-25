<?php
require './require/comun.php';

$pagina = 0;
if (Leer::get("pagina") != null) {
    $pagina = Leer::get("pagina");
}
$bd = new BaseDatos();
$modelo = new ModeloProducto($bd);
$productos = $modelo->getList($pagina);
$paginas = $modelo->getNumeroPaginas();
$total = $modelo->count();
$enlaces = Paginacion::getEnlacesPaginacion($pagina, $total[0], Configuracion::RPP);
?>

<!DOCTYPE HTML>
<html>
    <head>
        <title>Tienda de Deportes</title>
        <link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
        <link href="css/style.css" rel='stylesheet' type='text/css' />
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
                        <img src="images/logo.png" title="barndlogo" />
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
                        <a href="carro.php" >
                            <div class="add-to-cart">
                                <ul class="unstyled-list list-inline">
                                    <li><span class="cart"> </span>

                                    </li>
                                </ul>
                            </div>
                        </a>
                        <div class="login-rigister">
                            <ul class="unstyled-list list-inline">
                                <li><a class="login" href="backEnd/index.php">Login</a>
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
                            <a href="#"><span> </span>ver todos los productos</a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <!----special-products-grids---->
                    <div class="special-products-grids">
                        <?php
                        foreach ($productos as $indice => $valor) {
                            ?>
                            <div class="col-md-3 special-products-grid text-center">
                                <a class="brand-name" href="#">
                                    <img src="images/b1.jpg" title="name" />
                                </a>
                                <a class="product-here" href="#">
                                    <img src="images/Imagenes/<?php echo $valor->getFoto(); ?>" title="product-name" />
                                </a>
                                <h4><a href="#"><?php echo $valor->getNombre(); ?></a></h4>                                
                                <a class="product-btn" href="./producto/phpcartadd.php?idProducto=<?php echo $valor->getIdProducto(); ?>"><span><?php echo $valor->getPrecio(); ?>&#8364;</span><small>A&ntilde;adir al Carrito</small></a>
                            </div> 
                            <?php
                        }
                        ?>
                        <div class="clearfix"></div>
                        <div id="paginacion">
                            <?php echo $enlaces["inicio"]; ?>
                            <?php echo $enlaces["anterior"]; ?>
                            <?php echo $enlaces["primero"]; ?>
                            <?php echo $enlaces["segundo"]; ?>
                            <?php echo $enlaces["actual"]; ?>
                            <?php echo $enlaces["cuarto"]; ?>
                            <?php echo $enlaces["quinto"]; ?>
                            <?php echo $enlaces["siguiente"]; ?>
                            <?php echo $enlaces["ultimo"]; ?>
                        </div>
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
                            <img src="images/flogo.png" title="brand-logo" />
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
<?php
$bd->closeConexion();
?>