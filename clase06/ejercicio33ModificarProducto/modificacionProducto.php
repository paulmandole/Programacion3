<?php

include_once "./producto.php";

$modProduct = new Producto(0,$_POST['codigo'],$_POST['nombre'],$_POST['tipo'],$_POST['stock'],$_POST['precio'],date("Y,m,d"),date("Y,m,d"));

if($modProduct->getCode() != null)
    echo $modProduct->modifyProduct();
    
echo Producto::showListProduct();





?>