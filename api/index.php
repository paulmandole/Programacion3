<?php

    require_once "models/Cliente.php";

    switch($_SERVER['REQUEST_METHOD'])
    {
        case 'GET':
            if(isset($_GET['id']))
            {
                echo json_encode(Cliente::getWhere($_GET['id']));
            }
            else
            {
                echo json_encode(Cliente::getAll());
            } 
            break;
        case "POST":
            //agarra todo lo que recive en post
            $datos = json_decode(file_get_contents('php://input'));
            if($datos != null)
            {
                if(Cliente::insert($datos->nombre, $datos->ap, $datos->am, $datos->fn, $datos->genero))
                {
                    echo 'hola';
                    //codigo esta ok
                    http_response_code(200);
                }
                else
                {
                    //codigo error
                    http_response_code(400);
                }
            }
            else
            {
                //no esta el metodo
                http_response_code(405);
            }
            break;
        case 'PUT':
            //agarra todo lo que recive en post
            $datos = json_decode(file_get_contents('php://input'));
            if($datos != null)
            {
                if(Cliente::update($datos->id,$datos->nombre, $datos->ap, $datos->am, $datos->fn, $datos->genero))
                {
                    //codigo esta ok
                    http_response_code(200);
                }
                else
                {
                    //codigo error
                    http_response_code(400);
                }
            }
            else
            {
                //no esta el metodo
                http_response_code(405);
            }
            
            break;
        case 'DELETE':
            if(isset($_GET['id']))
            {
                if(Cliente::delete($_GET['id']))
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