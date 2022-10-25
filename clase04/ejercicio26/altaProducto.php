<?php
include_once "producto.php";
include_once "lista.php";
include_once "manejadorDeArchivos.php";
include_once "../biblioteca/validaciones.php";

$producto = new Producto(random_int(1,10000),$_POST["codigo"],$_POST["nombre"],$_POST["stock"],$_POST["precio"],$_POST["tipo"]);

$lista = Lista::cargarLista();




echo $lista->add($producto);
echo $lista->mostrarLista();


?>