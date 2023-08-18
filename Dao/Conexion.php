<?php

namespace Dao;

use PDO;
use PDOException;

require_once("constantes.php");

class Conexion
{

    public function getConexion()
    {

        try
        {
            $pdo = new PDO("pgsql:host=".HOST.";port=".PUERTO.";dbname=".DBNAME, USER, PASSWORD);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $pdo;
        }
        catch (PDOException $e)
        {
            echo "Error de conexión: " . $e->getMessage();
        }
    }

}
