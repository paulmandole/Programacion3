<?php
//paul mandole Ejercicio1
//este codigo lo va a interpretar el Servidor apache
    //echo "Hola mundo";//forma de mostrar
    $maximo = 1000;
    $cont = 0;
    $suma = 0;

    while(($suma + $cont) < 1000)
    {
        $cont++;
        $suma += $cont;
        echo "Numero Sumado",$cont;
        echo "<br>";
        

    }
    
    echo " total de numeros sumados:",$cont;
    echo "Suma total:",$suma;


?>
