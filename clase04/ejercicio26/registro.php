<?php
include_once "usuario.php";
include_once "manejadorDeArchivos.php";
include_once "../biblioteca/validaciones.php";


$usuario = new Usuario(random_int(1,10000),$_POST["nombre"],$_POST["clave"],$_POST["mail"],date("d-m-Y"),ArchivosCsv::guardarFoto($_FILES["foto"]["name"]));




if(Usuario::guardarUsuario($usuario))
{
    echo "usuario cargado correctamente";
}

//echo $usuario->mostrarUsuario();
?>