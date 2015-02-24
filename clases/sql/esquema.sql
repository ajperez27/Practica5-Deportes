create database deportes default
character set utf8 collate utf8_unicode_ci;

grant all on deportes.* to
root@localhost identified by '';

flush privileges;

CREATE TABLE `producto` (
`idProducto` int(11) NOT NULL primary key auto_increment,
`nombre` varchar(30) NOT NULL,
`descripcion` varchar(250) NOT NULL,
`precio` decimal(6,2) NOT NULL,
`iva` decimal(5,2) NOT NULL,
`foto` varchar(30) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `usuario` (
`login` varchar(30) NOT NULL primary key,
`clave` varchar(40) NOT NULL,
`nombre` varchar(30) NOT NULL,
`apellidos` varchar(60) NOT NULL,
`email` varchar(40) NOT NULL,
`fechaalta` date NOT NULL,
`isactivo` tinyint(1) NOT NULL,
`isroot` tinyint(1) NOT NULL DEFAULT 0,
`rol` enum('administrador', 'usuario') NOT NULL DEFAULT 'usuario',
`fechalogin` datetime
) ENGINE=InnoDB;

CREATE TABLE `venta` (
`idVenta` int(11) NOT NULL primary key auto_increment,
`fecha` varchar(30) NOT NULL,
`hora` varchar(20) NOT NULL,
`pago` enum('si', 'no', 'duda') NOT NULL DEFAULT 'no',
`nombre` varchar (20) NOT NULL,
`direccion` varchar(50) NOT NULL,
`precio` decimal(8,2) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE `detalleVenta` (
`idDetalleVenta` int(11) NOT NULL primary key auto_increment,
`idVenta` int(11) NOT NULL,
`idProducto` int(11) NOT NULL,
`cantidad` int (11) NOT NULL,
`precio` decimal(7,2) NOT NULL,
`iva` decimal(5,2) NOT NULL,
CONSTRAINT FK_id_Venta FOREIGN KEY (idVenta) REFERENCES venta(idVenta),
CONSTRAINT FK_id_Producto FOREIGN KEY (idProducto) REFERENCES producto(idProducto)
) ENGINE=InnoDB;


CREATE TABLE `paypal` (
`idPaypal` int(11) NOT NULL primary key auto_increment,
`itemname` int(11) NOT NULL,
`verificado` varchar (30) NOT NULL DEFAULT 'no verificado'
) ENGINE=InnoDB;