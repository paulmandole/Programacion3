<?php
include_once "./producto.php";
include_once "./venta.php";
include_once "./usuario.php";
class PetitionPost
{
    public static function modifyUser()
    {

        if(isset($_POST['mail'])  && isset($_POST['claveNueva']) && isset($_POST['claveVieja']) && isset($_POST['nombre']))
        {
            $mail = $_POST['mail'];
            $claveVieja = $_POST['claveVieja'];
            $claveNueva = $_POST['claveNueva'];
            $nombre = $_POST['nombre'];
            echo Usuario::verificarUsuario($mail,$claveVieja). "<br>";
            echo Usuario::modificarUsuario($mail,$claveVieja,$claveNueva,$nombre)."<br>";
        }
        else
        {
            echo "DATOS INVALIDOS";
        }
       
    }

    public static function modifyProduct()
    {

        if(isset($_POST['codigo'])  && isset($_POST['tipo']) && isset($_POST['stock']) && isset($_POST['precio']))
        {
            $modProduct = new Producto(0,$_POST['codigo'],$_POST['nombre'],$_POST['tipo'],$_POST['stock'],$_POST['precio'],date("Y,m,d"),date("Y,m,d"));
            echo $modProduct->modifyProduct();
        }
        else
        {
            echo "DATOS INVALIDOS";   
        }
    }

    public static function realizeSale()
    {
        $newSale = new Sale($_POST["idProducto"],$_POST["idUsuario"],$_POST["cantidad"]);
        if($newSale->getIdProduct() != null)
        {  
            echo $newSale->realizeSale() . "\n\n";
        }
        else
        {
            echo "DATOS INVALIDOS";
        }
    }

    
    public static function registrationUser()
    {
        $newUsuario = new Usuario(0,$_POST['nombre'],$_POST['apellido'],$_POST['mail'],$_POST['localidad'],"2022/9/28",$_POST['clave']);


        if(!empty($newUsuario->getMail()) )
        {
            echo $newUsuario->guardarUsuario();
        }
        else
        {
            echo "DATOS INVALIDOS";
        }  
    }

    public static function highProduct()
    {
        $newProduct = new Producto(0,$_POST['codigo'],$_POST['nombre'],$_POST['tipo'],$_POST['stock'],$_POST['precio'],date("Y,m,d"),date("Y,m,d"));

        if($newProduct->getCode()!= null)
        {
            echo $newProduct->addProduct();
        }
        else
        {
            echo "DATOS INVALIDOS";
        }
    }

    public static function loginUser()
    {
        $mailUsuario = $_POST['mail'];
        $claveUsuario = $_POST["clave"];
        if(Validar::validarMail($_POST['mail']) && !empty($mailUsuario) && !empty($claveUsuario))
        {
                echo Usuario::verificarUsuario($mailUsuario,$claveUsuario);
        }
        else
        {
            echo "Formato de mail invalido";
        }
    }


}


?>