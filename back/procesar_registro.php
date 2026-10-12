<?php
    require "conexiones/conexion.php";
    
    $usuario = $_POST["usuario"];
    $correo = $_POST["correo"];
    $pass = $_POST["pass"];
    
    $sqlusuario = "SELECT * FROM Usuario WHERE username = ?";
    $resultadouser = $conexion->prepare($sqlusuario);
    $resultadouser->bind_param("s", $usuario);
    $resultadouser->execute();
    $resultadouser->store_result();

    $sqlcorreo = "SELECT * FROM Usuario WHERE correo = ?";
    $resultadocorreo = $conexion->prepare($sqlcorreo);
    $resultadocorreo->bind_param("s", $correo);
    $resultadocorreo->execute();
    $resultadocorreo->store_result();

    if ($resultadouser->num_rows > 0) {
        header("Location: http://localhost/GameData/front/logins/registro.php?mensaje=user_invalido");
        exit;
    } else if ($resultadocorreo->num_rows > 0) {
        header("Location: http://localhost/GameData/front/logins/registro.php?mensaje=correo_invalido");
        exit;
    }else{
        $hash = password_hash($pass, PASSWORD_DEFAULT);
        $sql = "INSERT INTO Usuario(username,correo,pwd) VALUES ('$usuario', '$correo', '$hash')";
        $resultado = $conexion->query($sql);

        if ($resultado){
            header("Location: http://localhost/GameData/front/logins/login.php");
            exit;
        } else{
            echo "error";
        }
    }
?>