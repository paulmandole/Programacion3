<?php
include_once "../../biblioteca/validaciones.php";
include_once "../../biblioteca/accesoDatos.php";
include_once "./producto.php";
include_once "./usuario.php";

class Sale
{
    private $id;
    private $id_producto;
    private $id_usuario;
    private $cantidad;
    private $fecha_de_venta;

    public function __construct($idProducto,$idUsuario,$cantidad,$idVenta = 0)
    {
        if($cantidad > 0)
        {
            $this->id = $idVenta;
            $this->id_producto = $idProducto;
            $this->id_usuario = $idUsuario;
            $this->cantidad = $cantidad;
            $this->fecha_de_venta = date("Y,m,d");

        }
    }

    public function getIdProduct()
    {
        return $this->id_producto;
    }

    private function getAttributes()
    {
        return Array('id','id_producto','id_usuario','cantidad','fecha_de_venta');
    }

    public function realizeSale()
    {
        $ret = "No se pudo realizar la venta";
        if(Usuario::verificarUsuarioPorID($this->id_usuario) && Producto::checkProductById($this->id_producto)&& Producto::removeStock($this->cantidad,$this->id_producto))
        {
            $this->addSaleBd();
            $ret = "venta Realizada";
        }
        return $ret;
    }

    private function addSaleBd()
    {
        $ret = false;
        try
        {
            $pdo = AccesoDatos::obtenerObjetoAcceso();
            $judgmen = $pdo->retornarConsulta('insert into ventas(id_producto,id_usuario,cantidad,fecha_de_venta)values(:idProducto,:idUsuario,:cantidad,:fechaVenta)');
            $judgmen->bindParam(":idProducto",$this->id_producto);
            $judgmen->bindParam(":idUsuario",$this->id_usuario);
            $judgmen->bindParam(":cantidad",$this->cantidad);
            $judgmen->bindParam(":fechaVenta",$this->fecha_de_venta);
            $judgmen->execute();
            $ret = true;
        }
        catch(Exception $e)
        {
            print "Error" . $e->getMessage();
        }
        return $ret;
    }

    private static function getSalesBd()
    { 
        try
        {
            $pdo = AccesoDatos::obtenerObjetoAcceso();
            $judgmen = $pdo->retornarConsulta('select * from ventas');
            $judgmen->execute();
            return $judgmen->fetchall(PDO::FETCH_CLASS,"Sale",self::getAttributes());
        }
        catch(Exception $e)
        {
            print "ERROR".$e->getMessage();
        }
    }

    public function __toString()
    {
        return $this->id .','.$this->getIdProduct().','.$this->cantidad. ','. $this->fecha_de_venta;
    }

    public static function showSales()
    {
        $ret = "Lista de ventas:\n";
        $listSales =  self::getSalesBd();
        foreach($listSales as $item)
        {
            $ret .= $item->__toString() . "\n";
        }
        return $ret;
    }

}

?>