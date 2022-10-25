<?php

include_once "manejadorDeArchivos.php";
include_once "producto.php";
include_once "lista.php";
include_once "usuario.php";
include_once "ventas.php";
include_once "../biblioteca/validaciones.php";


$venta = new Venta($_POST["codigo"],$_POST["id"],$_POST["cantidad"]);


echo $venta->validarVenta()."\n\n";

echo Venta::mostrarVentas();




?>