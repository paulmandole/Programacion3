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

    private static function getSalesBd($sales = 'SELECT * FROM ventas')
    { 
        try
        {
            $pdo = AccesoDatos::obtenerObjetoAcceso();
            $judgmen = $pdo->retornarConsulta($sales);
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


    private static function showList($listSales)
    {
        $ret = "Lista de ventas:<br>";
         
        foreach($listSales as $item)
        {
            $ret .= $item->__toString() . "<br>";
        }
        return $ret;
    }

    public static function showSalesBetweenTwoDates($date1,$date2)
    {
        $judgmen = 'SELECT * from ventas where  fecha_de_venta > \''.$date1.'\' AND fecha_de_venta < \''.$date2.'\'';
        $listSales =  self::getSalesBd($judgmen); 
        return self::showList($listSales);    
    }

    public static function showAllSales()
    {
        $listSales =  self::getSalesBd();
        return self::showList($listSales);  
    }


    public static function showSalesByAmount($min,$max)
    {
        $judgmen = 'SELECT * FROM ventas where ventas.cantidad BETWEEN '.$min . ' AND '.$max;
        $listSales =  self::getSalesBd($judgmen);
        return self::showList($listSales);  
    }

    public static function getSalesWithUserAndProductName()
    {
        $judgmen = 'SELECT ventas.id,productos.nombre,usuarios.nombre FROM ventas INNER JOIN productos on ventas.id_producto = productos.id INNER join usuarios on ventas.id_usuario = usuarios.id';
        $listSales = self::getSalesBd($judgmen);
        $ret = "Lista de ventas:<br>";
        print_r($listSales);
        // foreach($listSales as $item)
        // {
        //     $ret .= $item->
        // }
    }

}

?>