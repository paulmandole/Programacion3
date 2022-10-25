<?php
    require_once  "ejercicio19.php";
    require_once  "ejercicio20.php";
    require_once "manejadorDeArchivos.php";

    $garages = Garage::cargarGaragesDeArchivo();
    // $garages =  [new Garage("amesos s.a",250),new Garage("paul s.a",500),new Garage("rene s.a",150),
    // new Garage("perro s.a",30),new Garage("gato s.a",3000)];
    // $auto1 = new Auto("ford","rojo");
    // $auto2 = new Auto("ford","azul");
    // $auto3 = new Auto("ford","rojo",15500.25);
    // $auto4 = new Auto("rover","naranja",35500.36);
    // $auto5 = new Auto("tesla","azul",25000.25,"05-12-2022");
    // $auto6 = new Auto("mercedes","rojo",3550.36,"08-03-2015");


    // foreach($garages as $item)
    // {
    //     echo $item->add($auto1);
    //     echo $item->add($auto2);
    //     echo $item->add($auto3);
    //     echo $item->add($auto4);
    //     echo $item->add($auto5);
    //     echo $item->add($auto6);
    // }

        //Garage::guardarGaragesEnArchivo($garages);//guardo en archivos de garajes y los autos
    foreach($garages as $item)
    {
        echo $item->mostrarGarage();
    }
    

    


?>