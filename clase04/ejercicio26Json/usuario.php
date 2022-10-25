<?php

include_once "../biblioteca/validaciones.php";
include_once "../biblioteca/archivosJson.php";

class Usuario
{
    private $_nombre;
    private $_clave;
    private $_mail;
    private $_id;
    private $_fechaRegistro;
    private $_fotoPerfil;

    public function __construct($id,$nombre,$clave,$mail,$fechaRegistro,$foto = "")
    {
        if(Validar::validarId($id)&& Validar::validarNombre($nombre) && Validar::validarMail($mail))
        {
            $this->_nombre = $nombre;
            $this->_clave = $clave;
            $this->_mail = $mail;
            $this->_id = $id;
            $this->_fechaRegistro = $fechaRegistro;
            $this->_fotoPerfil = $foto;
        }
    }

    public function getId()
    {
        return $this->_id;
    }

    public function mostrarUsuario()
    {
        return "nombre:". $this->_nombre . " Clave:" . $this->_clave . " email:" . $this->_mail ." fecha de Registro:". $this->_fechaRegistro;
    }

    public function __toString()
    {
        return $this->_id .",". $this->_nombre .",".$this->_clave.",". $this->_mail .",".$this->_fechaRegistro. "," . $this->_fotoPerfil ."\n";
    }


    public static function listaUsuarios()
    {
        $listaUsuarios = Usuario::cargarUsuariosDeJson();
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

    public static function verificarPorId($id)
    {
        $ret = false;
        $usuarios = Usuario::cargarUsuariosDeJson();
        for($i=0;$i<count($usuarios);$i++)
        {
            if($usuarios[$i]->getId() == $id)
            {
                $ret = true;
                break; 
            }
        }
        return $ret;
    }

    public function guardarUsuarioJson()
    {
        $ret = false;
        $archivo = new ArchivosJson("./archivos/usuarios.json");
        $contenido = json_encode($this->serializeUsuariosAJson());
        if($archivo->guardarEnArchivo($contenido))
            $ret = true;

        return $ret;
    }

    private function serializeUsuariosAJson()
    {
        $arrayUsuarios = Usuario::cargarUsuariosDeJson();
        $arraySerializado = [];
        foreach($arrayUsuarios as $item)
        {
            array_push($arraySerializado,$item->serializeUsuarioAJson());
        }
        array_push($arraySerializado,$this->serializeUsuarioAJson());
        return $arraySerializado;
    }

    private function serializeUsuarioAJson()
    {
        $array = Array(
            'id'=>$this->getId(),
            "nombre" => $this->_nombre,
            'clave' => $this->_clave,
            'mail' => $this->_mail,
            'fechaRegistro' => $this->_fechaRegistro,
            'fotoPerfil' => $this->_fotoPerfil
        );
        return $array;
    }

    public static function cargarUsuariosDeJson()
    {
        $arrayUsuarios = [];
        $archivo = new ArchivosJson("./archivos/usuarios.json");
        $array = json_decode($archivo->leerEnArchivo(),true);
        if(!empty($array))
        {
            foreach($array as $item)
            {
                array_push($arrayUsuarios,Usuario::desSerializeUsuarioJson($item));
            }   
        }
            
        return $arrayUsuarios;
    }

    //hacer validaciones
    private static function desSerializeUsuarioJson($usuario)
    {
        return new Usuario($usuario["id"],$usuario["nombre"],$usuario["clave"],$usuario["mail"],$usuario["fechaRegistro"],$usuario["fotoPerfil"]);   
    }
}

?>