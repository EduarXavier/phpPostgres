<?php

namespace Dao;

require_once("C:/xampp/htdocs/proyectosPhpStorm/phpConPostgreSql/Dao/IProductosDao.php");
require_once("C:/xampp/htdocs/proyectosPhpStorm/phpConPostgreSql/Dao/Conexion.php");

use modelos\Producto;
use PDO;

class ProductoDao extends Conexion implements IProductosDao
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = $this->getConexion();
    }

    public function verProducto(int $id): ?Producto
    {
        $sql = "SELECT * FROM ". TPRODUCTO . " WHERE " . TPRODUCTOID . " = " . $id;

        $statement = $this->pdo->prepare($sql);
        $statement->execute();

        $resultados = $statement->fetchAll(PDO::FETCH_ASSOC);

        if($resultados)
        {
            foreach ($resultados as $resultado){
                $producto = new Producto();
                $producto->setId($id);
                $producto->setNombre($resultado["nombre"]);
                $producto->setCodigo($resultado["codigo"]);
                $producto->setImagen($resultado["imagen"]);
                $producto->setPrecio($resultado["precio"]);

                return $producto;
            }
        }

        return null;
    }

    public function verProductos(): ?array
    {
        $sql = "SELECT * FROM ". TPRODUCTO;
        $statement = $this->pdo->prepare($sql);
        $statement->execute();
        $productos = array();
        $resultados = $statement->fetchAll(PDO::FETCH_ASSOC);

        foreach ($resultados as $resultado){
            $producto = new Producto();
            $producto->setId($resultado["id"]);
            $producto->setNombre($resultado["nombre"]);
            $producto->setCodigo($resultado["codigo"]);
            $producto->setImagen($resultado["imagen"]);
            $producto->setPrecio($resultado["precio"]);
            $productos[] = $producto;
        }

        return $productos;
    }

    public function addProducto(Producto $producto): ?bool
    {
        $sql = "INSERT INTO " .TPRODUCTO . "("
            .TPRODUCTOCODIGO. ", " .TPRODUCTOIMAGEN. ", "
            .TPRODUCTOPRECIO.", ". TPRODUCTONOMBRE
            .") VALUES(:codigo, :imagen, :precio, :nombre)";

        $statement = $this->pdo->prepare($sql);
        $nombre = $producto->getNombre();
        $codigo = $producto->getCodigo();
        $imagen = $producto->getImagen();
        $precio = $producto->getPrecio();


        $statement->bindParam(':codigo',$codigo);
        $statement->bindParam(':imagen',$imagen);
        $statement->bindParam(':precio',$precio);
        $statement->bindParam(':nombre',$nombre);

        return $statement->execute();

    }

    public function actualizarProduto(Producto $producto): ?bool
    {
        $findProducto = $this->verProducto($producto->getId());

        if($findProducto)
        {

            $sql = "UPDATE" .TPRODUCTO . " SET "
                .TPRODUCTOCODIGO. "= :codigo, "
                .TPRODUCTOIMAGEN. "= :imagen, "
                .TPRODUCTOPRECIO. "= :precio "
                .TPRODUCTONOMBRE. "= :nombre WHERE"
                .TPRODUCTOID . "= :id";

            $statement = $this->pdo->prepare($sql);
            $nombre = $producto->getNombre() ?? $findProducto->getNombre();
            $codigo = $producto->getCodigo() ?? $findProducto->getCodigo();
            $imagen = $producto->getImagen() ?? $findProducto->getImagen();
            $precio = $producto->getPrecio() ?? $findProducto->getPrecio();
            $id = $findProducto->getId();

            $statement->bindParam(':nombre',$nombre);
            $statement->bindParam(':codigo',$codigo);
            $statement->bindParam(':imagen',$imagen);
            $statement->bindParam(':precio',$precio);
            $statement->bindParam(':id', $id);

            return $statement->execute();
        }
        else{
            throw new Exception("El producto no ha sido encontrado");
        }
    }
}