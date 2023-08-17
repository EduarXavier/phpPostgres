<?php foreach ($productos as $producto): ?>

    <div class="col">
        <div class="card shadow-lg rounded">
            <div class="card-header bg-secondary text-white">
                <img src="<?php echo $producto->getImagen()?> " style="width: 100%">
            </div>
            <div class="card-body">
                <strong> Producto: </strong> <?php echo ucfirst($producto->getNombre()); ?>
                <p><strong>ID:</strong> <?php echo $producto->getId(); ?></p>
                <p><strong>Codigo:</strong> <?php echo $producto->getCodigo(); ?></p>
                <p><strong>Precio:</strong> <?php echo $producto->getPrecio(); ?></p>

                <?php if($_SESSION["rol"] == 1): ?>
                    <a href="verProducto.php?id=<?php echo $producto->getId(); ?>" class="btn btn-primary">Ver producto</a>
                <?php endif;?>

                <?php if($_SESSION["rol"] == 2 && $carrito == false): ?>

                    <a
                        class="btn btn-outline-primary mt-2"
                        style="width: 100%;"
                        href="../../validaciones/carrito.php?id=<?php echo $producto->getId()?>"
                    >
                        Añadir al carrito
                    </a>

                <?php endif;?>

            </div>
        </div>
    </div>

<?php endforeach; ?>