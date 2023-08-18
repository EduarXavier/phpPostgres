<?php

namespace Dao;

require_once("C:/xampp/htdocs/proyectosPhpStorm/phpConPostgreSql/Dao/IFacturaDao.php");
require_once("C:/xampp/htdocs/proyectosPhpStorm/phpConPostgreSql/Dao/ProductoDao.php");
require_once("C:/xampp/htdocs/proyectosPhpStorm/phpConPostgreSql/Dao/IProductosDao.php");
require_once("C:/xampp/htdocs/proyectosPhpStorm/phpConPostgreSql/Dao/Conexion.php");

use Dao\Conexion;
use Dao\IFacturaDao;
use Dao\IProductosDao;
use Dao\ProductoDao;
use modelos\Factura;
use PDO;

class FacturaDao extends Conexion implements IFacturaDao
{
    private ?PDO $pdo;
    private IProductosDao $iDaoProductos;

    public function __construct()
    {
        date_default_timezone_set('America/Bogota');
        $this->pdo = $this->getConexion();
        $this->iDaoProductos = new ProductoDao();
    }

    public function verFactura(int $id): ?Factura
    {
        $sql = "SELECT * FROM ". TFACTURA. " WHERE " . TFACTURAID . "=" . $id;

        $statement = $this->pdo->prepare($sql);
        $statement->execute();

        $resultados = $statement->fetchAll(PDO::FETCH_ASSOC);

        foreach ($resultados as $resultado)
        {
            $factura = new Factura();
            $factura->setId($resultado[TFACTURAID]);
            $factura->setTotal($resultado[TFACTURATOTAL]);
            $factura->setDocuemntoPerosna($resultado[TFACTURADOCUMENTO]);
            $factura->setFecha($resultado[TFACTURAFECHA]);

            $sqlP = "SELECT * FROM ". TPRODUCTOFACTURA . " WHERE " . TPFIDFACTURA . "=" . $id;

            $statementP = $this->pdo->prepare($sqlP);
            $statementP->execute();

            $productosFactura = $statementP->fetchAll(PDO::FETCH_ASSOC);

            $productos = array();

            foreach($productosFactura as $productoFactura)
            {
                $productos[] = $this->iDaoProductos->verProducto($productoFactura["idproducto"]);
            }

            $factura->setProductos($productos);

            return $factura;
        }

        return null;

    }

    public function verFacturas(): ?array
    {

        $sql = "SELECT * FROM ". TFACTURA . " ORDER BY " . TFACTURAFECHA . " DESC LIMIT 20";

        $statement = $this->pdo->prepare($sql);
        $statement->execute();

        $resultados = $statement->fetchAll(PDO::FETCH_ASSOC);

        $facturas = array();

        foreach ($resultados as $resultado)
        {
            $factura = new Factura();
            $factura->setId($resultado[TFACTURAID]);
            $factura->setTotal($resultado[TFACTURATOTAL]);
            $factura->setDocuemntoPerosna($resultado[TFACTURADOCUMENTO]);
            $factura->setFecha($resultado[TFACTURAFECHA]);

            $sqlP = "SELECT * FROM " . TPRODUCTOFACTURA . " WHERE " . TPFIDFACTURA . "=" . $factura->getId();

            $statementProducto = $this->pdo->prepare($sqlP);
            $statementProducto->execute();

            $productosFactura = $statementProducto->fetchAll(PDO::FETCH_ASSOC);

            $productos = array();

            foreach ($productosFactura as $productoFactura)
            {
                $productos[] = $this->iDaoProductos->verProducto($productoFactura["idproducto"]);
            }

            $factura->setProductos($productos);

            $facturas[] = $factura;
        }

        return $facturas;
    }

    public function verMisFacturas(string $documento): ?array{
        {
            $sql = "SELECT * FROM ". TFACTURA
                . " WHERE ".TFACTURADOCUMENTO . " = '" . $documento
                . "' ORDER BY " . TFACTURAFECHA
                . " DESC LIMIT 10";

            $statement = $this->pdo->prepare($sql);
            $statement->execute();

            $resultados = $statement->fetchAll(PDO::FETCH_ASSOC);

            $facturas = array();

            foreach ($resultados as $resultado)
            {
                $factura = new Factura();
                $factura->setId($resultado[TFACTURAID]);
                $factura->setTotal($resultado[TFACTURATOTAL]);
                $factura->setDocuemntoPerosna($resultado[TFACTURADOCUMENTO]);
                $factura->setFecha($resultado[TFACTURAFECHA]);

                $sqlP = "SELECT * FROM " . TPRODUCTOFACTURA . " WHERE " . TPFIDFACTURA . "=" . $factura->getId();

                $statementP = $this->pdo->prepare($sqlP);
                $statementP->execute();

                $productosFactura = $statementP->fetchAll(PDO::FETCH_ASSOC);

                $productos = array();

                foreach ($productosFactura as $productoFactura)
                {
                    $productos[] = $this->iDaoProductos->verProducto($productoFactura[TPFIDFACTURA]);
                }

                $factura->setProductos($productos);

                $facturas[] = $factura;
            }

            return $facturas;

        }
    }

    public function generarFactura(Factura $factura): ?int
    {
        $productos = $factura->getProductos();
        $documento = $factura->getDocuemntoPerosna();

        $total = $factura->getTotal();
        $fechaActual = date("Y-m-d H:i:s");

        $sql = "INSERT INTO ". TFACTURA . "("
            . TFACTURADOCUMENTO . ", "
            . TFACTURATOTAL. ", "
            .TFACTURAFECHA
            . ") VALUES("
            .$documento . ","
            . $total . ", '"
            .$fechaActual . "')";

        $statement = $this->pdo->prepare($sql);

        if($statement->execute())
        {
            $codigo = $this->pdo->lastInsertId();

            foreach ($productos as $producto)
            {
                $id = $producto->getId();

                $sqlPro = "INSERT INTO ". TPRODUCTOFACTURA . "("
                    .TPFIDFACTURA. ", "
                    .TPFIDPRODUCTO
                    .") VALUES ("
                    . $codigo. ","
                    . $id .")";

                $statementProducto = $this->pdo->prepare($sqlPro);
                $statementProducto->execute();
            }

            return $codigo;

        }

        return null;

    }
}