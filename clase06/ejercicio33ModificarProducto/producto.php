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
    public function lowStock($amount)
    {
        $this->stock -= $amount;
    }

    public function getCode()
    {
        return $this->codigo_de_barra;
    }

    public static function removeStock($amount,$idProduct)
    {
        $ret = false;
        $product = self::getProductById($idProduct);
        if($product->stock >= $amount)
        {
            $product->lowStock($amount);
            $product->updateStockProductBd();
            $ret = true;
        }
        return $ret;
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
        return Array('id','codigo_de_barra','nombre','tipo','stock','precio','fecha_de_creacion','fecha_de_modificacion');    }

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

    private static function getProductsOfBd()
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
        $listProduct = self::getProductsOfBd();
        foreach($listProduct as $item)
        {
            $ret .= $item->__toString()."\n";
        }
        return $ret;
    }

    public static function checkProductById($idProduct)
    {
        $ret = false;
        $listProducts = self::getProductsOfBd();
        foreach($listProducts as $item)
        {
            if($item->id == $idProduct)
            {
                $ret = true;
                break;
            }
        }
        return $ret;
    }

    public function updateStockProductBd()
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
        
        $listProduct = self::getProductsOfBd();
        foreach($listProduct as $item)
        {
            if($code == $item->getCode())
            {
                return $item;
                break;
            }
        }
    }
    private static function getProductById($idProduct)
    {     
        $listProduct = self::getProductsOfBd();
        foreach($listProduct as $item)
        {
            if($idProduct == $item->id)
            {
                return $item;
                break;
            }
        }
    }
    public static function getStockById($idProduct)
    {
        $amount = -1;
        $listProducts = self::getProductsOfBd();
        foreach($listProducts as $item)
        {
            if($idProduct == $item->id)
            {  
                $amount = $item->stock;
                break;
            }
        }
        return $amount;
    }
    

    private function validateProduct()
    {
        $ret = false;
        $listProduct = self::getProductsOfBd();
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
            if($prodAct->updateStockProductBd())
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

    private function modifyProductBd()
    {
        try
        {
            $pdo = AccesoDatos::obtenerObjetoAcceso();
            $judgmen = $pdo->retornarConsulta('update productos set nombre = :nombre,tipo = :tipo,stock = :stock, precio = :precio,fecha_de_modificacion = :fechaModificacion where codigo_de_barra = :codigo');
            $judgmen->bindParam(":nombre",$this->nombre);
            $judgmen->bindParam(":tipo",$this->tipo);
            $judgmen->bindParam(":stock",$this->stock);
            $judgmen->bindParam(":precio",$this->precio);
            $judgmen->bindParam(":fechaModificacion",$this->fecha_de_modificacion);
            $judgmen->bindParam(":codigo",$this->codigo_de_barra);
            $judgmen->execute();
            return true;
        }
        catch(Exception $e)
        {
            print "Error". $e->getMessage();
        }
    }

    public function modifyProduct()
    {
        $ret = "No se pudo modificar el producto";
        if($this->validateProduct())
        {
            
            $prodAct = self::getProductByCode($this->codigo_de_barra);
            if($prodAct != null)
            {
                
                $prodAct->nombre = $this->nombre;
                $prodAct->tipo = $this->tipo;
                $prodAct->stock = $this->stock;
                $prodAct->precio = $this->precio;
                $prodAct->fecha_de_modificacion = date("Y,m,d");
                $prodAct->modifyProductBd();
                $ret = "Producto modificado";
            }
        }
        return $ret;
        
    }




}


?>