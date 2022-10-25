<?php
    include_once "api/validations/validaciones.php";
    include_once "api/models/hamburguesaCarga.php";
    include_once "api/models/altaVenta.php";
    include_once "api/models/borrarVenta.php";
    include_once "api/models/consultarVenta.php";
    include_once "api/models/modificarVenta.php";
    include_once "api/connections/accesoDatos.php";
    include_once "api/connections/archivosJson.php";
    include_once "api/models/haburguesaConsultar.php";
        
    switch($_SERVER['REQUEST_METHOD'])
    {
        case "GET":
            
            break;
        case "POST":

            switch($_POST['request'])
            {
                case 'HamburguesaCarga':
                    if(isset($_POST['nombre']) && isset($_POST['precio']) && isset($_POST['tipo']) && isset($_POST['cantidad']) && isset($_FILES['archivo']['name']) && Validar::validateFile($_FILES))
                    {
                        $hambueguesa = new HamburguesaCarga($_POST['nombre'],$_POST['precio'],$_POST['tipo'],$_POST['cantidad'],$_FILES['archivo']['tmp_name'],random_int(1000,10000));
                        if($hambueguesa->getId() != null)
                        {
                            echo $hambueguesa->addHamburguer();
                            http_response_code(200);
                        }
                        else
                        {
                            http_response_code(400);
                        }
                    }
                    else
                    {
                        http_response_code(400);
                    }
                    break;
                case 'HamburguesaConsultar':
                    if(isset($_POST['nombre']) && isset($_POST['tipo']))
                    {
                        
                    }
                    break;
                default:
                    http_response_code(405);
                    break;
            }
            
            break;
        case "PUT":

            break;
        case "DELETE":

            break;
        default:
            http_response_code(405);
            break;
    }


?>