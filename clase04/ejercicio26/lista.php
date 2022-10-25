<?php

class Lista{

    private $_nombre;
    Private $_lista;

    public function __construct($nombre)
    {
        $this->_nombre = $nombre;
        $this->_lista =  [];
    }

    public function getLista()
    {
        return $this->_lista;   
    }
    public function getNombre()
    {
        return $this->_nombre;
    }

    public function add($objeto)
    {
        $ret = "No se pudo Hacer";
        if(!$this->ecuals($objeto))
        {
            array_push($this->_lista,$objeto);
            $ret = "ingresado\n";
            $this->guardarLista();
        }
        else
        {
            $index = $this->searchIndex($objeto);
            $this->_lista[$index]->addStockn($objeto->getStock());
            $ret = "Actualizado\n";
            $this->guardarLista();
        }
        return $ret;
    }
    public function act($objeto)
    {
        $index = $this->searchIndex($objeto);
        $this->_lista[$index] = $objeto;
        $this->guardarLista();
    }


    public function ecuals($objeto)
    {
        $ret = false;
        foreach($this->_lista as $item)
        {
            if($item->ecuals($objeto))
                $ret = true;
        }
        return $ret;
    }

    public function searchIndex($objeto)
    {
        $ret = -1;
        for($i = 0;$i<count($this->_lista);$i++)
        {
            if($this->_lista[$i]->ecuals($objeto))
            {
                $ret = $i;
                break;
            }      
        }
        return $ret;
    }

    public function guardarLista()
    {
        $path = "./archivos/". $this->_nombre . ".csv";
        $archivo = new ArchivosCsv($path);

        $archivo->guardarEnArchivo($this->__toString());
    }

    public function __toString()
    {
        $ret = $this->_nombre . PHP_EOL;

        foreach($this->_lista as $item)
        {
            $ret .= $item->__toString();
        }
        return $ret;
    }

    public static function cargarLista()
    {
        $path = "./archivos/productos.csv";
        $archivo = new ArchivosCsv($path);
        $lista = new Lista("productos");
        $productos = Producto::cargaProductos($archivo->leerArchivos());
        for($i = 0;$i<count($productos);$i++)
        {
            if(!empty($productos))
                $lista->add($productos[$i]);
        }

        return $lista;
    }

    public function mostrarLista()
    {
        $ret = "ID-CODIGO-NOMBRE-STOCK-PRECIO-TIPO\n";
        foreach($this->_lista as $item)
        {
            $ret .= $item->__toString();
        }
        return $ret;
    } 
   
}

?>