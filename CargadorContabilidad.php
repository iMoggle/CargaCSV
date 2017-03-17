<?php

/**
 * Created by PhpStorm.
 * User: Francisco Javier Montiel
 * Date: 16/03/2017
 * Time: 04:44 PM
 */
class CargadorContabilidad
{
    private $_mensaje_error;

    private function generarMensaje($mensaje)
    {
        $codigo_error = $mensaje[0];

        switch ($codigo_error) {
            case 0:
                $this->_mensaje_error = "La operacion fue realizada satisfactoriamente.";
                break;

            case 1:
                $this->_mensaje_error = "Ya existe un archivo con ese nombre.";
                break;

            default:
                $this->_mensaje_error = $mensaje[1];
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
        //if there was an error uploading the file
        if ($archivo["file"]["error"] > 0) {
            $this->generarMensaje(array(null, $_FILES["file"]["error"]));
            return false;
        } else {
            //Print file details
            echo "Upload: " . $archivo["file"]["name"] . "<br />";
            echo "Type: " . $archivo["file"]["type"] . "<br />";
            echo "Size: " . ($archivo["file"]["size"] / 1024) . " Kb<br />";
            echo "Temp file: " . $archivo["file"]["tmp_name"] . "<br />";

            //if file already exists
            if (file_exists("upload/" . $archivo["file"]["name"])) {
                $this->generarMensaje(1);
                return false;
            } else {
                //Store file in directory "upload" with the name of "uploaded_file.txt"
                $storagename = "uploaded_" . date('y-m-d') . "_" . date('hi.s') . "txt";
                move_uploaded_file($archivo["file"]["tmp_name"], "uploads/" . $storagename);
                echo "Stored in: " . "uploads/" . $_FILES["file"]["name"] . "<br />";
                $this->generarMensaje(0);
                return true;
            }
        }
    }

    public function procesarArchivo($archivo)
    {
        if ($this->cargarArchivo($archivo)) {
            $extension = strtolower(pathinfo($archivo['File']['name'], PATHINFO_EXTENSION));

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
        } else {

        }
    }
}