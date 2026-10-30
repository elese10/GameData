<?php
    session_start();
    require "conexiones/conexion.php";
    $correo = $_POST["correo"];
    $pass = $_POST["pass"];
    
    $sql = "SELECT * FROM Usuario WHERE correo = ?";
    $resultado = $conexion->prepare($sql);
    $resultado->bind_param("s", $correo);
    $resultado->execute();
    $datos = $resultado->get_result();

    if ($datos->num_rows > 0){
        $user = $datos->fetch_assoc();
        if (password_verify($pass, $user['pwd'])) {
            $sql_perfil = "SELECT descripcion, img_url FROM Perfil WHERE id_usuario = ?";
            $res_perfil = $conexion->prepare($sql_perfil);
            $res_perfil->bind_param("i", $user["id_usuario"]);
            $res_perfil->execute();
            $datos_perfil=$res_perfil->get_result();
            if ($datos_perfil->num_rows <= 0) {
                $insertar_perfil = $conexion->prepare("INSERT INTO Perfil (id_usuario) VALUES (?)");
                $insertar_perfil->bind_param("i", $user["id_usuario"]);
                $insertar_perfil->execute();
            }
            $perfil = $datos_perfil->fetch_assoc();
            $_SESSION["id_usuario"] = $user['id_usuario'];
            $_SESSION["username"] = $user['username'];
            $_SESSION["correo"] = $user['correo'];
            $_SESSION["tipo_user"] = $user['tipo_user'];
            $_SESSION["fecha_creacion"] = $user['fecha_creacion'];
            $_SESSION["descripcion"] = $perfil["descripcion"];
            $_SESSION["img_url"] = $perfil["img_url"];
            header("Location: ../front/index.php");
            exit;
        } else{
            header("Location: http://localhost/GameData/front/logins/login.php?mensaje=contraseña_incorrecta");
            exit;
        }
    }else{
        header("Location: http://localhost/GameData/front/logins/login.php?mensaje=correo_incorrecto");
    }
?>