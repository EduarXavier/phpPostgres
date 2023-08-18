<?php

namespace controladores;

require_once("C:/xampp/htdocs/proyectosPhpStorm/phpConPostgreSql/Dao/IProductosDao.php");
require_once("C:/xampp/htdocs/proyectosPhpStorm/phpConPostgreSql/Dao/ProductoDao.php");
require_once("C:/xampp/htdocs/proyectosPhpStorm/phpConPostgreSql/modelos/Producto.php");

use Dao\IProductosDao;
use Dao\ProductoDao;
use modelos\Producto;

class ControladorProducto
{
    private IProductosDao $iProductosDao;

    public function __construct()
    {
        $this->iProductosDao = new ProductoDao();
    }

    public function verProducto(int $id): ?Producto
    {
        return $this->iProductosDao->verProducto($id);
    }

    public function verProductos(): ?array
    {
        return $this->iProductosDao->verProductos();
    }

    public function addProducto(Producto $producto): ?bool
    {
        return $this->iProductosDao->addProducto($producto);
    }

    public function actualizarProduto(Producto $producto): ?bool
    {
        return $this->iProductosDao->actualizarProduto($producto);
    }

}