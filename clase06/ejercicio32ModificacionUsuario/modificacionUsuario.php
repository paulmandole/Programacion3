<?php

include_once "./usuario.php";

$mail = $_POST['mail'];
$claveVieja = $_POST['claveVieja'];
$claveNueva = $_POST['claveNueva'];
$nombre = $_POST['nombre'];

echo Usuario::verificarUsuario($mail,$claveVieja). "<br>";
echo Usuario::modificarUsuario($mail,$claveVieja,$claveNueva,$nombre)."<br>";


echo Usuario::obtenerListaUlUsuarios();


?>