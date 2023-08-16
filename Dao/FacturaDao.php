<?php

namespace Dao;

use Dao\Conexion;
use Dao\IFacturaDao;
use Dao\IProductosDao;
use Dao\ProductoDao;
use modelos\Factura;

class FacturaDao extends Conexion implements IFacturaDao
{
    private $pdo;
    private IProductosDao $iDaoProductos;

    public function __construct()
    {
        $this->pdo = $this->getConexion();
        $this->iDaoProductos = new ProductoDao();
    }

    public function verFactura(int $id): ?Factura
    {
        $sql = "SELECT * FROM ". TFACTURA;
        $statement = $this->pdo->prepare($sql);
        $resultados = $statement->execute();

        foreach ($resultados as $resultado){

            $factura = new Factura();
            $factura->setId($resultado[TFACTURAID]);
            $factura->setTotal($resultado[TFACTURATOTAL]);
            $factura->setDocuemntoPerosna($resultado[TFACTURADOCUMENTO]);

            $sqlP = "SELECT * FROM ". TPRODUCTOFACTURA . " WHERE " . TPFIDFACTURA . "=" . $id;
            $statementP = $this->pdo->prepare($sqlP);
            $productosFactura = $statementP->execute();
            $productos = array();

            foreach($productosFactura as $productoFactura)
            {
                $productos[] = $this->iDaoProductos->verProducto($productoFactura["id"]);
            }

            $factura->setProductos($productos);

            return $productos;

        }

        return null;

    }

    public function generarFactura(Factura $factura): ?bool
    {
        $productos = $factura->getProductos();
        $sql = "INSERT INTO ". TFACTURA . "("
            . TFACTURADOCUMENTO . ", " . TFACTURATOTAL
            . ") VALUES(:documento, :total)";
        $statement = $this->pdo->prepare($sql);

        $documento = $factura->getDocuemntoPerosna();
        $total = $factura->getTotal();
        $statement.bindParam(":documento", $documento);
        $statement.bindParam(":total", $total);

        if($statement->execute()){

            $sqlP = "SELECT * FROM ". TFACTURA;
            $statementP = $this->pdo->prepare($sqlP);
            $cantFactura = $statementP->execute();

            $codigo = count($cantFactura);

            foreach ($productos as $producto){
                $sqlPro = "INSER INTO ". TPRODUCTOFACTURA . "("
                    .TPFIDFACTURA. ", ".TPFIDPRODUCTO
                    ."VALUES (:factura, :producto)";

                $statementProducto = $this->pdo->prepare($sqlPro);
                $statementProducto.bindParam(":factura", $codigo);
                $statementProducto.bindParam(":producto", $producto->getId());

                $statementProducto->execute();
            }

        }
    }
}