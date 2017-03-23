<?php

/**
 * Created by PhpStorm.
 * User: MAEUSOGO
 * Date: 17/03/2017
 * Time: 04:17 PM
 */
class Archivo
{
    private $_nombre;
    private $_ubicacion;
    private $_tipo;
    private $_fecha_carga;
    private $_tipo_banco;

    public function __construct($nombre, $ubicacion, $tipo, $fecha, $tipo)
    {
        $this->_nombre = $nombre;
        $this->_ubicacion = $ubicacion;
    }

    public function __set($name, $value)
    {
        switch ($name) {
            case "nombre":
                $this->_nombre = $value;
                break;
            case "ubicacion":
                $this->_ubicacion = $value;
                break;
            case  "tipo":
                $this->_tipo = $value;
                break;
            case "fecha":
                $this->_fecha_carga = $value;
                break;
            case "banco":
                $this->_tipo_banco = $value;
                break;
        }
    }

    public function __get($name)
    {
        switch ($name) {
            case "nombre":
                return $this->_nombre;
                break;
            case "ubicacion":
                return $this->_ubicacion;
                break;
            case  "tipo":
                return $this->_tipo;
                break;
            case "fecha":
                return $this->_fecha_carga;
                break;
            case "banco":
                return $this->_tipo_banco;
                break;
        }
    }
}