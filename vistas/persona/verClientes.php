<?php
require_once("../../controladores/ControladorUsuario.php");

use controladores\ControladorUsuario;

$controladorUsuario = new ControladorUsuario();
$clientes = $controladorUsuario->verClientes();

$nombrePagina = "Clientes";
include_once("../../layouts/header.php");
?>


