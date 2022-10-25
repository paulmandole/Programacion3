<?php

class Validar
{
    public static function validarMail($mail)
    {
        $ret = false;
        $acept = "/^([a-zA-Z0-9\.]+@+[a-zA-Z]+(\.)+[a-zA-Z]{2,3})$/";
        if(preg_match($acept,$mail))
            $ret = true;
        
        return $ret;
    }

    public static function validarDni($dni)
    {
        $ret = false;
        $acept = "/\d{8}/";
        if(preg_match($acept,$dni) && strlen($dni) == 8)
            $ret = true;

        return $ret;    
    }

    public static function validarFecha($fecha)
    {
        $ret = false;
        //$acept = "/^\d\d\d\d[\/:-]\d\d[\/:-]\d\d$/";
        $acept = "/^\d\d\d\d[-]\d\d[-]\d\d$/";
        if(preg_match($acept,$fecha))
            $ret = true;
        return $ret; 
    }

    public static function validarId($id)
    {
        $ret = false;
        $acept = "/\d{1,5}/";
        if(preg_match($acept,$id) && (strlen($id) <= 5 && strlen($id) >= 1))
            $ret = true;

        return $ret;
    }

    public static function validarNombre($nombre)
    {
        $ret = false;
        $acept = "/^[a-zA-Z ]{3,20}$/";
        if(preg_match($acept,$nombre) && strlen($nombre) <= 30)
            $ret = true;

        return $ret; 
    }

    public static function validarCodigoBarras($codigo)
    {
        $ret = false;
        $acept = "/\d{6}/";
        if(preg_match($acept,$codigo) && strlen($codigo) == 6)
            $ret = true;

        return $ret;
    }

    public static function validarDirectorio($directorio)
    {
        $ret = false;
        if(!is_dir($directorio))
        {
            mkdir($directorio, 0777, true);
            //echo "directorio creado con exito".$directorio;
            $ret = true;
        }
        else
        {
            //echo "el directorio:".$directorio ." ya existe";
            $ret = true;
        }
        return $ret;
    }

    public static function validarArchivo($path)
    {
        $ret = false;
        if(file_exists($path))
            $ret = true;
        return $ret;
    }
    
    public static function obtenerDirectorio($path)
    {
        $directorio = explode("/",$path);
        $directString = "./";
        for($i = 0;$i<count($directorio)-1;$i++)
        {
            if(!empty($directorio[$i]) && strcmp($directorio[$i],"."))
                $directString .= $directorio[$i] . "/";
        }
        return $directString;
    }

    public static function validateExtension($archivo)
    {
        $extension = explode(".",$archivo);
        $ext = array_pop($extension);
        if($ext == "jpg" || $ext == "img" || $ext == "jpeg")
            return true;
        
       
    }

    public static function validateSize($sizeArchivo , $max)
    {
        if($sizeArchivo < $max)
            return true;
    }
    

    public static function validateFile($file)
    {
        
        if(is_array($file) && count($file) == 1)
        {
            if(self::validateExtension($file['archivo']['name']) && self::validateSize($file['archivo']['size'],300000))
                return true;
        }
    }
}
?>