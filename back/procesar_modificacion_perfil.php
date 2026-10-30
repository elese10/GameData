<?php
    session_start();
    if (!isset($_SESSION["id_usuario"])) {
        header("Location: http://localhost/GameData/front/logins/login.php");
        exit;
    }
    require "conexiones/conexion.php";

    $mensaje = $_GET["accion"] ?? '';

    if ($mensaje === "cerrarsesion") {
        session_destroy();
        header("Location: http://localhost/GameData/front/logins/login.php");
    }else{
        $id_usuario = $_SESSION["id_usuario"];
        $nombre_usuario = $_POST["username"];
        $correo = $_POST["correo"];
        $img_url = $_POST["img_url"];
        $descripcion = $_POST["descripcion"];

        $sql_actualizar = "UPDATE Usuario JOIN Perfil ON Usuario.id_usuario = Perfil.id_usuario
        SET Usuario.username = ?,
            Usuario.correo = ?,
            Perfil.descripcion = ?,
            Perfil.img_url = ?
        WHERE Usuario.id_usuario = ?";

        $resultado = $conexion->prepare($sql_actualizar);
        $resultado->bind_param("ssssi", $nombre_usuario, $correo, $descripcion, $img_url, $id_usuario);
        $resultado->execute();
        if ($resultado->affected_rows > 0) {
            if($nombre_usuario != $_SESSION["username"]){
                $_SESSION["username"] = $nombre_usuario;
            }
            if($correo != $_SESSION["correo"]) {
                $_SESSION["correo"] = $correo;
            }
            if($descripcion != $_SESSION["descripcion"]) {
                $_SESSION["descripcion"] = $descripcion;
            }
            if($img_url != $_SESSION["img_url"]) {
                $_SESSION["img_url"] = $img_url;
            }
            header("Location: ../front/user/perfil.php");
            exit;
        } else{
            echo "fallo";
        }
    }
?>