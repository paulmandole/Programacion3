<?php
include_once "./venta.php";

$newSale = new Sale($_POST["idProducto"],$_POST["idUsuario"],$_POST["cantidad"]);

if($newSale->getIdProduct() != null)
{  
    echo $newSale->realizeSale() . "\n\n";
    echo Sale::showSales();
}
else
{
    echo "los datos ingresados son invalidos";
}

?>