<?php

/**
 * Created by PhpStorm.
 * User: FranciscoJavier
 * Date: 31/03/2017
 * Time: 01:18 PM
 */
class Sede
{
    private $id_sede;
    private $nombre;
    private $horario;
    private $descripcion;

    //Probablemente tambien se convierta en clase
    private $direccion;
    private $coordinador;

    public function __construct($ref_sede)
    {
        $query = 'SELECT sede.id_sede AS id_sede, upper(sede.nombre) AS nombre, horario, descripcion, direccion_id_direccion,
        upper(concat( coord_sede.nombre, " ", coord_sede.apellido_paterno, " ", coord_sede.apellido_materno)) AS coordinador
        FROM sede
        LEFT JOIN
        (
        SELECT DISTINCT sede_has_tutor.sede_id_sede AS id_sede, tutor.nombre, tutor.apellido_paterno, tutor.apellido_materno
        FROM tutor_has_tutor
        INNER JOIN sede_has_tutor ON tutor_has_tutor.tutor_padre = sede_has_tutor.tutor_id_tutor
        INNER JOIN tutor ON tutor_has_tutor.tutor_padre = tutor.id_tutor
        ) AS coord_sede ON sede.id_sede = coord_sede.id_sede WHERE sede.id_sede="$ref_sede";';

        $datos_sede = arreglo(query($query));

        if ($datos_sede <> null) {
            $this->id_sede = $datos_sede[0];
            $this->nombre = $datos_sede[1];
            $this->horario = $datos_sede[2];
            $this->descripcion = $datos_sede[3];
            $this->direccion = $datos_sede[4];
            $this->coordinador = $datos_sede[5];
        }
    }

    public function __set($propiedad, $valor)
    {
        if (property_exists($this, $propiedad)) {
            $this->$propiedad = $valor;
        }
    }

    public function __get($name)
    {
        // TODO: Implement __get() method.
    }

    public function getSedeCoordinaror()
    {
        return $this->nombre . " | " . $this->coordinador;
    }
}