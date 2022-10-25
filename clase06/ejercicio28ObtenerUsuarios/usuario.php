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

    public function obtenerNombreAtributos()
    {
        $array = Array('id','nombre','apellido','localidad','mail','fechaRegistro','clave' );
        return $array;
    }

    public function guardarUsuario()
    {
        $exito = "error al guardar usuario en base de datos";
        if($this->guardarEnBaseDatos())
            $exito = "Usuario cargado correctamente en la base de datos";
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


    public static function obtenerListaUlUsuarios()
    {
        $listaUsuarios = Usuario::obtenerUsuarios();
        $ret = "<ul>\n";
        foreach($listaUsuarios as $item)
        {
            $ret .="<li>".$item->__toString()."</li>\n";
        }
        $ret .="</ul>";
        return $ret;
    }

    private static function obtenerUsuarios()
    {
        $listaUsuarios = [];
        try
        {
            $array = Array('id','nombre','apellido','localidad','mail','fechaRegistro'=>'fechaRegistro','clave' );
            $pdo = AccesoDatos::obtenerObjetoAcceso();
            $sentencia = $pdo->retornarConsulta('select * from usuarios');
            $sentencia->execute();
            $listaUsuarios = $sentencia->fetchAll(PDO::FETCH_CLASS,"Usuario",self::obtenerNombreAtributos());
        }
        catch(Exception $e)
        {
            print "ERROR" . $e->getMessage();
        }
        return $listaUsuarios;
    }
}

?>