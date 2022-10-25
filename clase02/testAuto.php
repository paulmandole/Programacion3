<?php
    require_once "ejercicio17.php";

    $auto1 = new Auto("ford","rojo");
    $auto2 = new Auto("ford","azul");
    $auto3 = new Auto("ford","rojo",15500.25);
    $auto4 = new Auto("rover","naranja",35500.36);
    $auto5 = new Auto("tesla","azul",25000.25,"05-12-2022");
    $auto6 = new Auto("mercedes","rojo",3550.36,"08-03-2015");
    
    $auto4->agregarImpuestos(1500);
    $auto5->agregarImpuestos(1500);
    $auto6->agregarImpuestos(1500);

    echo $auto1->ecuals($auto2);
    echo "<br><br>";
    echo $auto4->add($auto3);

    if($auto1->ecuals($auto3))
    {
        echo "<br>el precio del auto es:",$auto1->add($auto3);
    }

    echo Auto::mostrarAuto($auto1);
    echo "<br><br>";
    echo Auto::mostrarAuto($auto3);
    echo "<br><br>";
    echo Auto::mostrarAuto($auto5);
    
    

?>