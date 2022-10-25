<?php
include_once "../../biblioteca/validaciones.php";
include_once "../../biblioteca/accesoDatos.php";

class Producto
{
    private $id;
    private $codigo_de_barra;
    private $nombre;
    private $tipo;
    private $stock;
    private $precio;
    private $fecha_de_creacion;
    private $fecha_de_modificacion;

    public function __construct($id = 0,$codigo,$nombre,$tipo,$stock,$precio = 0,$fechaCreacion,$fechaModificacion)
    {
        if(Validar::validarCodigoBarras($codigo)&& Validar::validarNombre($nombre))
        {
            $this->id = $id;
            $this->codigo_de_barra = $codigo;
            $this->nombre = $nombre;
            $this->tipo = $tipo;
            $this->stock = $stock;
            $this->precio = $precio;
            $this->fecha_de_creacion = $fechaCreacion;
            $this->fecha_de_modificacion = $fechaModificacion;
        }  
    }

    public function getCode()
    {
        return $this->codigo_de_barra;
    }

    public function addStock($amount)
    {
        $this->stock += $amount;
    }

    public function getDateCreation()
    {
        return $this->fecha_de_creacion;
    }

    public function getDateModification()
    {
        return $this->fecha_de_modificacion;
    }

    private function getAttributes()
    {
        return Array('id','codigo_de_barra','nombre','tipo','stock','precio','fecha_de_creacion','fecha_de_modificacion');
    }

    public function ecuals($product)
    {
        $ret = false;
        if(is_a($product,"Producto"))
        {
            if($this->getCode() == $product->getCode())
                $ret = true;
        }
        return $ret;
    }

    private static function getProductOfBd()
    {
        try
        {
            $pdo = AccesoDatos::obtenerObjetoAcceso();
            $judgmen = $pdo->retornarConsulta('select * from productos');
            $judgmen->execute();
            return $judgmen->fetchall(PDO::FETCH_CLASS,"Producto",self::getAttributes());
        }
        catch(Exception $e)
        {
            print "Error" . $e->getMessage();
        }
    }

    public function __toString()
    {
        return $this->id.','. $this->getCode(). ',' . $this->nombre .',' . $this->tipo .','. $this->stock . ','.$this->precio.','.$this->getDateCreation().','.$this->getDateModification();
    }

    public static function showListProduct()
    {
        $ret = "LISTA DE PRODUCTOS:\n";
        $listProduct = self::getProductOfBd();
        foreach($listProduct as $item)
        {
            $ret .= $item->__toString()."\n";
        }
        return $ret;
    }

    public function actStockProductBd()
    {
        $ret = false;
        try
        {
            $pdo = AccesoDatos::obtenerObjetoAcceso();
            $judgmen = $pdo->retornarConsulta('update productos set stock = :stock where id = :id');
            $judgmen->bindParam(":stock",$this->stock);
            $judgmen->bindParam(":id", $this->id);
            $judgmen->execute();
            $ret = true;

        }
        catch(Exception $e)
        {
            print "Error" . $e->getMessage();
        }
        return $ret;
    }

    private function addProductBd()
    {
        $ret = false;
        try
        {
            $pdo = AccesoDatos::obtenerObjetoAcceso();
            $judgmen = $pdo->retornarConsulta('insert into productos(codigo_de_barra, nombre,tipo, stock, precio,fecha_de_creacion,fecha_de_modificacion) values(:codigo,:nombre,:tipo,:stock,:precio,:fechaCreacion,:fechaModificacion)');
            $judgmen->bindParam(':nombre',$this->nombre);
            $judgmen->bindParam(':tipo',$this->tipo);
            $judgmen->bindParam(':codigo',$this->codigo_de_barra);
            $judgmen->bindParam(':stock',$this->stock);
            $judgmen->bindParam(':precio',$this->precio);
            $judgmen->bindParam(':fechaCreacion',$this->fecha_de_creacion);
            $judgmen->bindParam(':fechaModificacion',$this->fecha_de_modificacion);
            $judgmen->execute();
            $ret = true;
            
        }
        catch(Exception $e)
        {
            print "ERROR". $e->getMessage();
        }
        return $ret;
    }

    private static function getProductByCode($code)
    {
        
        $listProduct = self::getProductOfBd();
        foreach($listProduct as $item)
        {
            if($code == $item->getCode())
            {
                return $item;
                break;
            }
        }
    }

    private function validateProduct()
    {
        $ret = false;
        $listProduct = self::getProductOfBd();
        foreach($listProduct as $item)
        {
            if($this->ecuals($item))
            {
                $ret = true;
                break;
            }
        }
        return $ret;
    }

    public function addProduct()
    {
        $ret ="ERROR AL AgregarProducto";
        if($this->validateProduct())
        {
            $prodAct = self::getProductByCode($this->getCode());
            $prodAct->addStock($this->stock);
            if($prodAct->actStockProductBd())
            {
                $ret = "Producto Actualizado Correctamente";
            }
                
        }
        else
        {
            if($this->addProductBd())
                $ret = "Producto Agregado Correctamente";
        }
        return $ret;
    }





}


?>