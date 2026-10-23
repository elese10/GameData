<?php
    require "conexiones/conexion.php";

    $id_juego = $_POST["id"];
    $sql = "DELETE FROM Juego WHERE id_juego = ?";
    $resultado = $conexion->prepare($sql);
    $resultado->bind_param("i", $id_juego);
    $resultado->execute();

    if ($resultado->affected_rows > 0) {
        header("Location: ../front/index.php");
        exit;
    } else {
        echo "No se encontró el juego o no se pudo borrar";
    }
?>