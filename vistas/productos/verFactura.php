<?php

require_once("../../controladores/ControladorFactura.php");
require_once("../../controladores/ControladorUsuario.php");
require_once("../../modelos/Factura.php");

use controladores\ControladorFactura;
use controladores\ControladorUsuario;

$controladorFactura = new ControladorFactura();
$controladorUsuario = new ControladorUsuario();

$id = null;

if(!empty($_GET["id"]))
{
    $id = $_GET["id"];
}
else
{
    header("Location: ../perosna/dahsboard.php");
}

$factura = $controladorFactura->verFactura($id);
$usuarioFactura = $controladorUsuario->findByDocumento($factura?->getDocuemntoPerosna());
$nombrePagina = "Factura - ". $id;
include_once("../layouts/header.php");
include_once("../layouts/nav.php");
?>

<?php if(!$factura): ?>
    <h2 style="text-align: center">No extiste la factura <?php echo $id ?></h2>
<?php endif; ?>

<?php if($factura): ?>

    <h3 style="text-align: center" class="mt-3">Factura - <?php echo $id ?></h3>

    <div class="container mt-3">
        <h2>Datos del Cliente</h2>
        <table class="table table-bordered" style="width: 100%;">
            <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Documento</th>
                <th>Teléfono</th>
                <th>Email</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>1</td>
                <td><?php echo $usuarioFactura->getNombre(); ?></td>
                <td><?php echo $usuarioFactura->getDocumento(); ?></td>
                <td><?php echo $usuarioFactura->getTelefono(); ?></td>
                <td><?php echo $usuarioFactura->getCorreo(); ?></td>
            </tr>
            </tbody>
        </table>
        <h2>Productos</h2>

        <?php foreach ($factura->getProductos() as $producto): ?>

            <div class="media d-flex">
                <img src="<?php echo $producto->getImagen() ?>"
                     class="align-self-end  ml-3"
                     alt="Producto"
                     style="max-height: 150px; margin-right: 20px"
                >
                <div class="media-body text-right">
                    <h5 class="mt-0"><?php echo $producto->getnombre() ?></h5>
                    <p>ID: <?php echo $producto->getId() ?></p>
                    <p>Precio: $<?php echo $producto->getPrecio() ?></p>
                </div>
            </div>
        
        <?php endforeach; ?>
        <hr>
        <p style="font-size: 25px"><b>Total</b>: $<?php echo $factura?->getTotal(); ?></p>
    </div>

<?php endif; ?>


<?php include_once("../layouts/footer.php");?>