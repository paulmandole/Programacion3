<?php

    class HamburguesaCarga
    {
        private $id;
        private $nombre;
        private $precio;
        private $tipo;
        private $cantidad;
        private $imagen;
        
        /**
         * constructor
         */
        public function __construct($nombre, $precio, $tipo, $cantidad, $imagen, $id)
        {
            if(Validar::validateMin($precio , 0) && Validar::validateType($tipo) && Validar::validateMin($cantidad , 1))
            {
                $this->id = $id;
                $this->nombre = $nombre;
                $this->precio = $precio;
                $this->tipo = $tipo;
                $this->cantidad = $cantidad;
                $this->imagen = $imagen;
            }
        }

        public function getId()
        {
            return $this->id;
        } 
       
        public function ecuals($hamburger)
        {
            if(is_a($hamburger,"HamburguesaCarga") && $hamburger->tipo == $this->tipo && $hamburger->nombre == $this->nombre)
                return true;
        }


        public function addHamburguer()
        {
           $ret =  "no se pudo guardar";
           if(HamburguesaConsultar::existHamburger($this))
           {
                $index = $this->getIndexHamburger();
                $hamburgers = HamburguesaConsultar::getHamburgers();
                $hamburgers[$index]->cantidad += $this->cantidad;
                $hamburgers[$index]->precio = $this->precio;
                if(self::saveHamburgers($hamburgers))
                    $ret = "se actualizo la cantidad y precio de la Hamburguesa";
                    

                //agregar stock
           }
           else
           {
                $hamburgers = HamburguesaConsultar::getHamburgers();
                $this->saveFile();
                array_push($hamburgers,$this);
                if(self::saveHamburgers($hamburgers))
                    $ret = "se guardo la nueva hamburguesa";
                    
           }
           return $ret;
        }


        

        /**
         * guarda una lista de hamburguesas en un archivo si no existe lo crea
         * 
         * return true si se pudo guardar
         */
        private static function saveHamburgers($hamburgers)
        {
            $arraySerializado = [];
            $archivo = new ArchivosJson("api/Archivos/hamburguesas.json");
            foreach($hamburgers as $hamburger)
            {
                array_push($arraySerializado, $hamburger->serializeHamburger());
            }
            if($archivo->guardarEnArchivo(json_encode($arraySerializado)))
                return true;
        }


        /**
         * convierte un array asociativo en una hamburguesa
         * returna una hambueguesa
         */
        public static function desSerializeHamburger($hamburger)
        {
            return new HamburguesaCarga($hamburger['nombre'],$hamburger['precio'],$hamburger['tipo'],$hamburger['cantidad'],$hamburger['imagen'],$hamburger['id']);
        }

        /**
         * combierte un objeto haburguesa en un array asocitivo
         * return el array asociativo
         */
        private function serializeHamburger()
        {
            return [
                'id'=> $this->id,
                'nombre' => $this->nombre,
                'precio' => $this->precio,
                'tipo'  => $this->tipo,
                'cantidad' => $this->cantidad,
                'imagen' => $this->imagen
            ];
        }

        /**
         * obtengo el indice de la lista de la hamburguesa 
         * return el indice o -1 si no existe
         */
        public function getIndexHamburger()
        {
            $hamburgers = HamburguesaConsultar::getHamburgers();
            $ret = -1;
            for($i = 0 ; $i < count($hamburgers); $i++)
            {
                if($this->ecuals($hamburgers[$i]))
                    $ret = $i;    
            }
            return $ret;
        }

        /**
         * guarda la imagen el tipo y el nombre como identificación en la carpeta /ImagenesDeHamburguesas.
         */
        private function saveFile()
        {
            $ruta = "api/ImagenesDeHamburguesas/";
            $namePhoto = $this->nombre .' '. $this->tipo;
            if(Validar::validarDirectorio($ruta))
            {
                $destiny = $ruta . $namePhoto .".jpg";
                if(move_uploaded_file($this->imagen,$destiny))
                {
                    $this->imagen = $destiny;
                    return true;
                }
            }
        }


    }



?>