<?php

class AccesoDatos
{
    private static $_objetoAccesoDatos;
    private $_objetoPDO;

    private function __construct()
    {
        try
        {
            $this->_objetoPDO = new PDO('mysql:host=localhost;dbname=utn;charset=utf8', 'root', '', array(PDO::ATTR_EMULATE_PREPARES => false,PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
            $this->_objetoPDO->exec("SET CHARACTER SET utf8");

        }
        catch (PDOException $e)
        {
            print "Error!: " . $e->getMessage(); 
            die();
        }
        
    }

    public function retornarConsulta($sql)
    {
        return $this->_objetoPDO->prepare($sql);
    }

    public function retornaElUltimoIdInsertado()
    {
        return $this->_objetoPDO->lastInsertId();
    }

    public static function obtenerObjetoAcceso()
    {
        if(!isset(self::$_objetoAccesoDatos))
        {
            self::$_objetoAccesoDatos = new AccesoDatos();
        }
        return self::$_objetoAccesoDatos;
    }

    // Evita que el objeto se pueda clonar
    public function __clone()
    { 
        trigger_error('La clonación de este objeto no está permitida', E_USER_ERROR); 
    }

}

?>