/*Aplicación No 12 (Invertir palabra)
Realizar el desarrollo de una función que reciba un Array de caracteres y que invierta el orden
de las letras del Array.
Ejemplo: Se recibe la palabra “HOLA” y luego queda “ALOH”. */
<?php


    $palabraAInvertir = array( 'h','o','l','a');
    $palabraConvertida = invertidorDeOrden($palabraAInvertir);

    mostrarPalabra($palabraConvertida);

    function invertidorDeOrden(array $arrayPalabra)
    {
        $arrayAux = null;
        $cont = 0;
       
        for($i = count($arrayPalabra)-1;$i >= 0 ;$i--)
        {
            $arrayAux[$cont] = $arrayPalabra[$i];
            $cont++;
        }
        return $arrayAux;
    }

    function mostrarPalabra(array $palabra)
    {
        $mostrar = null;
        for($i = 0 ; $i<count($palabra);$i++)
        {
            $mostrar =$mostrar . $palabra[$i];
        }
        echo $mostrar;
        
    }

?>