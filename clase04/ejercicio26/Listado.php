<?php

include_once "usuario.php";
include_once "lista.php";
include_once "manejadorDeArchivos.php";
include_once "../biblioteca/validaciones.php";

$devolver = $_GET["lista"];

if(strcmp($devolver, "usuarios") == 0)
{
    echo Usuario::listaUsuarios();
}


?>