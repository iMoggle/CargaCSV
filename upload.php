<?php

include "class\CargadorContabilidad.php";


    if ( isset($_FILES["file"])) {

        $cargador = new CargadorContabilidad();
        $cargador->procesarArchivo($_FILES);
        echo $cargador->mensaje;
    } else {
        echo "No file selected <br />";
    }
?>