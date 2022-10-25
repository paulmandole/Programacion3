<?php

class Sale
{
    private $email;
    private $sabor;
    private $tipo;
    private $cantidad;
    private $fecha;
    private $numero_pedido;
    private $id;
    private $foto;
   

    public function __construct($mail,$sabor,$tipo,$cantidad,$fecha,$numero_pedido = 0,$id = 0,$foto = "")
    {
       
        if(Pizza::therePizza($sabor,$tipo) == "si hay")
        {
            
            $this->fecha = $fecha;
            $this->numero_pedido = $numero_pedido;
            $this->id = $id;
            $this->email = $mail;
            $this->sabor = $sabor;
            $this->tipo = $tipo;
            $this->cantidad = $cantidad;
            $this->foto = $foto;
            
        }

    }

    public function getMail()
    {
        return $this->email;
    }


    private function saveSaleBd()
    {
        $ret = false;
        try
        {
            $pdo = AccesoDatos::obtenerObjetoAcceso();
            $judgmen = $pdo->retornarConsulta('INSERT INTO ventas_pizzas (numero_pedido,fecha,email,sabor,tipo,cantidad) VALUES (:numero_pedido,:fecha,:email,:sabor,:tipo,:cantidad)');
            $judgmen->bindParam(":numero_pedido",$this->numero_pedido);
            $judgmen->bindParam(":fecha",$this->fecha);
            $judgmen->bindParam(":email",$this->email);
            $judgmen->bindParam(":sabor",$this->sabor);
            $judgmen->bindParam(":tipo",$this->tipo);
            $judgmen->bindParam(":cantidad",$this->cantidad);
            $judgmen->execute();
            $ret = true;
        }
        catch(Exception $ex)
        {
            print "ERROR" . $ex->getMessage();
        }
        return $ret;
    }

    public function saveSale()
    {
        $ret = "No se pudo concretar la venta";
        if(Pizza::quitStock($this->cantidad,$this->sabor,$this->tipo))
        {
            $this->saveSaleBd();
            $this->saveFile();
            $ret = "venta resgistrada";
        }
        return $ret;
    }

    private static function getNameMail($mail)
    {
        $nameMail = explode("@",$mail);
        return $nameMail[0];
    } 

    public function saveFile()
    {
        $ruta = "./ImagenesDeLaVenta/";
        $namePhoto = $this->tipo.$this->sabor.self::getNameMail($this->email).$this->fecha;
        if(Validar::validarDirectorio($ruta))
        {
            $destiny = $ruta . $namePhoto .".jpg";
            if(move_uploaded_file($this->foto,$destiny));
        }
    }


    public static function getSalesBd($query = 'SELECT * FROM ventas_pizzas')
    {
        try
        {
            $pdo = AccesoDatos::obtenerObjetoAcceso();
            $judgmen = $pdo->retornarConsulta($query);
            $judgmen->execute();
            return $judgmen->fetchall(PDO::FETCH_CLASS,"Sale",self::getAttributes());
        }
        catch(Exception $ex)
        {
            print "ERROR" . $ex->getMessage();
        }
    }
   
    private static function getAttributes()
    {
        $array = Array(
            'mail','sabor','tipo','cantidad','fecha','numero_pedido','id'
        );
        return $array;
    }

    public function __toString()
    {
        return $this->email . '  ' . $this->sabor . '  ' . $this->tipo . '  ' . $this->cantidad . '  ' . $this->fecha . '  ' . $this->numero_pedido . '  ' . $this->id;
    }

    public static function updateSale($pedido, $tipo, $mail, $sabor)
    {
        $query = "UPDATE ventas_pizzas SET tipo = '". $tipo ."' ,sabor = '". $sabor ."' , email = '". $mail ."' WHERE numero_pedido = $pedido";
        try
        {
            $pdo = AccesoDatos::obtenerObjetoAcceso();
            $judgmen = $pdo->retornarConsulta($query);
            $judgmen->execute();
            
            return true;
            
        }
        catch(Exception $ex)
        {
            print "ERROR". $ex->getMessage();
        }
    }

   





}


?>
