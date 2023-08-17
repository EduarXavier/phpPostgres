<?php

namespace modelos;


class Factura
{
    private int $id;
    private string $docuemntoPerosna;
    private int $total;
    private array $productos;

    public function __construct()
    {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getDocuemntoPerosna(): string
    {
        return $this->docuemntoPerosna;
    }

    public function setDocuemntoPerosna(string $docuemntoPerosna): void
    {
        $this->docuemntoPerosna = $docuemntoPerosna;
    }

    public function getTotal(): int
    {
        return $this->total;
    }

    public function setTotal(int $total): void
    {
        $this->total = $total;
    }

    public function getProductos(): array
    {
        return $this->productos;
    }

    public function setProductos(array $productos): void
    {
        $this->productos = $productos;
    }

    public function addProductos(Producto $producto)
    {
        $this->productos[] = $producto;
    }


}