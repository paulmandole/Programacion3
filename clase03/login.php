<?php
include_once "manejadorDeArchivos.php";
include_once "usuario.php";

$usuario =  new Usuario($_POST["nombre"],$_POST["clave"],$_POST["mail"]);
$usuario2 = new Usuario("juan","12345","rene@gmail.com");
//echo $usuario->mostrarUsuario();

echo $usuario->autentificacion();



?>