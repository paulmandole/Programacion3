<?php
include_once "./usuario.php";

$listadoAObtener = $_GET["listado"];

if($listadoAObtener == "usuarios")
    echo Usuario::obtenerListaUlUsuarios();

?>