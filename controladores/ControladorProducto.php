<?php

namespace controladores;

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
        return $this->verProducto($id);
    }
    public function verProductos(): ?array
    {
        return $this->verProductos();
    }
    public function addProducto(Producto $producto): ?bool
    {
        return $this->addProducto($producto);
    }
    public function actualizarProduto(Producto $producto): ?bool
    {
        return $this->actualizarProduto($producto);
    }
}