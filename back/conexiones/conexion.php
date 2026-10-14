<?php
    $servidor = "127.0.0.1";
    $usuario = "root";
    $password = "";
    $base_datos = "gamedata";

    $conexion = new mysqli(
        $servidor,
        $usuario,
        $password,
        $base_datos
    );

    if ($conexion->connect_error) {
        die("Error de conexion: " . $conexion->connect_error);
    };
?>