<?php
include_once "./producto.php";
include_once "./venta.php";
include_once "./usuario.php";
include_once "../../biblioteca/validaciones.php";
 class PetitionGet
 {
    public static function getListUsers()
    {
        //isset valida q no sea undifined
        if(isset($_GET['orden']) && $_GET['orden'] == "desc")
        {
            echo Usuario::obtenerListaUlUsuarios(1);
        }
        else
        {
            echo Usuario::obtenerListaUlUsuarios();
        }
        

    }

    public static function getListProd()
    {
        if(isset($_GET['orden']) && $_GET['orden'] == "desc")
        {
            echo Producto::showListProduct(1);
        }
        else
        {
            echo Producto::showListProduct();
        }
    }

    public static function getListSalesByAmount()
    {
        if(isset($_GET['min']) && isset($_GET['max']) && $_GET['min'] > -1 && $_GET['max'] > 0)
        {
            echo Sale::showSalesByAmount($_GET['min'],$_GET['max']);
        }
        else
        {
            echo "peticion  invalida";
        }
    }

    public static function getListSalesBetweenTwoDates()
    {
        if(isset($_GET['fechaInicio']) && isset($_GET['fechaFinal']) && Validar::validarFecha($_GET['fechaFinal']) && Validar::validarFecha($_GET['fechaFinal']))
        {
            echo Sale::showSalesBetweenTwoDates($_GET['fechaInicio'],$_GET['fechaFinal']);
        }
        else
        {
            echo "peticion  invalida";
        }
    }

    public static function getSalesWithUserAndProductName()
    {
        echo Sale::getSalesWithUserAndProductName();
    }


 }



?>