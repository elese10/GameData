<?php
    $servidor = "127.0.0.1";
    $puerto = 3306;
    $usuario = "root";
    $password = "";
    $base_datos = "gamedata";

    $conexion = new mysqli(
        $servidor,
        $usuario,
        $password,
        $base_datos,
        $puerto 
    );

    if ($conexion->connect_error) {
        die("Error de conexion: " . $conexion->connect_error);
    };
?> 