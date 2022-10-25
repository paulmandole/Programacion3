<?php
include_once "./pizza.php";
include_once "./altaVenta.php";
include_once "./borrarVenta.php";
include_once "./consultasVentas.php";
include_once "../../biblioteca/accesoDatos.php";
include_once "../../biblioteca/validaciones.php";



switch($_SERVER['REQUEST_METHOD'])
{
    case 'POST':
        if(isset($_POST['consulta']))
        {
            switch($_POST['consulta'])
            {
                case "cargaPizza":
                    if(isset($_POST['sabor']) && isset($_POST['precio']) && isset($_POST['tipo']) && isset($_POST['cantidad']) && isset($_FILES['archivo']['name']) && Validar::validateFile($_FILES))
                    {
                        $newPizza = new Pizza($_POST['sabor'],$_POST['precio'],$_POST['tipo'],$_POST['cantidad'],random_int(1000,10000),$_FILES['archivo']['tmp_name']);
                        if($newPizza->getId() != null)
                        {
                            echo $newPizza->savePizza();
                        }
                        else
                        {
                            echo "datos invalidos";
                        }
                    }

                    break;
                case 'pizzaCarga':
                    if(isset($_POST['sabor']) && isset($_POST['tipo']))
                    {
                        echo Pizza::therePizza($_POST['sabor'],$_POST['tipo']);
                    }
                    break;
                case 'altaVenta':
                    
                    
                    if(isset($_POST['email']) && isset($_POST['sabor']) && isset($_POST['tipo']) && isset($_POST['cantidad']) && isset($_FILES["archivo"]["name"]) &&   Validar::validateFile($_FILES))
                    {
                        $newSale = new Sale($_POST['email'],$_POST['sabor'],$_POST['tipo'],$_POST['cantidad'],date("Y,m,d"),random_int(1000,10000),0,$_FILES["archivo"]["tmp_name"]);
                        
                        if($newSale->getMail() != null)
                        {
                            echo $newSale->saveSale();
                        }
                    }
                    else
                    {
                        echo "Datos Invalidos";
                    }
                    break;
                default:
                    echo "consulta invalida";
                    break;
            }
        }
        else
        {
            echo "consulta invalida";
        }
        break;


    case 'GET':

        switch($_GET['consulta'])
        {
            case "cargaPizza":
                if(isset($_GET['sabor']) && isset($_GET['precio']) && isset($_GET['tipo']) && isset($_GET['cantidad']))
                {
                    $newPizza = new Pizza($_GET['sabor'],$_GET['precio'],$_GET['tipo'],$_GET['cantidad'],random_int(1000,10000));
                    if($newPizza->getId() != null)
                    {
                        echo $newPizza->savePizza();
                    }
                    else
                    {
                        echo "datos invalidos";
                    }
                }
                break;

            case "cantidadPizzasVendidas":
                echo ConsultationSale::getAmountPizzasSales();
                break;

            case "ventasEntreDosFechas":
                if(isset($_GET['date1']) && isset($_GET['date2']) && Validar::validarFecha($_GET['date1']) && Validar::validarFecha($_GET['date2']))
                {
                    echo ConsultationSale::getSalesBetweenTwoDates($_GET['date1'],$_GET['date2']);
                }
                else
                {
                    echo "datos invalidos";
                }
                break;

            case "ventasPorUsuario":
                if(isset($_GET['user']) && Validar::validarMail($_GET['user']))
                {
                    echo ConsultationSale::getSalesByUser($_GET['user']);
                }
                else
                {
                    echo "Datos invalidos";
                }
                break;
            case "ventasPorSabor":
                if(isset($_GET['sabor']))
                {
                    echo ConsultationSale::getSalesBySabor($_GET['sabor']);
                }
                else
                {
                    echo "Datos invalidos";
                }
                break;
            default:
                break;
        }
        break;
    case "PUT":
        
        if(isset($_GET['pedido']) && isset($_GET['mail']) && isset($_GET['sabor']) && isset($_GET['tipo']))
        {
            if(Sale::updateSale($_GET['pedido'],$_GET['tipo'],$_GET['mail'],$_GET['sabor']))
            {
                http_response_code(200);
            }
            else
            {
                http_response_code(400);
            }

        }
        else
        {
            http_response_code(405);
        }
        
        
        break;

    case "DELETE":
        if(isset($_GET['pedido']))
        {
           
            if(DeleteSale::delete($_GET['pedido']))
            {
                http_response_code(200);
            }
            else
            {
                http_response_code(400);
            }
        }
        else
        {
            http_response_code(405);
        }
        break;
    default:
        http_response_code(405);
        break;
}

?>