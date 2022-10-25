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
        else
        {
            throw new Exception("datos incorrectos");
        }  
                     
    }

    public static function mostrarVentas()
    {
        $ret ="ID CLIENTE-ID PRODUCTO-CANTIDADVENDIDA:\n\n";
        $ventas = Venta::cargarVentas();
        foreach($ventas as $item)
        {
            if(!empty($item))
                $ret .=$item->__toString();
        }
        return $ret;
    }

    public static function cargarVentas()
    {
        $arrayVentas = [];
        $archivo = new ArchivosCsv("./archivos/ventas.csv");
        $contenido = $archivo->leerArchivos();
        for($i=0;$i<count($contenido);$i++)
        {
            if(!empty($contenido[$i]))
            {
                $objeto = explode(",",$contenido[$i]);
                array_push($arrayVentas,new Venta($objeto[0],$objeto[1],$objeto[2]));
            }
          
        }
        return $arrayVentas;

    }

    private function guardarVenta()
    {
        $archivo = new ArchivosCsv("./archivos/ventas.csv");
        if($archivo->agregarEnArchivo($this->__toString()))
            return true;
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