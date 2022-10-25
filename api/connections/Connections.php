<?php

 class Connection extends Mysqli
 {

    function __construct()
    {
        parent::__construct('localhost', 'root' , '' , 'utn');
        $this->set_charset('utf8');
        $this->connect_error == null ? 'Connexion exitosa a la BD' : die('Error al conectarse a la BD');
    }
 }


?>