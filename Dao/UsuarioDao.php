<?php

namespace Dao;

require_once("C:/xampp/htdocs/proyectosPhpStorm/phpConPostgreSql/Dao/IUsuarioDao.php");
require_once("C:/xampp/htdocs/proyectosPhpStorm/phpConPostgreSql/Dao/Conexion.php");

use modelos\Persona;
use Exception;
use PDO;

class UsuarioDao extends Conexion implements IUsuarioDao
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = $this->getConexion();
    }

    public function verUsuario(int $id): ?Persona
    {
        $sql = "SELECT * FROM ". TPERSONA . " WHERE " . TPERSONAID . " = " . $id;

        $statement = $this->pdo->prepare($sql);
        $statement->execute();

        $resultados = $statement->fetchAll(PDO::FETCH_ASSOC);

        if($resultados){

            foreach($resultados as $resultado)
            {
                $usuario = new Persona();
                $usuario->setId($resultado[TPERSONAID]);
                $usuario->setNombre($resultado[TPERSONANOMBRE]);
                $usuario->setTelefono($resultado[TPERSONATELEFONO]);
                $usuario->setCorreo($resultado[TPERSONACORREO]);
                $usuario->setRol($resultado[TPERSONAROL]);
                $usuario->setDireccion($resultado[TPERSONADIRECCION]);
                $usuario->setDocumento($resultado[TPERSONADOCUMENTO]);
                $usuario->setPassword($resultado[TPERSONAPASSWORD]);


                return $usuario;
            }

        }

        return null;

    }

    public function findByDocumento(?string $documento): ?Persona
    {
        $sql = "SELECT * FROM ". TPERSONA . " WHERE " . TPERSONADOCUMENTO . " = '" . $documento . "'";

        $statement = $this->pdo->prepare($sql);
        $statement->execute();

        $resultados = $statement->fetchAll(PDO::FETCH_ASSOC);

        if($resultados){

            foreach($resultados as $resultado)
            {
                $usuario = new Persona();
                $usuario->setId($resultado[TPERSONAID]);
                $usuario->setNombre($resultado[TPERSONANOMBRE]);
                $usuario->setTelefono($resultado[TPERSONATELEFONO]);
                $usuario->setCorreo($resultado[TPERSONACORREO]);
                $usuario->setRol($resultado[TPERSONAROL]);
                $usuario->setDireccion($resultado[TPERSONADIRECCION]);
                $usuario->setDocumento($resultado[TPERSONADOCUMENTO]);
                $usuario->setPassword($resultado[TPERSONAPASSWORD]);


                return $usuario;
            }

        }

        return null;

    }

    public function verUsuarios(): ?array
    {
        $sql = "SELECT * FROM ". TPERSONA. " LIMIT 100";
        $statement = $this->pdo->prepare($sql);
        $statement->execute();
        $usuarios = array();
        $resultados = $statement->fetchAll(PDO::FETCH_ASSOC);

        foreach ($resultados as $resultado){
            $usuario = new Persona();
            $usuario->setId($resultado[TPERSONAID]);
            $usuario->setNombre($resultado[TPERSONANOMBRE]);
            $usuario->setTelefono($resultado[TPERSONATELEFONO]);
            $usuario->setCorreo($resultado[TPERSONACORREO]);
            $usuario->setRol($resultado[TPERSONAROL]);
            $usuario->setDireccion($resultado[TPERSONADIRECCION]);
            $usuario->setDocumento($resultado[TPERSONADOCUMENTO]);
            $usuario->setPassword($resultado[TPERSONAPASSWORD]);

            $usuarios[] = $usuario;
        }

        return $usuarios;

    }

    public function addUsuario(Persona $usuario): ?bool
    {
        $sql = "INSERT INTO " .TPERSONA . "("
            .TPERSONANOMBRE.", ".TPERSONATELEFONO. ", "
            .TPERSONACORREO.", ".TPERSONADIRECCION. ", "
            .TPERSONADOCUMENTO.", ".TPERSONAROL .","
            .TPERSONAPASSWORD .") VALUES(:nombre, :telefono, :correo, "
            .":direccion, :documento, :rol, :password)";

        $statement = $this->pdo->prepare($sql);
        $nombre = $usuario->getNombre();
        $telefono = $usuario->getTelefono();
        $correo = $usuario->getCorreo();
        $direccion = $usuario->getDireccion();
        $documento = $usuario->getDocumento();
        $password = password_hash($usuario->getPassword(), PASSWORD_DEFAULT);
        $rol = $usuario->getRol();

        $statement->bindParam(':nombre',$nombre);
        $statement->bindParam(':telefono',$telefono);
        $statement->bindParam(':correo',$correo);
        $statement->bindParam(':direccion',$direccion);
        $statement->bindParam(':documento',$documento);
        $statement->bindParam(':rol',$rol);
        $statement->bindParam(':password',$password);

        return $statement->execute();

    }

    public function actualizarUsuario(Persona $usuario): ?bool
    {
        $findUser = $this->verUsuario($usuario->getId());

        if($findUser)
        {

            $sql = "UPDATE " .TPERSONA . " SET "
                .TPERSONANOMBRE."= :nombre, "
                .TPERSONATELEFONO. "= :telefono, "
                .TPERSONACORREO."= :correo, "
                .TPERSONADIRECCION. "= :direccion, "
                .TPERSONADOCUMENTO."= :documento,"
                .TPERSONAPASSWORD ."= :password WHERE "
                .TPERSONAID . "= :id ";

            $statement = $this->pdo->prepare($sql);
            $nombre = $usuario->getNombre() ?? $findUser->getNombre();
            $telefono = $usuario->getTelefono() ?? $findUser->getTelefono();
            $correo = $usuario->getCorreo() ?? $findUser->getCorreo();
            $direccion = $usuario->getDireccion() ?? $findUser->getDireccion();
            $documento = $usuario->getDocumento() ?? $findUser->getDocumento();
            $password = $usuario->getPassword() ?
                password_hash($usuario->getPassword(), PASSWORD_DEFAULT)
                :
                $findUser->getPassword();

            $id = $findUser->getId();

            $statement->bindParam(':nombre',$nombre);
            $statement->bindParam(':telefono',$telefono);
            $statement->bindParam(':correo', $correo);
            $statement->bindParam(':direccion', $direccion);
            $statement->bindParam(':documento', $documento);
            $statement->bindParam(':password',$password);

            $statement->bindParam(':id', $id);

            return $statement->execute();
        }
        else{
            throw new Exception("El usuario no ha sido encontrado");
        }

    }

    public function eliminarUsuario(int $id): ?bool
    {
        $findUser = $this->verUsuario($id);

        if($findUser)
        {
            $sql = "DELETE FROM ". TPERSONA . " WHERE " . TPERSONAID . " = " . $id;
            $statement = $this->pdo->prepare($sql);

            return $statement->execute();

        }
        else{
            throw new Exception("El usuario no ha sido encontrado");
        }
    }

    public function verClientes(): ?array
    {
        $sql = "SELECT * FROM ". TPERSONA . " WHERE " . TPERSONAROL . " = 2 LIMIT 100";
        $statement = $this->pdo->prepare($sql);
        $statement->execute();
        $usuarios = array();
        $resultados = $statement->fetchAll(PDO::FETCH_ASSOC);

        foreach ($resultados as $resultado){
            $usuario = new Persona();
            $usuario->setId($resultado[TPERSONAID]);
            $usuario->setNombre($resultado[TPERSONANOMBRE]);
            $usuario->setTelefono($resultado[TPERSONATELEFONO]);
            $usuario->setCorreo($resultado[TPERSONACORREO]);
            $usuario->setRol($resultado[TPERSONAROL]);
            $usuario->setDireccion($resultado[TPERSONADIRECCION]);
            $usuario->setDocumento($resultado[TPERSONADOCUMENTO]);
            $usuario->setPassword($resultado[TPERSONAPASSWORD]);
            $usuarios[] = $usuario;
        }

        return $usuarios;
    }

    public function login(string $correo, string $clave): ?Persona
    {
        $sql = "SELECT * FROM ". TPERSONA . " WHERE "
            .TPERSONACORREO . " = '" . $correo ."'" ;

        $statement = $this->pdo->prepare($sql);
        $statement->execute();

        $resultados = $statement->fetchAll(PDO::FETCH_ASSOC);

        if($resultados){

            foreach($resultados as $resultado)
            {
                $usuario = new Persona();
                $usuario->setId($resultado[TPERSONAID]);
                $usuario->setNombre($resultado[TPERSONANOMBRE]);
                $usuario->setTelefono($resultado[TPERSONATELEFONO]);
                $usuario->setCorreo($resultado[TPERSONACORREO]);
                $usuario->setRol($resultado[TPERSONAROL]);
                $usuario->setDireccion($resultado[TPERSONADIRECCION]);
                $usuario->setDocumento($resultado[TPERSONADOCUMENTO]);
                $usuario->setPassword($resultado[TPERSONAPASSWORD]);

                if(password_verify($clave, $usuario->getPassword())){
                    return $usuario;
                }
            }

        }

        return null;
    }
}