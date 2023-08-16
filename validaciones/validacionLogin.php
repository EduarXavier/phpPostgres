<?php

use controladores\ControladorUsuario;
require_once("../controladores/ControladorUsuario.php");


if(!empty($_POST["usuario"]) && !empty($_POST["clave"]))
{
    $controladorPersona = new ControladorUsuario();

    $user = $_POST["usuario"];
    $clave = $_POST["clave"];
    $usuario = $controladorPersona->login($user, $clave);

    if($usuario)
    {
        session_start();
        $_SESSION["usuario"] = $usuario->getCorreo();
        $_SESSION["rol"] = $usuario->getRol();

        header("Location: ../vistas/persona/dashboard.php");
    }
    else
    {
        header("Location: ../vistas/login.php?err=Credenciales%20invalidas");
    }

}
else
{
    header("Location: ../vistas/login.php?err=Ingrese%20todos%20los%20datos");
}