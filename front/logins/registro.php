<?php
    $mensaje = $_GET["mensaje"] ?? "";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
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
        <h1 class="sesion">Crea tu cuenta</h1>
        <p class="descripcion">Ingresa tus datos para unirte a GameData.</p>
        <form action="../../back/procesar_registro.php" method="POST">
            <div class="campo">
                <label for="usuario">Nombre de usuario</label>
                <input type="text" id="usuario" name="usuario" placeholder="Escribe tu nombre de usuario" required>
                <?php if($mensaje == "user_invalido"): ?>
                <p style="color: red;">Usuario Existente</p>
                <?php endif ?>
            </div>
            <div class="campo">
                <label for="correo">Correo electrónico</label>
                <input type="email" id="correo" name="correo" placeholder="nombre@correo.com" required>
                <?php if($mensaje == "correo_invalido"): ?>
                <p style="color: red;">Correo Existente</p>
                <?php endif ?>
            </div>
            <div class="campo">
                <label for="pass">Contraseña</label>
                <input type="password" id="pass" name="pass" placeholder="Mínimo 4 caracteres" minlength="4" required>
            </div>
            <button type="submit">Registrar</button>
        </form>
        <p class="registro">¿Ya tienes cuenta? <a href="login.php">Inicia sesión</a></p>
    </main>
</body>
</html>