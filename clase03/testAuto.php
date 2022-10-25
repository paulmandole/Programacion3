<?php
    require_once "ejercicio19.php";
    require_once "manejadorDeArchivos.php";


    $archivo = new ArchivosCsv("./autos.csv");

   // $autos = Auto::cargarAutosDesdeArchivo();
    // $autos = [new Auto("ford","rojo"),new Auto("ford","azul")
    // ,new Auto("ford","rojo",15500.25),new Auto("rover","naranja",35500.36),
    // new Auto("tesla","azul",25000.25,"05-12-2022"),new Auto("mercedes","rojo",3550.36,"08-03-2015")];

    //Auto::altaAutos($autos);
    foreach($autos as $item)
    {
        
        echo Auto::mostrarAuto($item);
        echo "<br>";
    }
    // $auto4->agregarImpuestos(1500);
    // $auto5->agregarImpuestos(1500);
    // $auto6->agregarImpuestos(1500);

    // echo $auto1->ecuals($auto2);
    // echo "<br><br>";
    // echo $auto4->add($auto3);

    // if($auto1->ecuals($auto3))
    // {
    //     echo "<br>el precio del auto es:",$auto1->add($auto3);
    // }

    // echo Auto::mostrarAuto($auto1);
    // echo "<br><br>";
    // echo Auto::mostrarAuto($auto3);
    // echo "<br><br>";
    // echo Auto::mostrarAuto($auto5);

   
    
    

?>