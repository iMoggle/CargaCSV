<?php

/**
 * Created by PhpStorm.
 * User: Francisco Javier Montiel Morán
 * Email: francisco.montiel@enlace.mx
 * Date: 17/03/2017
 * Time: 04:17 PM
 */

require_once "Alumno.php";

class Archivo
{
    const tamaño_archivo = 1024;

    private $nombre;
    private $ubicacion;
    private $temp;
    private $extension;
    private $tipo;
    private $fecha_carga;
    private $registros;
    private $encabezado_registros;

    public function __construct($archivo)
    {
        $this->nombre = $archivo["file"]["name"];
        $this->extension = pathinfo($this->nombre, PATHINFO_EXTENSION);
        $this->tipo = $archivo["file"]["type"];
        $this->tamano = $archivo["file"]["size"] / $this::tamaño_archivo;
        $this->temp = $archivo["file"]["tmp_name"];
        $this->fecha_carga = (new DateTime())->getTimestamp();
        $this->registros = array();
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

    public function getCsv()
    {
        $registros = array();
        if (($fichero = fopen($this->ubicacion, "r")) !== FALSE) {
            $nombres_campos = fgetcsv($fichero, 0, ",", "\"", "\"");
            $this->encabezado_registros = $nombres_campos;
            $num_campos = count($nombres_campos);
            while (($datos = fgetcsv($fichero, 0, ",", "\"", "\"")) !== FALSE) {
                for ($icampo = 0; $icampo < $num_campos; $icampo++) {
                    $registro[$icampo] = $datos[$icampo];
                }
                $registros[] = $registro;
            }
            fclose($fichero);
            $this->registros = $registros;
        }
    }

    public function getXls()
    {

    }

    public function getPropiedades()
    {
        return "<span>Archivo cargado: " . $this->nombre . "</span><br/><span>Tipo: " . $this->tipo . "</span><br/><span>Tamaño: " . $this->tamano . "Kb </span><br/><span>Almacenado en:" . $this->ubicacion . "</span>";
    }

    public function getNumRegistros()
    {
        return count($this->registros);
    }

    public function getTablaResultado()
    {
        $registros = $this->setTablaResultado();
        ?>
        <div id="dv_resultadostable" class="table-responsive" style="display:none">
            <table class="table table-bordered table-hover">
                <thead class="thead-inverse">
                <tr>
                    <th>Referencia Original</th>
                    <th>Numerica</th>
                    <th>Fecha</th>
                    <th>Cuenta</th>
                    <th>Descripción</th>
                    <th>Deposito</th>
                    <th>Sucursal</th>
                    <th>Numerica</th>
                    <th>Matricula</th>
                    <th>Sede</th>
                    <th>Metodo de Pago</th>
                    <th>Ultimos Digitos</th>
                    <th>Autorización</th>
                    <th>Depositos</th>
                    <th>Cubre su pago</th>
                    <th>Periodo</th>
                    <th>Factura</th>
                    <th>Nombre</th>
                    <th>Monto Colegiatura</th>
                    <th>Saldo</th>
                    <th>Adeudo</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($registros as &$registro) {
                    ?>
                    <tr>
                        <?php foreach ($registro as $campo) {
                            echo "<td>$campo</td>";
                        }
                        ?>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>
        </div>
        <?php
    }

    private function setTablaResultado()
    {
        return $this->analisisSantander();
    }

    private function analisisSantander()
    {

        $registros_analizados = array();
        foreach ($this->registros as $registro) {
            $elemento = array_fill(0, 21, '0');
            $referencia_ori = trim($registro[8]);
            $referencia_limpia = $this->limpiarDato(1, $registro[8]);
            $alumno = Alumno::load($referencia_limpia);
            if ($alumno != null) {
                $registro[8] = $alumno->matricula;
                $elemento[9] = $alumno->sede;
                $elemento[17] = $alumno->getNombreCompleto();
            }
            $elemento[0] = $referencia_ori;
            $elemento[1] = trim($registro[8]);
            $elemento[2] = trim($registro[1]);
            $elemento[3] = trim($registro[0]);
            $elemento[4] = trim($registro[4]);
            if (trim($registro[5]) == '+') {
                $elemento[5] = "<span class='label label-success'>+</span> $" . trim($registro[6]);
            } else {
                $elemento[5] = "<span class='label label-warning'>-</span> $" . trim($registro[6]);
            }
            $elemento[6] = trim($registro[3]);
            $elemento[7] = trim($registro[8]);
            $elemento[8] = trim($registro[8]);
            $elemento[12] = trim($registro[7]);

            $registros_analizados[] = $elemento;
        }
        return $registros_analizados;
    }

    private function limpiarDato($tipo, $valor)
    {
        switch ($tipo) {
            case 1: //limpiarReferencia
                $valor = str_replace("000000000", '', $valor);
                $dato_limpio = trim(substr($valor, 0, 11));
                break;
            default:
                $dato_limpio = "0";
                break;
        }
        return $dato_limpio;
    }

    public function checkExiste($ubicacion)
    {
        if (file_exists($ubicacion . "/" . $this->nombre)) {
            return true;
        } else {
            return false;
        }
    }

    private function analisisBanamex()
    {

    }
}