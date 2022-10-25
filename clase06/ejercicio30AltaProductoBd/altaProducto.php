<?php
include_once "./producto.php";

$newProduct = new Producto(0,$_POST['codigo'],$_POST['nombre'],$_POST['tipo'],$_POST['stock'],$_POST['precio'],date("Y,m,d"),date("Y,m,d"));

if($newProduct->getCode()!= null)
{
    echo $newProduct->addProduct() . "\n\n";
    echo Producto::showListProduct();
}
else
{
    echo "Datos ingresados invalidos revise";
}

?>