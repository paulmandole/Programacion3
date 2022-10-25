<?php

    class ArchivosCsv{

        private $_path;

        public function __construct($path)
        {
            $this->_path = $path;           
           
        }

        function leerArchivos()
        {
            $contenido = null;

            $archivo =  fopen($this->_path,'r');

            $contenido = fread($archivo,filesize($this->_path));

            fclose($archivo);

            return  explode("\n",$contenido);
            
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

    }

?>