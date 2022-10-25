<?php
    require_once  "ejercicio17.php";
    require_once "ejercicio18.php";

    
    $garage =  new Garage("amesos s.a",250);
    $auto1 = new Auto("ford","rojo");
    $auto2 = new Auto("ford","azul");
    $auto3 = new Auto("ford","rojo",15500.25);
    $auto4 = new Auto("rover","naranja",35500.36);
    $auto5 = new Auto("tesla","azul",25000.25,"05-12-2022");
    $auto6 = new Auto("mercedes","rojo",3550.36,"08-03-2015");



    echo $garage->mostrarGarage();

    echo "<br>--------------------------------------------<br>";

    echo $garage->add($auto1);
    echo "<br>--------------------------------------------<br>";
    echo $garage->add($auto1);
    echo "<br>--------------------------------------------<br>";
    echo $garage->add($auto2);
    echo "<br>--------------------------------------------<br>";
    echo $garage->add($auto3);
    echo "<br>--------------------------------------------<br>";
    echo $garage->add($auto4);
    echo "<br>--------------------------------------------<br>";
    echo $garage->add($auto5);
    echo "<br>--------------------------------------------<br>";
    echo $garage->add($auto5);
    echo "<br>--------------------------------------------<br>";
    echo $garage->mostrarGarage();
    echo "<br>--------------------------------------------<br>";
    echo $garage->remove($auto1);
    echo "<br>--------------------------------------------<br>";
    echo $garage->remove($auto6);
    echo "<br>--------------------------------------------<br>";
    echo $garage->mostrarGarage();


?>