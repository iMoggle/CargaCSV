<?php

/**
 * Created by PhpStorm.
 * User: Francisco Javier Montiel Morán
 * Email: francisco.montiel@enlace.mx
 * Date: 29/03/2017
 * Time: 08:25 AM
 */

require_once("db/functions_db_ms.php");
require_once("Sede.php");

class Alumno
{
    private $matricula;
    private $id_alumno;
    private $nombre;
    private $appaterno;
    private $apmaterno;
    private $saldo;

    private $oferta_educativa;
    private $generacion;
    private $refencia;

    //Probablemente estos dos casos se conviertan en clases
    private $sede;
    private $tutor;

    public function __construct($ref_alumno)
    {
        $query = "select id_alumno,
        upper(alumno.nombre) as nombre,
        upper(ap_pat) as ap_pat,
        upper(ap_mat) as ap_mat,
        clave_alumno,
        oferta_educativa_id_oferta_educativa,
        upper(ifnull(sede.nombre,' ')) as nombre_sede,
        upper(ifnull(concat(tutor.nombre,' ',tutor.apellido_paterno,' ',tutor.apellido_materno),' ')) as nombre_tutor,
        ifnull(adeudos.saldo_deudor,0) as adeudo
        from alumno
        left join adeudos on alumno.clave_alumno = adeudos.matricula
        left join sede on alumno.id_sede = sede.id_sede
        left join tutor on alumno.id_tutor = tutor.id_tutor
        where clave_alumno =$ref_alumno;";

        $datos = arreglo(query($query));

        if ($datos <> null) {
            $this->id_alumno = $datos[0];
            $this->nombre = $datos[1];
            $this->appaterno = $datos[2];
            $this->apmaterno = $datos[3];
            $this->matricula = $datos[4];
            $this->oferta_educativa = $datos[5];
            $this->sede = $datos[6];
            $this->tutor = $datos[7];
            $this->saldo = $datos[8];
        }
    }

    public static function load($ref_alumno)
    {
        if (is_numeric($ref_alumno)) {

            try {
                return new Alumno($ref_alumno);
            } catch (Exception $e) {
                return null;
            }
        } else {
            return null;
        }
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

    public function getNombreCompleto()
    {
        $nombre = $this->nombre . " " . $this->appaterno . " " . $this->apmaterno;
        return $nombre;
    }

    public function getSedeTutor()
    {
        return $this->tutor . " | " . $this->sede;
    }

    public function getColegiatura()
    {
        $query = 'SELECT colegiaturas.colegiatura_inscripcion, oferta_educativa.nombre
        FROM alumno
        LEFT JOIN colegiaturas ON alumno.oferta_educativa_id_oferta_educativa = colegiaturas.id_oferta AND colegiaturas.grado = 1
        LEFT JOIN oferta_educativa ON alumno.oferta_educativa_id_oferta_educativa = oferta_educativa.id_oferta_educativa AND oferta_educativa.estatus = \'activa\'
        WHERE alumno.id_alumno = ' . $this->id_alumno;

        $datos = arreglo(query($query));

        if ($datos <> null) {
            return $datos[0];
        } else
            return 0;
    }
}