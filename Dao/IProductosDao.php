<?php

namespace Dao;

use modelos\Producto;

interface IProductosDao
{
    public function verProducto(int $id): ?Producto;
    public function verProductos(): ?array;
    public function addProducto(Producto $producto): ?bool;
    public function actualizarProduto(Producto $producto): ?bool;
}