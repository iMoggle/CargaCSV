<?php

/**
 * Created by PhpStorm.
 * User: Francisco Javier Montiel Morán
 * Email: francisco.montiel@enlace.mx
 * Date: 17/03/2017
 * Time: 04:17 PM
 */

include "class\CargadorContabilidad.php";


if (isset($_FILES["file"])) {

    $cargador = new CargadorContabilidad();
    if ($cargador->procesarArchivo($_FILES)) {
        echo $cargador->mensaje;
        echo $cargador->getTablaResultado();
    } else {
        echo $cargador->mensaje;
    }
} else {
    echo "No selecciono ningún documento.<br />";
}