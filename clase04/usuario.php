<?php

use Usuario as GlobalUsuario;

class Usuario
{
    private $_nombre;
    private $_clave;
    private $_mail;
    private $id;
    private $_fechaRegistro;
    private $_fotoPerfil;

    public function __construct($id,$nombre,$clave,$mail,$fechaRegistro,$foto = "")
    {
        $this->_nombre = $nombre;
        $this->_clave = $clave;
        $this->_mail = $mail;
        $this->_id = $id;
        $this->_fechaRegistro = $fechaRegistro;
        $this->_fotoPerfil = $foto;
    }

    public function mostrarUsuario()
    {
        return "nombre:". $this->_nombre . " Clave:" . $this->_clave . " email:" . $this->_mail ." fecha de Registro:". $this->_fechaRegistro;
    }

    public function __toString()
    {
        return $this->_id .",". $this->_nombre .",".$this->_clave.",". $this->_mail .",".$this->_fechaRegistro. "," . $this->_fotoPerfil ."\n";
    }

    public static function guardarUsuario($usuario)
    {
        $ret =  false;
        if(is_a($usuario ,"Usuario"))
        {
            $archivo = new ArchivosCsv("usuarios.csv");
            if($archivo->agregarEnArchivo($usuario->__toString()))
                $ret = true;
        }
        return $ret;
    }
    public static function cargarUsuarios()
    {
        $archivo = new ArchivosCsv("usuarios.csv");
        $contenido = $archivo->leerArchivos();
        $arrayUsuarios = [];

        for($i = 0 ; $i < count($contenido); $i++)
        {
            if(!empty($contenido[$i]))
            {
                $objeto = explode(",",$contenido[$i]);
                array_push($arrayUsuarios ,new Usuario($objeto[0],$objeto[1],$objeto[2],$objeto[3],$objeto[4],$objeto[5]));
            }
        }

        return $arrayUsuarios;
    }

    public static function listaUsuarios()
    {
        $listaUsuarios = Usuario::cargarUsuarios();
        $ret = "<ul>". PHP_EOL;

        for($i = 0 ; $i<count($listaUsuarios); $i++)
        {
            $ret .= "<li>". $listaUsuarios[$i]->mostrarUsuario() . "<br><img src='". $listaUsuarios[$i]->_fotoPerfil . "'>" ."</li>". PHP_EOL;
        }
        $ret .= "</ul>";
        return $ret;
    }

    public function ecuals($usuario)
    {
        $ret = false;
        if(is_a($usuario,"Usuario"))
        {
            if(strcmp($this->_mail,$usuario->_mail)== 0)
            {
                $ret = true;
            }    
        }
        return $ret;
    }

    public function autentificacion()
    {
        $ret = "Usuario no resgistrado";
        $listaUsuarios = Usuario::cargarUsuarios();

        for($i = 0 ; $i < count($listaUsuarios); $i++)
        {
            if($this->ecuals($listaUsuarios[$i]))
            { 
                if($this->_clave == $listaUsuarios[$i]->_clave)
                {
                    $ret = "verificado";
                }
                else
                {
                    $ret = "error en datos";
                }
                break;
            }
        }
        return $ret;
    }

   

}



?>