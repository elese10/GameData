<?php
    require "conexiones/conexion.php";
    $id_juego = $_POST["id_juego"];
    $id_usuario = $_POST["id_usuario"];
    $juego = str_replace(' ', '-', $_POST["nombre_juego"]);
    $review = $_POST["review"];
    $calificacion = $_POST["calificacion"];

    $sql = "INSERT INTO Review (id_usuario, id_juego, me_gusta, review) VALUES ('$id_usuario', '$id_juego', '$calificacion', '$review')";
    $resultado = $conexion->query($sql);

    if($resultado){
        header("Location: ../front/juego.php?juego=$juego");
    }else{
        echo "error";
    }

?>