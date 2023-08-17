<?php
session_start();

use controladores\ControladorFactura;
use controladores\ControladorUsuario;
use modelos\Producto;
use modelos\Factura;
use controladores\ControladorProducto;

require_once("../controladores/ControladorUsuario.php");
require_once("../controladores/ControladorProducto.php");
require_once("../controladores/ControladorFactura.php");
require_once("../modelos/Producto.php");
require_once("../modelos/Factura.php");

$controladorProducto = new ControladorProducto();
$controladorPersona = new ControladorUsuario();
$controladorFactura = new ControladorFactura();

if(!isset($_SESSION["usuario"]) ||
    !isset($_SESSION["rol"]) ||
    !isset($_SESSION["id"]) ||
    $_SESSION["rol"] != 2)
{
    header("Location: ../vistas/login.php?err=Credenciales%20invalidas");
    exit();
}

if(count($_SESSION["carrito"]) == 0)
{
    header("Location: ../vistas/productos/carrito.php");
    exit();
}

$usuario = $controladorPersona->verUsuario($_SESSION["id"]);
$documento = $usuario->getDocumento();
$productos = array();
$total = 0;

foreach ($_SESSION["carrito"] as $producto)
{
    $productoFactura = $controladorProducto->verProducto($producto);
    $total += $productoFactura->getPrecio();
    $productos[] = $productoFactura;
}

$factura = new Factura();

$factura->setTotal($total);
$factura->setDocuemntoPerosna($documento);
$factura->setProductos($productos);

$id = $controladorFactura->generarFactura($factura);
var_dump($id);

if($id)
{
    $_SESSION["carrito"] = array();
    header("Location: ../vistas/productos/verFactura.php?id=$id");
    exit();
}


