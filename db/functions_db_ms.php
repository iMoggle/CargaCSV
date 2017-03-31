<?php

/*
 * Emmanuel Isaias Zamora Rivera
 * 2013
 */

/*función que permite la conexión a la base de datos, es invocada desde
 * las funciones de base de datos, insert, select, update, etc.
 */
function conecta($tipo)
{
    $server = 'localhost';
    $port = '3306';
    $db = "enlace";
    switch ($tipo) {
        case 1://case que permite solo seleccionar
            $user = "";
            $pass = "";
            break;
        case 2://case que permite actualizar e insertar, pero no borrar
            $user = "";
            $pass = "";
            break;
        case 3://case que permite modificar todos los datos (insert, update, delete)
            $user = "enlaceuser";
            $pass = "enlaceroot";
            break;
        default://nada
            $user = "";
            $pass = "";
            break;
    }
    $conexion = mysqli_connect($server, $user, $pass, $db);
    return $conexion;
}

function cierra()
{
    mysqli_close();
}

function inserta($tabla, $cols, $values)
{
    $con = conecta(3);
    $ins = "insert into $tabla ($cols) values ($values);";
    mysqli_query($con, "SET NAMES 'utf8'");
    $res = mysqli_query($con, $ins);
    return $ins;
}

function select($campos, $tabla, $cond)
{
    $con = conecta(3);
    $sel = 'select ' . $campos . ' from ' . $tabla . ' where ' . $cond . '';

    mysqli_query($con, "SET NAMES 'utf8'");
    $res = mysqli_query($con, $sel);
    return $res;
}

function update($tabla, $valor, $cond)
{
    $con = conecta(3);
    mysqli_query($con, "SET NAMES 'utf8'");
    $upd = "update $tabla set $valor where $cond;";
    $res = mysqli_query($con, $upd);
    return $res;
}

function delete($tabla, $cond)
{
    $con = conecta(3);
    $del = "delete from $tabla where $cond;";
    $res = mysqli_query($con, $del);
    return $res;
}

function num($query)
{
    $con = conecta(3);
    $res = mysqli_num_rows($con, $query);
    return $res;
}

function arreglo($query)
{
    if (mysqli_num_rows($query) > 0) {
        $res = mysqli_fetch_array($query);
        return $res;
    } else {
        return null;
    }
}

function escape_cara($query)
{
    $con = conecta(3);
    $res = mysqli_real_escape_string($con, $query);
    return $res;
}

function error_base()
{
    $res = mysqli_error();
    return $res;
}

function row($query)
{
    $con = conecta(3);
    $res = mysqli_fetch_row($con, $query);
    return $res;
}

function query($query)
{
    $con = conecta(3);
    mysqli_query($con, "SET NAMES 'utf8'");
    $res = mysqli_query($con, $query);
    return $res;
}