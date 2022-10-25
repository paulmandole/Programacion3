<?php
include_once "../../biblioteca/validaciones.php";
include_once "./usuario.php";

if(Validar::validarMail($_POST['mail']))
{
    $mailUsuario = $_POST['mail'];
    $claveUsuario = $_POST["clave"];

    echo Usuario::verificarUsuario($mailUsuario,$claveUsuario);

}
else
{
    echo "Formato de mail invalido";
}

?>