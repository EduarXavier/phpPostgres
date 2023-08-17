<?php

require_once("../../controladores/ControladorProducto.php");

$nombrePagina = "Carrito";
include_once("../layouts/header.php");
include_once("../layouts/nav.php");

use controladores\ControladorProducto;

$controladorProducto = new ControladorProducto();
$carrito = true;
$productos = array();

if(isset($_SESSION["rol"]))
{
    if($_SESSION["rol"] != 2)
    {
        header("Location: ../persona/dashboard.php");
    }
}
else
{
    header("Location: ../login.php?err=Credenciales%20invalidas");
}


foreach ($_SESSION["carrito"] as $idProducto)
{

    $productoFind = $controladorProducto->verProducto($idProducto);
    $productos[] = $productoFind;

}

$cantProductos = count($_SESSION["carrito"]);


?>

<div class="container mt-3">

    <?php if($cantProductos == 0): ?>
        <h2
                style="text-align: center"
                class="mb-2"
        >
            No hay articulos en el carrito
        </h2>
    <?php endif ?>

    <?php if($cantProductos != 0): ?>
        <h2
                style="text-align: center"
                class="mb-2"
        >
            Cantidad de articulos: <?php echo $cantProductos?>
        </h2>
    <?php endif ?>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">

        <?php include_once("vistaProductos.php"); ?>

    </div>

    <?php if($cantProductos != 0): ?>
        <a
                href="../../validaciones/generarFactura.php"
                class="btn btn-primary w-50 mt-4"
                style="margin-left: 25%"
        >
            Generar Factura
        </a>
    <?php endif ?>

</div>

<?php include_once("../layouts/footer.php") ?>

