<?php

session_start();

if(!isset($_SESSION["usuario"]) || !isset($_SESSION["rol"])){
    header("Location: ../vistas/login.php?err=Credenciales%20invalidas");
}

echo "Hola ". $_SESSION["usuario"];