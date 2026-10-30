<?php
    session_start();
    if (!isset($_SESSION["id_usuario"])) {
        header("Location: http://localhost/GameData/front/logins/login.php");
        exit;
    }
    require "conexiones/conexion.php";

    $accion = $_GET["accion"];
    $id_destinatario = $_POST["id_destinatario"];
    $id_solicitante = $_POST["id_solicitante"];

    if ($accion === "enviarSolicitud") {
        $nombre_usuario = $_POST["usuario"];
        $sql_comprobar = "SELECT * FROM Solicitud_Amistad WHERE id_solicitante = $id_solicitante AND id_destinatario = $id_destinatario";
        $res_comprobar = $conexion->query($sql_comprobar);
        if ($res_comprobar->num_rows > 0) {
            echo "error: ya le has enviado una solicitud a este usuario";
            exit;
        }

        $sql_enviar = "INSERT INTO Solicitud_Amistad (id_solicitante, id_destinatario) VALUES (?,?)";
        $res_enviar = $conexion->prepare($sql_enviar);
        $res_enviar->bind_param("ii", $id_solicitante, $id_destinatario);
        $res_enviar->execute();
        $solicitud = $res_enviar->store_result();
        if ($solicitud) {
            header("Location: ../front/user/perfil.php?perfil=$nombre_usuario");
            exit;
        }
    }else if($accion === "aceptar"){
        $sql_aeptar = "UPDATE Solicitud_Amistad SET estado = 'aceptada' WHERE id_solicitante = ? AND id_destinatario = ?";
        $res_aceptar = $conexion->prepare($sql_aeptar);
        $res_aceptar->bind_param("ii", $id_solicitante, $id_destinatario);
        $res_aceptar->execute();
        if ($res_aceptar->affected_rows > 0) {
            header("Location: ../front/user/amigos.php");
            exit;
        }else{
            echo "error al aceptar";
        }
    }else if($accion === "rechazar"){
        $sql_rechazar = "DELETE FROM Solicitud_Amistad WHERE id_solicitante = ? AND id_destinatario = ?";
        $res_rechazar = $conexion->prepare($sql_rechazar);
        $res_rechazar->bind_param("ii", $id_solicitante, $id_destinatario);
        $res_rechazar->execute();
        if ($res_rechazar->affected_rows > 0) {
            header("Location: ../front/user/amigos.php");
            exit;
        }else{
            echo "error al eliminar";
        }
    }   
?>