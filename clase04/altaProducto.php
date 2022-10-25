<?php
include_once "producto.php";
include_once "lista.php";
include_once "manejadorDeArchivos.php";

$producto = new Producto(random_int(1,10000),$_POST["codigo"],$_POST["nombre"],$_POST["stock"],$_POST["precio"],$_POST["tipo"]);

//$lista = Lista::cargarLista();
$lista = new Lista($productos);





echo $lista->add($producto);
echo $lista->mostrarLista();


?>