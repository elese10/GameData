<?php
    session_start();
    require "conexiones/conexion.php"; 

    $id_usuario = $_SESSION["id_usuario"];
    $id_juego = $_POST["juego"];
    $accion = $_POST["accion"];
    $lista = $_POST["lista"];
    $juego = str_replace(' ', '-', $_POST["nombre"]);

    if ($accion === "agregar") {
        $sql = "INSERT INTO Usuario_juego (id_usuario, id_juego, id_lista) VALUES (?,?,?)";
        $resultado = $conexion->prepare($sql);
        $resultado->bind_param("iii", $id_usuario, $id_juego, $lista);
        $resultado->execute();

        if ($resultado) {
            header("Location: ../front/juego.php?juego=$juego");
            exit;
        }else{
            echo "error";
        }

    }else if($accion === "eliminar"){
        $sql = "DELETE FROM Usuario_juego WHERE id_usuario = ? AND id_Juego = ? AND id_lista = ?";
        $resultado = $conexion->prepare($sql);
        $resultado->bind_param("iii", $id_usuario, $id_juego, $lista);
        $resultado->execute();

        if ($resultado ->affected_rows > 0) {
            header("Location: ../front/juego.php?juego=$juego");
            exit;
        }else{
            echo "error";
        }
    }
?>