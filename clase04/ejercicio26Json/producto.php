<?php

class Producto
{
    private $_id;
    private $_codigoBarras;
    private $_nombre;
    private $_stock;
    private $_precio;
    private $_tipo;

    public function getCodigo()
    {
        return $this->_codigoBarras;
    }
    public function getStock()
    {
        return $this->_stock;
    }

    public function __construct($id,$codigoBarras,$nombre,$stock = 0,$precio = 0,$tipo)
    {
        if(Validar::validarId($id) && Validar::validarCodigoBarras($codigoBarras)&& $stock >= 0)
        {
            $this->_id = $id;
            $this->_codigoBarras = $codigoBarras;
            $this->_nombre = $nombre;
            $this->_stock = $stock;
            $this->_precio = $precio;
            $this->_tipo = $tipo;
        }
        else
        {
            throw new Exception("datos incorrectos");
        }
       
    }

    public function ecuals($producto)
    {
        $ret = false;
        if(is_a($producto,"Producto"))
        {
            if($this->getCodigo() == $producto->getCodigo())
                $ret = true;
        }
        return $ret;
    }
    
    public function addStockN($cantidad)
    {
         $this->_stock +=$cantidad;
    }
    

    public function removeStock($cantidad)
    {
        if($this->_stock >= $cantidad)
        {
            $this->_stock -= $cantidad;
            $ret = true;
        }
        else
        {
            $ret = false;
        }   
        return $ret;
    }

    public function __toString()
    {
        return $this->_id.",".$this->_codigoBarras.",".$this->_nombre.",".$this->_stock.",".$this->_precio.",".$this->_tipo."\n";
    }

    public static function cargaProductos($contenido)
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

    public static function verificarProductoPorCodigo($codigo)
    {
        $ret = false;
        $lista = Lista::cargarLista();
        foreach($lista->getLista() as $item)
        {
            if($item->getCodigo() == $codigo)
            {
                $ret = true;
                break;
            }
        }
        return $ret;
    }
    public static function obtenerProductoPorCodigo($codigo)
    {
        $lista = Lista::cargarLista();
        foreach($lista->getLista() as $item)
        {
            if($item->getCodigo() == $codigo)
            {
                return $item;
                break;
            }
        }
        
    }

    public static function guardarProductosEnJson($arrayProductos)
    {
        $arraySerializado = [];
        foreach($arrayProductos as $item)
        {
            array_push($arraySerializado,$item->serializeProductoAJson());
        }
        $contenido = json_encode($arraySerializado);

        return $contenido;
    }

    private function serializeProductoAJson()
    {
        $arrayProductos = Array(
            'id' => $this->_id,
            'codigoBarras' => $this->_codigoBarras,
            'nombre' => $this->_nombre,
            'stock' => $this->_stock,
            'precio' => $this->_precio,
            'tipo' => $this->_tipo
        );
        return $arrayProductos;
    }

    public static function cargarProductosDeArchivoJson()
    {
        $arrayProductos = [];
        $archivo = new ArchivosJson("./archivos/productos.json");
        $array = json_decode($archivo->leerEnArchivo(),true);
        if(!empty($array))
        {
            foreach($array as $item)
            {
                array_push($arrayProductos,Producto::desSerializePrductoJson($item));
            }
        }
        return $arrayProductos; 
    }

    private static function desSerializePrductoJson($producto)
    {
        return new Producto($producto["id"],$producto["codigoBarras"],$producto["nombre"],$producto["stock"],$producto["precio"],$producto["tipo"]);
    }

}

?>