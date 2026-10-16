<?php
    session_start();
    require "conexiones/conexion.php";
    if(!isset($_SESSION["id_usuario"])){
        header("Location: http://localhost/GameData/front/logis/login.php");
    }

    $id_usuario = $_SESSION["id_usuario"];
    $juego_peticion = $_POST["nombre"];
    $descripcion_peticion = $_POST["descripcion"];

    $sql = "INSERT INTO Peticion (id_usuario, peticion_juego, peticion_descripcion) VALUES ('$id_usuario','$juego_peticion','$descripcion_peticion')";
    $resultado = $conexion->query($sql);

    if($resultado){
        echo "exito";
    }
?>