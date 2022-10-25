/**Aplicación No 19 (Auto)
Realizar una clase llamada “Auto” que posea los siguientes atributos

privados: _color (String)
_precio (Double)
_marca (String).
_fecha (DateTime)

Realizar un constructor capaz de poder instanciar objetos pasándole como

parámetros: i. La marca y el color.
ii. La marca, color y el precio.
iii. La marca, color, precio y fecha.

Realizar un método de instancia llamado “AgregarImpuestos”, que recibirá un doble
por parámetro y que se sumará al precio del objeto.
Realizar un método de clase llamado “MostrarAuto”, que recibirá un objeto de tipo “Auto”
por parámetro y que mostrará todos los atributos de dicho objeto.
Crear el método de instancia “Equals” que permita comparar dos objetos de tipo “Auto”. Sólo
devolverá TRUE si ambos “Autos” son de la misma marca.
Crear un método de clase, llamado “Add” que permita sumar dos objetos “Auto” (sólo si son
de la misma marca, y del mismo color, de lo contrario informarlo) y que retorne un Double con
la suma de los precios o cero si no se pudo realizar la operación.
Ejemplo: $importeDouble = Auto::Add($autoUno, $autoDos);
Crear un método de clase para poder hacer el alta de un Auto, guardando los datos en un
archivo autos.csv.
Hacer los métodos necesarios en la clase Auto para poder leer el listado desde el archivo
autos.csv
Se deben cargar los datos en un array de autos.
En testAuto.php:
● Crear dos objetos “Auto” de la misma marca y distinto color.
● Crear dos objetos “Auto” de la misma marca, mismo color y distinto precio.
● Crear un objeto “Auto” utilizando la sobrecarga restante.
● Utilizar el método “AgregarImpuesto” en los últimos tres objetos, agregando $ 1500
al atributo precio.
● Obtener el importe sumado del primer objeto “Auto” más el segundo y mostrar el
resultado obtenido.
● Comparar el primer “Auto” con el segundo y quinto objeto e informar si son iguales o
no.
● Utilizar el método de clase “MostrarAuto” para mostrar cada los objetos impares (1, 3,
5) */ 

<?php

    echo "<br><br> resolucion: <br>";
    class Auto
    {
        private $_color;
        private $_precio;
        private $_marca;
        private $_fecha;

        function __construct($marca,$color,$precio = 0, $fecha = "05/09/2022")
        {
            $this->_marca = $marca;
            $this->_color = $color;
            $this->_precio = $precio;
            $this->_fecha = $fecha;
        }

        
        

        public function agregarImpuestos($precioAgregar)
        {
            $this->_precio += $precioAgregar;
        }

        public static function mostrarAuto($auto)
        {
            $datos = "Color:". $auto->_color . "<br>". "Marca:" . $auto->_marca  . "<br>" . "Precio:" . strval($auto->_precio) . "<br>". "Fecha: " . $auto->_fecha . "<br>";
            return $datos;
        }

        public function ecuals($auto)
        {
            $ret =  false;
            if($this->_marca == $auto->_marca)
            {
                $ret = true;
            }
            return $ret;
        }

        public function add($auto)
        {
            $ret = 0;
            //self para llamar metodos dentro de la propia clase
            if(self::ecuals($auto) && !strcmp($this->_color,$auto->_color))
            {
                $ret = $this->_precio + $auto->_precio;
            }
            
            return $ret;
        }


        public function __toString()
        {
            return $this->_marca .",".  $this->_color .",". strval($this->_precio).",".  $this->_fecha .",";
        }


        public static function altaAutos($autos ,$path)
        {
            $ret = false;
            $archivo = new ArchivosCsv($path);
            $contenido= "Marca,Color,Precio,Fecha\n";
            foreach($autos as $item)
            {
                $contenido .= $item->_marca .",". $item->_color .",".strval($item->_precio).",".$item->_fecha . PHP_EOL;   
            }
            if($archivo->guardarEnArchivo($contenido))
                $ret = true;

            return $ret;

        } 

        public static function cargarAutosDesdeArchivo($path)
        {
            $contenido = null;
            $arrayAutos = [];

            $archivo = new ArchivosCsv($path);

            $contenido =  $archivo->leerArchivos();

            for($i = 1 ; $i<count($contenido); $i++)
            {
                if(!empty($contenido[$i]))
                {                
                    $objeto = explode(",",$contenido[$i]);
                    array_push($arrayAutos,new Auto($objeto[0],$objeto[1],$objeto[2],$objeto[3]));
                }
                
            }
            
            return $arrayAutos;
            
        }




    }

?>

