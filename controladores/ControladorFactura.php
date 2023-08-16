<?php

namespace controladores;

use Dao\FacturaDao;
use Dao\IFacturaDao;
use modelos\Factura;

class ControladorFactura
{
    private IFacturaDao $iFacturaDao;

    public function __construct()
    {
        $this->iFacturaDao = new FacturaDao();
    }

    public function verFactura(int $id): ?Factura
    {
        return $this->iFacturaDao->verFactura($id);
    }

    public function generarFactura(Factura $factura): ?bool
    {
        return $this->iFacturaDao->generarFactura($factura);
    }


}