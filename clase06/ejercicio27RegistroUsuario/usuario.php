<?php


include_once "../../biblioteca/validaciones.php";
include_once "../../biblioteca/accesoDatos.php";

class usuario
{
    private $_nombre;
    private $_apellido;
    private $_mail;
    private $_localidad;
    private $_fechaRegistro;
    private $_clave;


    public function __construct($nombre,$apellido,$mail,$localidad,$fechaRegistro,$clave)
    {
        if(Validar::validarNombre($nombre) && Validar::validarNombre($apellido) && Validar::validarMail($mail)
         && Validar::validarNombre($localidad))
        {
            $this->_nombre = $nombre;
            $this->_apellido = $apellido;
            $this->_mail = $mail;
            $this->_localidad = $localidad;
            $this->_fechaRegistro = $fechaRegistro;
            $this->_clave = $clave;
        }
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
            $sentencia->bindParam(':nombre',$this->_nombre);
            $sentencia->bindParam(':apellido',$this->_apellido);
            $sentencia->bindParam(':mail',$this->_mail);
            $sentencia->bindParam(':clave',$this->_clave);
            $sentencia->bindParam(':localidad',$this->_localidad);
            $sentencia->bindParam(':fechaRegistro',$this->_fechaRegistro);
            $sentencia->execute();
            $ret = true;
        }
        catch(Exception $e)
        {
            print "ERROR!" . $e->getMessage();
        }
        return $ret;
    }
}

?>