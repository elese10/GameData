<?php
    require "conexiones/conexion.php";

    $nombreAdmin = $_POST["nombreAdmin"];
    $correoAdmin = $_POST["correoAdmin"];
    $passAdmin = $_POST["passAdmin"];
    
    $check_Correo_Admins = $conexion -> prepare("SELECT correo FROM Usuario WHERE correo = ?");
    $check_Correo_Admins -> bind_param("s", $correoAdmin);
    $check_Correo_Admins -> execute();
    $resultadoAdmins = $check_Correo_Admins -> get_result();
    $check_Correo_Admins -> close();

    if ($resultadoAdmins -> num_rows > 0)
    {
        header("Location: /../front/admin/añadirAdmin.php?mensaje=correo_invalido");
        exit;
    } 

    $check_Nombre_Admin = $conexion -> prepare("SELECT username FROM Usuario WHERE username = ?");
    $check_Nombre_Admin -> bind_param("s", $nombreAdmin);
    $check_Nombre_Admin -> execute();
    $resultadoAdmins = $check_Nombre_Admin -> get_result();
    $check_Nombre_Admin -> close();

    if ($resultadoAdmins -> num_rows > 0)
    {
        header("Location: /../front/admin/añadirAdmin.php?mensaje=user_invalido");
        exit;
    }


    $hash = password_hash($passAdmin, PASSWORD_DEFAULT);

    $agregarAdmin = $conexion -> prepare("INSERT INTO Usuario (correo, pwd, tipo_user, username) VALUES (?, ?, 2, ?)");
    $agregarAdmin -> bind_param("sss", $correoAdmin, $hash, $nombreAdmin);
    $agregarAdmin -> execute();
    $agregarAdmin -> close();


?>