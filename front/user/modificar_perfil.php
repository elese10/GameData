<?php
    session_start();
    if (!isset($_SESSION["id_usuario"])) {
        header("Location: http://localhost/GameData/front/logins/login.php");
        exit;
    }
    require "../../back/conexiones/conexion.php";

    $id_usuario = $_SESSION["id_usuario"];
    $nombre_usuario = $_SESSION["username"];
    $correo = $_SESSION["correo"];
    $img_url = $_POST["img_url"];
    $descripcion = $_POST["descripcion"] ?? '';

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar perfil</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../styles/modificar_perfil.css">
</head>
<body>
    <form class="formulario" method="POST" action="../../back/procesar_modificacion_perfil.php" id="formularioPerfil">
        <div class="marca">
            <div class="marca-icono">GD</div>
            <div class="marca-titulos">
                <span>Game</span>
                <span>Data</span>
            </div>
        </div>

        <div class="titulo">
            <h1>Modificar perfil</h1>
            <p>Actualiza tus datos de perfil.</p>
        </div>

        <div class="avatar-bloque">
            <span class="etiqueta">Avatar</span>
            <div class="avatar-preview">
                <div class="avatar" id="avatar">
                    <?php if($img_url == 0) :?>
                        <i class="usuario"></i>
                    <?php else: ?>
                        <img src="<?= $img_url ?>" alt="no">
                    <?php endif ?>
                </div>
            </div>
        </div>

        <div class="campos">
            <div class="campo">
                <label class="etiqueta" for="img_url">URL de imagen</label>
                <?php if($img_url == 0): ?>
                    <input class="input" type="url" id="img_url" name="img_url" placeholder="https://ejemplo.com/imagen.jpg">
                <?php else: ?>
                    <input class="input" type="url" id="img_url" name="img_url" placeholder="https://ejemplo.com/imagen.jpg" value="<?= $img_url ?>">
                <?php endif ?>
            </div>
            <div class="campo">
                <label class="etiqueta" for="username">Nombre de usuario</label>
                <input class="input" type="text" id="username" name="username" placeholder="<?= $nombre_usuario ?>" value="<?= $nombre_usuario ?>">
            </div>
            <div class="campo">
                <label class="etiqueta" for="descripcion">Biografia</label>
                <?php if($descripcion == 0): ?>
                    <textarea class="input descripcion" id="descripcion" name="descripcion" placeholder="Escribe una breve biografia"></textarea>
                <?php else: ?>
                    <textarea class="input descripcion" id="descripcion" name="descripcion"><?= $descripcion ?></textarea>
                <?php endif ?>
            </div>
            <div class="campo">
                <label class="etiqueta" for="correo">Correo electrónico</label>
                <input class="input" type="email" id="correo" name="correo" placeholder="<?= $correo ?>" value="<?= $correo ?>">
            </div>
        </div>

        <div class="acciones">
            <button class="boton boton-guardar" type="submit">Guardar</button>
            <a class="boton boton-cancelar" href="perfil.php">Cancelar</a>
        </div>
    </form>
    <script>
        const campoUrlImagen = document.getElementById('img_url');
        const vistaPreviaAvatar = document.getElementById('avatar');

        function actualizarVistaPrevia()
        {
            const urlImagen = campoUrlImagen.value.trim();

            if (urlImagen.length > 0)
            {
                const urlParaFondo = urlImagen.replaceAll('"', '%22');
                vistaPreviaAvatar.style.backgroundImage = `url("${urlParaFondo}")`;
                vistaPreviaAvatar.classList.add('con-imagen');
                return;
            }

            vistaPreviaAvatar.style.backgroundImage = 'none';
            vistaPreviaAvatar.classList.remove('con-imagen');
        }

        campoUrlImagen.addEventListener('input', actualizarVistaPrevia);
    </script>
</body>
</html>