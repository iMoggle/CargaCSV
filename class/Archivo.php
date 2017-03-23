<?php

/**
 * Created by PhpStorm.
 * User: MAEUSOGO
 * Date: 17/03/2017
 * Time: 04:17 PM
 */
class Archivo
{
    private $nombre;
    private $ubicacion;
    private $extension;
    private $_tipo;
    private $_fecha_carga;
    private $_tipo_banco;

    public function __construct($nombre, $ubicacion, $tipo, $fecha, $tipo)
    {
        $this->nombre = $nombre;
        $this->ubicacion = $ubicacion;
    }

    public function __get($propiedad)
    {
        if (property_exists($this, $propiedad)) {
            return $this->$propiedad;
        }
    }

    public function __set($propiedad, $valor)
    {
        if (property_exists($this, $propiedad)) {
            $this->$propiedad = $valor;
        }
    }
}