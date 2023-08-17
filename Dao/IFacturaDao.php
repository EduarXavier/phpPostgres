<?php

namespace Dao;

use modelos\Factura;

interface IFacturaDao
{
    public function verFactura(int $id): ?Factura;
    public function generarFactura(Factura $factura): ?int;
}