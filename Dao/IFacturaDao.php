<?php

namespace Dao;

use modelos\Factura;

interface IFacturaDao
{
    public function verFactura(int $id): ?Factura;
    public function verFacturas(): ?array;
    public function verMisFacturas(string $documento): ?array;
    public function generarFactura(Factura $factura): ?int;
}