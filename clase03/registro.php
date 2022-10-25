<?php
include_once "manejadorDeArchivos.php";
include_once "usuario.php";

$usuario = new Usuario($_POST["nombre"],$_POST["clave"],$_POST["mail"]);

if(Usuario::guardarUsuario($usuario))
{
    echo "usuario agregado correctamente";
}

echo $usuario->mostrarUsuario();






?>