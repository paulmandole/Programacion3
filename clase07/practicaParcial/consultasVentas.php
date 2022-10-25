<?php

    class ConsultationSale
    {
        public static function getSalesBetweenTwoDates($date1 , $date2)
        {
            $query = 'SELECT * FROM ventas_pizzas WHERE ventas_pizzas.fecha BETWEEN \''. $date1 .'\' and \''.$date2.'\'';
    
            $sales = Sale::getSalesBd($query);
            $ret = "Lista de ventas entre " . $date1 . " y " .$date2 ."\n<br>";
            return $ret .= self::showSales($sales);
        }
    
        /**muestra ventes del usuario */
        public static function getSalesByUser($user)
        {
            $query = 'SELECT * FROM `ventas_pizzas` WHERE ventas_pizzas.email = \'' . $user . '\' ORDER BY sabor';
            $sales = Sale::getSalesBd($query);
            $ret = "Lista de ventas del usuario " . $user. " \n<br>";
            return $ret .= self::showSales($sales);
        }
    
    
        /**muestra ventas por sabor */
        public static function getSalesBySabor($sabor)
        {
            $query = 'SELECT * FROM `ventas_pizzas` WHERE ventas_pizzas.sabor = \'' . $sabor . '\'';
            $sales = Sale::getSalesBd($query);
            $ret = "Lista de ventas del sabor " . $sabor. " \n<br>";
            return $ret .= self::showSales($sales);
        }

        private static function showSales($listSales)
        {
            $ret = "";
            foreach($listSales as $sale)
            {
                if(!empty($sale))
                    $ret .= $sale->__toString() . "\n<br>";
            }
            return $ret;
        }

        public static function getAmountPizzasSales()
        {
            $query = 'SELECT sum(cantidad) from ventas_pizzas';
    
            try
            {
                $pdo = AccesoDatos::obtenerObjetoAcceso();
                $judgmen = $pdo->retornarConsulta($query);
                $judgmen->execute();
                $array = $judgmen->fetch();
    
                return "La cantidad de pizzas vendidas es: " . $array[0];            
            }
            catch(Exception $ex)
            {
                print "ERROR" . $ex->getMessage();
            }
        }
    }


?>