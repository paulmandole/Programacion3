<?php
include_once "./usuario.php";
$usuario = new Usuario($_POST['nombre'],$_POST['apellido'],$_POST['mail'],$_POST['localidad'],"2022/9/28",$_POST['clave']);

echo $usuario->guardarUsuario();

?>