<?php

// CONEXION A LA BASE DE DATOS MYSQL
$host = "localhost";
$bd = "sitio";
$usuario ="root";
$clave = "";

try {
    $connection = new PDO("mysql:host=$host;dbname=$bd", $usuario, $clave);
    // if($connection){ echo "Conectado a BD..."; }

} catch (Exception $ex) {
    echo $ex -> getMessage();
}

?>