<?php

class Producto
{
    private $_id;
    private $_codigoBarras;
    private $_nombre;
    private $_stock;
    private $_precio;
    private $_tipo;

    public function __construct($id,$codigoBarras,$nombre,$stock = 0,$precio,$tipo)
    {
        $this->_id = $id;
        $this->_codigoBarras = $codigoBarras;
        $this->_nombre = $nombre;
        $this->_stock = $stock;
        $this->_precio = $precio;
        $this->_tipo = $tipo;
    }

    public static function ecuals($producto,$producto2)
    {
        $ret = false;
        if(is_a($producto,"Producto"))
        {
            if($producto->_codigoBarras == $producto2->_codigoBarras)
                $ret = true;
        }
        return $ret;
    }
    
    public static function addStock($producto,$productoRepetido)
    {
        if(is_a($producto,"Producto")&& is_a($productoRepetido,"Producto"))
             $producto->_stock +=$productoRepetido->_stock;
    }

    public static function toString($producto)
    {
        $ret = null;
        if(is_a($producto,"Producto"))
        $ret = $producto->_id.",".$producto->_codigoBarras.",".$producto->_nombre.",".$producto->_stock.",".$producto->_precio.",".$producto->_tipo."\n";
        return  $ret;
    }

    public static function cargaProducto($contenido)
    {
        $arrayProductos = [];
        for($i = 1 ; $i< count($contenido);$i++)
        {
            if(!empty($contenido[$i]))
            {
                $objeto = explode(",",$contenido[$i]);
                array_push($arrayProductos,new Producto($objeto[0],$objeto[1],$objeto[2],$objeto[3],$objeto[4],$objeto[5]));
            }
        }
        return $arrayProductos;
    }
    public static function removeStock($producto,$cantidad)
    {
        $ret = -1;
        if(is_a($producto,"Producto"))
        {
            if($producto->_stock >= $cantidad)
            {
                $producto->_stock -= $cantidad;
            }
            else if($producto->stock > 0)
            {
                $ret = $producto->_stock;
                $producto->stock = 0;
            }
        }
        return $ret;
    }
  

}

?>