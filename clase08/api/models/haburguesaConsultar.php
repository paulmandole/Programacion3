<?php

    class HamburguesaConsultar
    {


        public static function thereAreStock($nombre, $tipo)
        {
            
        }

        /**
         * verifica si existe la hamburguesa en el archivo
         * retorna true si existe
         */
        public static function existHamburger($hamburger)
        {
            $hamburguers = self::getHamburgers();
            foreach($hamburguers as $item)
            {
                if($item->ecuals($hamburger))
                    return true;
            }
        }

       


        /**
         * obtiene las hamburguesas de un archivo json
         * returna un array de objetos hambuerguesa
         */
        public static function getHamburgers()
        {
            $hamburgers = [];
            $archivo = new ArchivosJson("api/Archivos/hamburguesas.json");
            $array = json_decode($archivo->leerEnArchivo(),true);
            if(is_array($array) && !empty($array))
            {
                if(count($array,true) == 5)
                {
                    array_push($hamburgers,HamburguesaCarga::desSerializeHamburger($array));
                }
                else
                {
                    foreach($array as $item)
                    {
                        if(!empty($item));
                            array_push($hamburgers,HamburguesaCarga::desSerializeHamburger($item));
                    }
                }  
            }
            return $hamburgers;
        }


    }

?>