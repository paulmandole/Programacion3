
/**Aplicación No 18 (Auto - Garage)
Crear la clase Garage que posea como atributos privados:

_razonSocial (String)
_precioPorHora (Double)
_autos (Autos[], reutilizar la clase Auto del ejercicio anterior)

Realizar un constructor capaz de poder instanciar objetos pasándole como parámetros:

i. La razón social.
ii. La razón social, y el precio por hora.

Realizar un método de instancia llamado “MostrarGarage”, que no recibirá parámetros y
que mostrará todos los atributos del objeto.
Crear el método de instancia “Equals” que permita comparar al objeto de tipo Garaje con un
objeto de tipo Auto. Sólo devolverá TRUE si el auto está en el garaje.
Crear el método de instancia “Add” para que permita sumar un objeto “Auto” al “Garage”
(sólo si el auto no está en el garaje, de lo contrario informarlo).
Ejemplo: $miGarage->Add($autoUno);
Crear el método de instancia “Remove” para que permita quitar un objeto “Auto” del
“Garage” (sólo si el auto está en el garaje, de lo contrario informarlo).
Ejemplo: $miGarage->Remove($autoUno);
En testGarage.php, crear autos y un garage. Probar el buen funcionamiento de todos los
métodos. */<br><br><br>
<?php

class Garage
{
    private $_razonSocial;
    private $_precioPorHora;
    private $_autos;

    public function __construct($razonSocial,$precioPorHora = 0)
    {   
        
        $this->_razonSocial = $razonSocial;
        $this->_precioPorHora = $precioPorHora;
        $this->_autos = [];     
        
    }

    public function mostrarGarage()
    {
        $ret = "";
        
        $ret = "<br>Razon Social: " . $this->_razonSocial . "<br>Precio por hora: " .strval($this->_precioPorHora) . "<br>";

        $ret .= "<br>Lista de autos: ";
        foreach($this->_autos as &$item)
        {
           $ret .= "<br>" . Auto::mostrarAuto($item);
        }

        return $ret;
    }

    public function ecuals($auto)
    {
        $ret = false;
        if(is_a($auto,"Auto"))
        {
            foreach($this->_autos as $item)
            {
                if($item == $auto)
                {
                    $ret = true;
                    break;
                }
            }
        }

        return $ret;
    }

    public function add($auto)
    {
        if(is_a($auto,"Auto"))
        {
            if(!$this->ecuals($auto))
            {
                array_push($this->_autos,$auto);
                $ret = "auto cargado";
            }
            else
            {
                $ret = "el auto ya se encuentra cargado en el garage";
            }
        }
        return $ret;
    }

    public function remove($auto)
    {
        $ret = "no se encuentra en el garage";
        if(is_a($auto,"Auto"))
        {
            $index = array_search($auto,$this->_autos,true);
            if($index !== false)
            {
                unset($this->_autos[$index]);
                $ret = "removido";
            }
        }
        return $ret;
    }

}


?>