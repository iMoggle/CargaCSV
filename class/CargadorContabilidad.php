<?php

/**
 * Created by PhpStorm.
 * User: Francisco Javier Montiel
 * Date: 16/03/2017
 * Time: 04:44 PM
 */

include "Archivo.php";

const nombre_carpeta_carga = "uploads";

class CargadorContabilidad
{
    private $mensaje;
    private $archivo_movimientos;
    private $archivo_cpagos;
    private $archivo_cautomaticos;

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
        $this->archivo_movimientos->getCsv();
    }

    private function cargarXls()
    {
        $this->archivo_movimientos->getXls();
    }

    private function cargarArchivo($archivo)
    {
        //Si hay un error cargando el archivo
        if ($archivo["file"]["error"] > 0) {
            $this->generarMensaje(array(-1, $_FILES["file"]["error"]));
            return false;
        } else {
            $this->archivo_movimientos = new Archivo($archivo);
            //Checa si el archivo existe
            if ($this->archivo_movimientos->checkExiste(nombre_carpeta_carga)) {
                $this->generarMensaje(array(1, null));
                return false;
            } else {
                //Guardamos el archivo con el nombre original en la carpeta Upload
                $nombre_almacenamiento = $this->archivo_movimientos->nombre;
                $path_almacenamiento = nombre_carpeta_carga . "/" . $nombre_almacenamiento;
                move_uploaded_file($this->archivo_movimientos->temp, $path_almacenamiento);
                $this->archivo_movimientos->ubicacion = $path_almacenamiento;
                //Se imprimen los detalles
                $this->generarMensaje(array(-1, $this->archivo_movimientos->getPropiedades()));
                return true;
            }
        }
    }

    public function procesarArchivo($archivo)
    {
        if ($this->cargarArchivo($archivo)) {
            switch ($this->archivo_movimientos->extension) {
                case "csv":
                    $this->cargarCsv();
                    break;
                //En ambos casos (xls, xlsx) se usa el mismo metodo.
                case "xls":
                case "xlsx":
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

    public function getTablaResultado()
    {
        return $this->archivo_movimientos->getTablaResultado();
    }
}