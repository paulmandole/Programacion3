<?php



class Usuario
{
    private $_nombre;
    private $_clave;
    private $_mail;

    public function __construct($nombre,$clave,$mail)
    {
        $this->_nombre = $nombre;
        $this->_clave = $clave;
        $this->_mail = $mail;
    }

    public function mostrarUsuario()
    {
        return "nombre: ". $this->_nombre . " Clave: " . $this->_clave . " email: " . $this->_mail . PHP_EOL;
    }

    public function __toString()
    {
        return $this->_nombre .",".$this->_clave.",". $this->_mail ."\n";
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
                array_push($arrayUsuarios ,new Usuario($objeto[0],$objeto[1],$objeto[2]));
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
            $ret .= "<li>". $listaUsuarios[$i]->mostrarUsuario() . "</li>". PHP_EOL;
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