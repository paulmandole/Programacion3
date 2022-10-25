<?php
    

    class DeleteSale
    {
        public static function delete($pedido)
        {
            $query = "DELETE FROM ventas_pizzas where numero_pedido = $pedido";
            $pdo =  AccesoDatos::obtenerObjetoAcceso();
            $judgment = $pdo->retornarConsulta($query);
            if($judgment->execute())
                return true;
        }
    }


?>