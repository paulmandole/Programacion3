<?php
include_once "../../biblioteca/archivosJson.php";
include_once "../../biblioteca/validaciones.php";

class Pizza
{
    private $id;
    private $sabor;
    private $precio;
    private $tipo;
    private $cantidad;
    private $foto;


    public function __construct($sabor,$precio,$tipo,$cantidad, $id , $foto = "")
    {
        if(is_string($sabor) && $cantidad > -1 && is_string($tipo) && ($tipo == "molde" || $tipo == "piedra"))
        {
            $this->sabor = $sabor;
            $this->precio = $precio;
            $this->tipo = $tipo;
            $this->cantidad = $cantidad;
            $this->id = $id;
            $this->foto = $foto;
        }
    }
    public function getId()
    {
        return $this->id;
    }
    public static function quitStock($stock,$sabor,$tipo)
    {
        $ret = false;
        $pizzasSaves = self::getPizzasOfJson();
        $index = self::getIndexPizzaByTasteAndType($sabor,$tipo);
        if($stock <= $pizzasSaves[$index]->cantidad)
        {
            $pizzasSaves[$index]->cantidad -= $stock;
            self::savePizzasJson($pizzasSaves);
            $ret = true;
        }
        return $ret;
    }

    private static function savePizzasJson($pizzas)
    {
        $arraySerializado = [];
        $archivo = new ArchivosJson("./Archivos/Pizza.json");
        foreach($pizzas as $item)
        {
            array_push($arraySerializado,$item->serializePizzaJson());
        }
        $cont = json_encode($arraySerializado);
        if($archivo->guardarEnArchivo($cont))
            return true;
    }

    public function ecuals($pizza)
    {
        $ret = false;
        if(is_a($pizza,"Pizza") && $this->sabor == $pizza->sabor && $this->tipo == $pizza->tipo)
         {
            $ret = true;
         }   
        return $ret;
    }

    public function isNewPizza()
    {
        $ret = true;
        $pizzasSaves = self::getPizzasOfJson();
        foreach($pizzasSaves as $pizza)
        {
            if($this->ecuals($pizza))
            {
                $ret = false;  
                break;
            }
                  
        }
        return $ret;
    }

    private function getIndexPizza()
    {
        $ret = -1;
        $pizzasSaves = self::getPizzasOfJson();
        for($i = 0 ; $i < count($pizzasSaves); $i++)
        {
            if($this->ecuals($pizzasSaves[$i]))
                $ret = $i;    
        }
        return $ret;
    }

    public function savePizza()
    {
        $ret =  "no se pudo guardar";
        if($this->isNewPizza())
        {
            $pizzasSaves = self::getPizzasOfJson();
            array_push($pizzasSaves,$this);
            //agregar la foto

            $this->saveFile();
            if(self::savePizzasJson($pizzasSaves))
                $ret = "se guardo la nueva pizza <br>";
        }
        else
        {
            $index = $this->getIndexPizza();
            $pizzasSaves = self::getPizzasOfJson();
            $pizzasSaves[$index]->cantidad += $this->cantidad;
            $pizzasSaves[$index]->precio = $this->precio;
            if(self::savePizzasJson($pizzasSaves))
                $ret = "se actualizo la cantidad y precio de pizza<br>";
        }
        return $ret;
    }

    private function serializePizzaJson()
    {
        return $array = Array(
            'id' => $this->getId(),
            'sabor' => $this->sabor,
            'precio' => $this->precio,
            'tipo' => $this->tipo,
            'cantidad' =>$this->cantidad
        );
    }

    

    private static function getIndexPizzaByTasteAndType($sabor,$tipo)
    {
        $pizzasSaves = self::getPizzasOfJson();
        for($i = 0 ; $i < count($pizzasSaves); $i++)
        {
            if($pizzasSaves[$i]->sabor == $sabor)
                return  $i;
        }
    }

    private static function exitsTaste($sabor)
    {
        $pizzasSaves = self::getPizzasOfJson();
        foreach($pizzasSaves as $pizza)
        {
            if($pizza->sabor == $sabor)
                return  true;
        }
    }

    private static function existType($tipo)
    {
        $pizzasSaves = self::getPizzasOfJson();
        foreach($pizzasSaves as $pizza)
        {
            if($pizza->tipo == $tipo)
                return  true;
        }
    }

    public static function therePizza($sabor , $tipo)
    {
        $ret = "si hay";
        if(!self::existType($tipo))
        {
           $ret = "no existe el tipo";
        }
        if(!self::exitsTaste($sabor))
        {
            $ret = "no existe el sabor";
        }
        return $ret;
    }
    public static function getPizzasOfJson()
    {
        $Pizzas = [];
        $archivo = new ArchivosJson("./Archivos/Pizza.json");
        $array = json_decode($archivo->leerEnArchivo(),true);
        //print_r($array);
        if(is_array($array) && !empty($array))
        {
            if(count($array,true) == 5)
            {
                array_push($Pizzas,self::desSelizaPizzaOfJson($array));
            }
            else
            {
                foreach($array as $item)
                {
                    if(!empty($item));
                        array_push($Pizzas,self::desSelizaPizzaOfJson($item));
                }
            }  
        }
        return $Pizzas;
    }
    

    private static function desSelizaPizzaOfJson($pizza)
    {
        return new Pizza($pizza["sabor"], $pizza["precio"],$pizza["tipo"],$pizza["cantidad"],$pizza["id"]);
    }




    /**estas dos no son necesarias */
    public function __toString()
    {
        return $this->getId() ."\t". $this->sabor ."\t". $this->precio ."\t". $this->tipo ."\t". $this->cantidad;
    }



    public static function showPizzas()
    {
        $ret = "LISTA DE PIZZAS:<br> ID\tSABOR\tPRECIO\tTIPO\t\t\tCANTIDAD<br>";
        $Pizzas = self::getPizzasOfJson();
        foreach($Pizzas as $pizza)
        {
            $ret .= $pizza->__toString(). "<br>";
        }
        return $ret;
    }


    public function saveFile()
    {
        $ruta = "./imagenesDePizzas/";
        $namePhoto = $this->tipo . $this->sabor . "jpg";
        if(Validar::validarDirectorio($ruta))
        {
            $destiny = $ruta . $namePhoto .".jpg";
            if(move_uploaded_file($this->foto,$destiny));
        }
    }
}

?>