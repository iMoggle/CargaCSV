<?php

/**
 * Created by PhpStorm.
 * User: Francisco Javier Montiel
 * Date: 16/03/2017
 * Time: 04:44 PM
 */
class CargadorContabilidad
{
    private $mensaje;

    public function __get($propiedad)
    {
        if (property_exists($this, $propiedad)) {
            return $this->$propiedad;
        }
    }

    private function generarMensaje($mensaje)
    {
        $codigo_error = $mensaje[0];

        switch ($codigo_error) {
            case 0:
                $this->mensaje = "La operacion fue realizada satisfactoriamente.";
                break;

            case 1:
                $this->mensaje = "Ya existe un archivo con ese nombre.";
                break;

            default:
                $this->mensaje = $mensaje[1];
                break;
        }
    }

    private function cargarCsv()
    {

    }

    private function cargarXls()
    {

    }

    private function cargarArchivo($archivo)
    {
        $_str_cadena = "";
        //if there was an error uploading the file
        if ($archivo["file"]["error"] > 0) {
            $this->generarMensaje(array(-1, $_FILES["file"]["error"]));
            return false;
        } else {
            //Print file details
            $_str_cadena = "Upload: " . $archivo["file"]["name"] . "<br />";
            $_str_cadena .= "Type: " . $archivo["file"]["type"] . "<br />";
            $_str_cadena .= "Size: " . ($archivo["file"]["size"] / 1024) . " Kb<br />";
            $_str_cadena .= "Temp file: " . $archivo["file"]["tmp_name"] . "<br />";

            //if file already exists
            if (file_exists("upload/" . $archivo["file"]["name"])) {
                $this->generarMensaje(1);
                return false;
            } else {
                //Store file in directory "upload" with the name of "uploaded_file.txt"
                $storagename = $_FILES["file"]["name"];
                move_uploaded_file($archivo["file"]["tmp_name"], "uploads/" . $storagename);
                $_str_cadena .= "Stored in: " . "uploads/" . $_FILES["file"]["name"] . "<br />";
                $this->generarMensaje(array(-1, $_str_cadena));
                return true;
            }
        }
    }

    public function procesarArchivo($archivo)
    {
        if ($this->cargarArchivo($archivo)) {
            $extension = strtolower(pathinfo($archivo['file']['name'], PATHINFO_EXTENSION));

            switch ($extension) {
                case "csv":
                    $this->cargarCsv();
                    break;
                case "xls":
                    $this->cargarXls();
                    break;
                default:
                    break;
            };
            return true;
        } else {
            return false;
        }
    }
}