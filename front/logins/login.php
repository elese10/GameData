<?php
    $mensaje = $_GET["mensaje"] ?? "";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de sesión</title>
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
        <h1 class="sesion">Iniciar sesión</h1>
        <p class="descripcion">Ingresa tu correo electrónico y contraseña para continuar.</p>
        <form action="procesar_login.php" method="POST">
            <div class="campo">
                <label for="correo">Correo electrónico</label>
                <input type="email" id="correo" name="correo" placeholder="nombre@ejemplo.com" required>
                <?php if ($mensaje == "correo_incorrecto"):?> 
                    <p>Correo incorrecto</p>
                <?php endif; ?>
            </div>
            <div class="campo">
                <label for="pass">Contraseña</label>
                <input type="password" id="pass" name="pass" placeholder="••••••••••••" required>
                <?php if ($mensaje == "contraseña_incorrecta"):?>
                    <p>Contraseña incorrecta</p>
                <?php endif; ?>
            </div>
            <button type="submit">Iniciar sesión</button>
        </form>
        <p class="registro">¿No tienes cuenta? <a href="registro.php">Regístrate</a></p>
    </main>
</body>
</html>