<?php

class Venta
{
    private $_idProducto;
    private $_idCliente;
    private $_cantidadVendida;

    public function __construct($idProducto,$idCliente,$cantidadVendida)
    {    
        if(Validar::validarCodigoBarras($idProducto) && Validar::validarId($idCliente) && $cantidadVendida > 0)
        {
            $this->_idProducto = $idProducto;
            $this->_idCliente = $idCliente;
            $this->_cantidadVendida = $cantidadVendida; 
        }
       
                     
    }

    private function serializeVentaAJson()
    {
        $array= Array(
            'idProducto' => $this->_idProducto,
            'idCliente' => $this->_idCliente,
            'cantidadVendida' => $this->_cantidadVendida
        );
        return $array;
    }

    public static function mostrarVentas()
    {
        $ret ="ID CLIENTE-ID PRODUCTO-CANTIDADVENDIDA:\n\n";
        $ventas = Venta::cargarVentasDeJson();
        if(!empty($ventas))
        {
            foreach($ventas as $item)
            {
                $ret .=$item->__toString();
            }
        }
        
        return $ret;
    }

    private function serializeVentasAJson()
    {
        $arrayUsuarios = Venta::cargarVentasDeJson();
        $arraySerializado = [];
        foreach($arrayUsuarios as $item)
        {
            array_push($arraySerializado,$item->serializeVentaAJson());
        }
        array_push($arraySerializado,$this->serializeVentaAJson());
        return $arraySerializado;
    }
    public static function cargarVentasDeJson()
    {
        $arrayVentas = [];
        $archivo = new ArchivosJson("./archivos/ventas.json");
        $array = json_decode($archivo->leerEnArchivo(),true);
        if(!empty($array))
        {
            foreach($array as $item)
            {
                array_push($arrayVentas,Venta::desSerializeVentaJson($item));
            } 
        }
        return $arrayVentas;

    }
    private static function desSerializeVentaJson($venta)
    {
        return new Venta($venta["idProducto"],$venta["idCliente"],$venta["cantidadVendida"]);   
    }

    private function guardarVenta()
    {
        $ret = false;
        $archivo = new ArchivosJson("./archivos/ventas.json");
        $contenido = json_encode($this->serializeVentasAJson());
        if($archivo->guardarEnArchivo($contenido))
            $ret = true;

        return $ret;
    }
    public function __toString()
    {
        return $this->_idProducto.",".$this->_idCliente.",".$this->_cantidadVendida."\n";
    }

    public function validarVenta()
    {
        $ret = "no se pudo realizar la venta";
        if(Producto::verificarProductoPorCodigo($this->_idProducto) && Usuario::verificarPorId($this->_idCliente))
        {
            $producto = Producto::obtenerProductoPorCodigo($this->_idProducto);
            $lista = Lista::cargarLista();
           
            if($producto->removeStock($this->_cantidadVendida))
            {
                $lista->act($producto);
                $this->guardarVenta();
                $ret = "Venta realizada";
            }
        }
        return $ret;
    }
}
?>