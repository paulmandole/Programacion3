<?php

class ArchivosJson
{
    private $_path;

    public function __construct($path)
    {
       
        if(Validar::validarArchivo($path))
        {
            $this->_path = $path;
        }
        else if(Validar::validarDirectorio(Validar::obtenerDirectorio($path)))
        {
            $this->_path = $path;
            $archivo = fopen($this->_path,'w');
            fclose($archivo);
        }
    }

    public function getPath()
    {
        return $this->_path;
    }

    public function leerEnArchivo()
    {
        $contenido = null;
        $archivo =  fopen($this->_path,'r');
        if(filesize($this->_path)>0)
            $contenido = fread($archivo,filesize($this->_path));
            
        fclose($archivo);
        return  $contenido;
    }
   
    function guardarEnArchivo($contenido)
    {
        $ret = false;

        $archivo = fopen($this->_path,'w');

        if(fwrite($archivo,$contenido))
            $ret = true;

        fclose($archivo);
        

        return $ret;
    }
    function agregarEnArchivo($contenido)
    {
        $ret = false;

        $archivo = fopen($this->_path,'a');

        if(fwrite($archivo,$contenido))
            $ret = true;
        fclose($archivo);

        return $ret;
    }
    public static function guardarFoto($from)
    {
        
        if(Validar::validarDirectorio("./usuario/fotos/"))
        {
            $destino = "./usuario/fotos/" . $from;
            if(move_uploaded_file($_FILES["foto"]["tmp_name"], $destino))
            return $destino;
        }
    }

    public function validateSize($from)
    {
        
    }

}
?>