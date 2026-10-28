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
            $_SESSION["id_usuario"] = $user['id_usuario'];
            $_SESSION["username"] = $user['username'];
            $_SESSION["correo"] = $user['correo'];
            $_SESSION["tipo_user"] = $user['tipo_user'];
            $_SESSION["fecha_creacion"] = $user['fecha_creacion'];
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