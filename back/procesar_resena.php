<?php
    require "conexiones/conexion.php";
    $id_juego = $_POST["id_juego"];
    $id_usuario = $_POST["id_usuario"];
    $juego = str_replace(' ', '-', $_POST["nombre_juego"]);
    $review = $_POST["review"];
    $calificacion = $_POST["calificacion"];

    $sql_comprobacion = "SELECT * FROM Review WHERE id_usuario = ? AND id_juego = ?";
    $comprobacion = $conexion->prepare($sql_comprobacion);
    $comprobacion->bind_param("ii", $id_usuario, $id_juego);
    $comprobacion->execute();
    $comprobacion->store_result();
    if ($comprobacion->num_rows > 0) {
        echo "Ya haz reseñado este juego";
    }else{
        $sql = "INSERT INTO Review (id_usuario, id_juego, me_gusta, review) VALUES (?, ?, ?, ?)";
        $resultado = $conexion->prepare($sql);
        $resultado->bind_param("iiis", $id_usuario, $id_juego, $calificacion, $review);
        $resultado->execute();
        if($resultado){
            header("Location: ../front/juego.php?juego=$juego");
        }else{
            echo "error";
        }
    }
?>