<?php


include_once "../../biblioteca/validaciones.php";
include_once "../../biblioteca/accesoDatos.php";

class usuario
{
    private $nombre;
    private $apellido;
    private $mail;
    private $localidad;
    private $fecha_de_registro;
    private $clave;
    private $id;


    public function __construct($id = 0,$nombre,$apellido,$mail,$localidad,$fechaRegistro,$clave)
    {
        if(Validar::validarNombre($nombre) && Validar::validarNombre($apellido) && Validar::validarMail($mail)
         && Validar::validarNombre($localidad))
        {
            $this->id = $id;
            $this->nombre = $nombre;
            $this->apellido = $apellido;
            $this->mail = $mail;
            $this->localidad = $localidad;
            $this->fecha_de_registro = $fechaRegistro;
            $this->clave = $clave;
            
        }
    }
    public function getNombre()
    {
        return $this->nombre;
    }
    public function getMail()
    {
        return $this->mail;
    }

    private function obtenerNombreAtributos()
    {
        $array = Array('id','nombre','apellido','localidad','mail','fechaRegistro','clave' );
        return $array;
    }

    private static function mailExist($mail)
    {
        $ret = false;
        $listaUsuarios = self::obtenerUsuarios();
        foreach($listaUsuarios as $item)
        {
            if($item->getMail() == $mail)
            {
                $ret = true;
                break;
            }
        }
        return $ret;
    }

    public function guardarUsuario()
    {
        $exito = "error al guardar usuario";
        if(!self::mailExist($this->getMail()))
        {
            if($this->guardarEnBaseDatos())
            $exito = "Usuario cargado correctamente";
        }
        else
        {
             $exito.= " Usuario ya registrado.";
        }
        
        return $exito;
    }

    private function guardarEnBaseDatos()
    {
        $ret = false;
        try
        {
            $pdo = AccesoDatos::obtenerObjetoAcceso();
            $sentencia = $pdo->retornarConsulta('insert into usuarios (nombre,apellido,mail,clave,fecha_de_registro,localidad) VALUES(:nombre,:apellido,:mail,:clave,:fechaRegistro,:localidad)');
            $sentencia->bindParam(':nombre',$this->nombre);
            $sentencia->bindParam(':apellido',$this->apellido);
            $sentencia->bindParam(':mail',$this->mail);
            $sentencia->bindParam(':clave',$this->clave);
            $sentencia->bindParam(':localidad',$this->localidad);
            $sentencia->bindParam(':fechaRegistro',$this->fecha_de_registro);
            $sentencia->execute();
            $ret = true;
        }
        catch(Exception $e)
        {
            print "ERROR!" . $e->getMessage();
        }
        return $ret;
    }

    public function __toString()
    {
        return $this->id .','.$this->nombre .",". $this->apellido."," . $this->mail .",".$this->localidad .",". $this->fecha_de_registro .",". $this->clave;
    }

    // private static function orderByApellidoAsc($user1,$user2)
    // {
    //     $name1 = strtolower($user1->apellido);
    //     $name2 = strtolower($user2->apellido);

    //     if($name1 > $name2)
    //     {
    //         return 1;
    //     }
    //     else if($name1 < $name2)
    //     {
    //         return -1;
    //     }
    //     else
    //     {
    //         $name1 = strtolower($user1->getNombre());
    //         $name2 = strtolower($user2->getNombre());
    //         return self::orderByName($name1,$name2);
    //     }
    // }

    // private static function orderByName($name1,$name2)
    // {
    //     if($name1 > $name2)
    //     {
    //         return 1;
    //     }
    //     else if($name1 < $name2)
    //     {
    //         return -1;
    //     }
    //     else
    //     {
    //         return 0;
    //     }
    // }
    // private static function orderByApellidoDesc($user1,$user2)
    // {
    //     $name1 = strtolower($user1->apellido);
    //     $name2 = strtolower($user2->apellido);

    //     if($name1 < $name2)
    //     {
    //         return 1;
    //     }
    //     else if($name1 > $name2)
    //     {
    //         return -1;
    //     }
    //     else
    //     {
    //         $name1 = strtolower($user1->getNombre());
    //         $name2 = strtolower($user2->getNombre());
    //         return self::orderByName($name1,$name2);
    //     }
    // }

    public static function obtenerListaUlUsuarios($order = 0)
    {
        $desc = 'SELECT * FROM usuarios ORDER BY apellido DESC,nombre DESC';
        $asc = 'SELECT * FROM usuarios ORDER BY apellido ASC,nombre ASC';
        if($order)
        {
            $listaUsuarios = self::obtenerUsuarios($desc);
        }
        else
        {
            $listaUsuarios = self::obtenerUsuarios($asc);
        }
        //     usort($listaUsuarios, array('Usuario','orderByApellidoDesc')); orden por funcion
        $ret = "<ul>\n";
        foreach($listaUsuarios as $item)
        {
            
            $ret .="<li>".$item->__toString()."</li>\n";
        }
        $ret .="</ul>";
        return $ret;
    }

    //probar ordenar pasando toda la sentencia nueva ej select * from usuarios order by apellido asc,nombre asc

    private static function obtenerUsuarios($consulta = 'SELECT * FROM usuarios')
    {
        $listaUsuarios = [];
        try
        {
            $pdo = AccesoDatos::obtenerObjetoAcceso();
            $sentencia = $pdo->retornarConsulta($consulta);
           
            $sentencia->execute();
            $listaUsuarios = $sentencia->fetchAll(PDO::FETCH_CLASS,"Usuario",self::obtenerNombreAtributos());
        }
        catch(Exception $e)
        {
            print "ERROR" . $e->getMessage();
        }
        return $listaUsuarios;
    }

    private function verificarClave($pass)
    {
        $ret = "Error en los datos";
        if($this->clave == $pass)
        {
            $ret = "verificado";
        }
        return $ret;
    }
    private function VerificarMail($mail)
    {
        $ret = false;
        if($this->mail == $mail )
        {
            $ret = true;
        }
        return $ret;
    }

    public static function verificarUsuarioPorID($idUsuario)
    {
        $ret = false;
        $listaUsuarios = self::obtenerUsuarios();
        foreach($listaUsuarios as $item)
        {
            if($item->id == $idUsuario)
            {
                $ret = true;
                break;
            }
        }
        return $ret;
    }

    

    public static function verificarUsuario($mail,$pass)
    {   
        $ret = "Usuario no registrado";
        $listaUsuarios = self::obtenerUsuarios();
        foreach($listaUsuarios as $item)
        {
            if($item->verificarMail($mail))
            {   
                $ret = $item->verificarClave($pass);
                break;
            } 
        }
        return $ret;
    }

    private static function getUserByMail($mail)
    {
        $ret = null;
        $listaUsuarios = self::obtenerUsuarios();
        foreach($listaUsuarios as $item)
        {
            if($item->mail == $mail)
            {
                $ret = $item;
                break;
            }
        }
        return $ret;
    }

    private function modifyUserBd()
    {
        try
        {
            $pdo = AccesoDatos::obtenerObjetoAcceso();
            $judgment = $pdo->retornarConsulta('update usuarios set nombre = :nombre,clave = :clave where id = :id');
            $judgment->bindParam(":nombre",$this->nombre);
            $judgment->bindParam(":clave",$this->clave);
            $judgment->bindParam(":id",$this->id);
            $judgment->execute();
            return true;
        }
        catch(Exception $e)
        {
            print "ERROR". $e->getMessage();
        }
    }

    public static function modificarUsuario($mail,$claveVieja,$claveNueva,$nombre)
    {
        $ret = "error al modificar usuario";
        $usuarioMod = self::getUserByMail($mail);
        if($usuarioMod != null && self::verificarUsuario($mail,$claveVieja) == "verificado")
        {
            $usuarioMod->clave = $claveNueva;
            $usuarioMod->nombre = $nombre;
            $usuarioMod->modifyUserBd();
            $ret = "usuario modificado Correctamente";
        }
        return $ret;
    }
}

?>