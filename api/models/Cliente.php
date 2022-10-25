<?php

    require_once "connections/Connections.php";

    class Cliente
    {

        //trae lo de la base de datos 
        public static function getAll()
        {
            $db = new Connection();
            $query = 'SELECT * FROM clientes';
            $resultado = $db->query($query);
            $datos = [];
            if($resultado->num_rows)
            {
                while($row = $resultado->fetch_assoc())
                {
                    $datos[] = [
                        'id' => $row['id'],
                        'nombre' => $row['nombre'],
                        'ap' => $row['ap'],
                        'am' => $row['am'],
                        'fn' => $row['fn'],
                        'genero' => $row['genero']
                    ];
                }
            }
            return $datos;
            
        }

        public static function getWhere($id_cliente)
        {
            $db = new Connection();
            //ver esta forma de hacer consultas
            $query = "SELECT * FROM clientes WHERE id = $id_cliente";
            $resultado = $db->query($query);
            $datos = [];
            if($resultado->num_rows)
            {
                while($row = $resultado->fetch_assoc())
                {
                    $datos[] = [
                        'id' => $row['id'],
                        'nombre' => $row['nombre'],
                        'ap' => $row['ap'],
                        'am' => $row['am'],
                        'fn' => $row['fn'],
                        'genero' => $row['genero']
                    ];
                }
            }
            return $datos;
            
        }

        public static function insert($nombre, $ap, $am, $fn, $genero)
        {
            $db = new Connection();
            $query = "INSERT INTO clientes (nombre, ap, am, fn, genero)
             VALUES ('".$nombre."','".$ap."','".$am."','".$fn."','".$genero."')";
             $db->query($query);

             if($db->affected_rows)
             {
                return true;
             }
             return false;
        }

        public static function update($id_cliente, $nombre, $ap, $am, $fn, $genero)
        {
            $db = new Connection();
            $query = "UPDATE  clientes SET nombre = '".$nombre."', ap = '".$ap."', am = '".$am."', fn ='".$fn."', genero = '".$genero."' WHERE id = $id_cliente ";
            $db->query($query);

             if($db->affected_rows)
             {
                return true;
             }
             return false;
        }

        public static function delete($id_cliente)
        {
            $db = new Connection();
            $query = "DELETE FROM clientes WHERE id = $id_cliente";
            $db->query($query);

            if($db->affected_rows)
            {
                return true;
            }
            return false;

        }

    }



?>