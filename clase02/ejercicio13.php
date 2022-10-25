/**Aplicación No 13 (Invertir palabra)
Crear una función que reciba como parámetro un string ($palabra) y un entero ($max). La
función validará que la cantidad de caracteres que tiene $palabra no supere a $max y además
deberá determinar si ese valor se encuentra dentro del siguiente listado de palabras válidas:
“Recuperatorio”, “Parcial” y “Programacion”. Los valores de retorno serán:
1 si la palabra pertenece a algún elemento del listado.
0 en caso contrario. */

<?php

    $arrayPalabras= array("hola","programacion","nombre","recuperatorio","parcial");

    for($i = 0 ; $i<count($arrayPalabras);$i++)
    {
        invertirPalabra($arrayPalabras[$i],20);
        echo "<br>";
    }
    


    function invertirPalabra(string $palabra,int $max)
    {
        if(strlen($palabra)>$max ||(strcmp($palabra,"recuperatorio")!=0 &&
        strcmp($palabra,"parcial") != 0 &&strcmp($palabra,"programacion")))
        {
            echo "palabra invalida tamanio exedido o no esta en el listado";
            return 1;
        }
        else
        {
            echo "palabra valida esta en el listado y es: ", $palabra;
            return 0;
        }
    }


?>