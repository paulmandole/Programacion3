<?php

include_once "usuario.php";
include_once "manejadorDeArchivos.php";

$devolver = $_GET["lista"];

if(strcmp($devolver, "usuarios") == 0)
{
    echo Usuario::listaUsuarios();
}


?>