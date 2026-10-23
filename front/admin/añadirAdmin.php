<?php
    session_start();
    $tipo_user = $_SESSION["tipo_user"];
    if ($tipo_user !== 1)
    {
        header("Location: ../logins/login.php");
        exit();
    }
    $mensaje = $_GET["mensaje"] ?? "";
?>

<!DOCTYPE html>
<html lang="es">


    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Crear Administrador</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="../styles/login.css">
    </head>

    <body>
        <main class="tarjeta">
            <div class="header">
                <div class="logo">GD</div>
                <div class="nombre">
                    <span class="juego">Game</span>
                    <span class="data">Data</span>
                </div>
            </div>
            <h1 class="sesion">Crear Administrador</h1>
            <p class="descripcion">Ingresa los datos del nuevo administrador.</p>
            <form action="../../back/procesar_admin.php" method="POST">
                <div class="campo">
                    <label for="usuario">Nombre del administrador</label>
                    <input type="text" id="usuario" name="nombreAdmin" placeholder="Escribe el nombre del administrador" required>
                    <?php if($mensaje == "user_invalido"): ?>
                    <p style="color: red;">Usuario Existente</p>
                    <?php endif ?>
                </div>
                <div class="campo">
                    <label for="correo">Correo electrónico</label>
                    <input type="email" id="correo" name="correoAdmin" placeholder="nombre@correo.com" required>
                    <?php if($mensaje == "correo_invalido"): ?>
                    <p style="color: red;">Correo Existente</p>
                    <?php endif ?>
                </div>
                <div class="campo">
                    <label for="pass">Contraseña</label>
                    <input type="password" id="pass" name="passAdmin" placeholder="Mínimo 4 caracteres" minlength="4" required>
                </div>
                <button type="submit">Registrar</button>
            </form>

            <button><a href="../user/index.php">Volver</a></button>
        </main>
    </body>


</html>