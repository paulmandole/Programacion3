<?php
include_once "./peticionPost.php";
include_once "./peticionGet.php";

switch($_SERVER['REQUEST_METHOD'])
{
    case "POST":

        switch($_POST['peticion'])
        {
            case "modificarUsuario":
                PetitionPost::modifyUser();
                break;
            case "modificarProducto":
                PetitionPost::modifyProduct();
                break;
            case "realizarVenta":
                PetitionPost::realizeSale();
                break;
            case "registroUsuario":
                PetitionPost::registrationUser();
                break;
            case "altaProducto":
                PetitionPost::highProduct();
                break;
            case "login":
                PetitionPost::loginUser();
                break;
            default:
                echo "Peticion Invalida";
                break;
        }

        break;

    case "GET":
        switch($_GET['listado'])
        {
            case "usuarios":
                PetitionGet::getListUsers();
                break;
            case "productos":
                PetitionGet::getListProd();
                break;
            case "ventasEntreFechas":
                PetitionGet::getListSalesBetweenTwoDates();
                break;
            case "ventasEntreCantidades":
                PetitionGet::getListSalesByAmount();
                break;
            case "listaVentas":
                PetitionGet::getSalesWithUserAndProductName();
                break;
            default:
                echo "listado invalido";
                break;
        }
        break;
    default:
        echo "Peticion Invalida";
    break;
}

?>