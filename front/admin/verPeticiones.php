<?php
    session_start();
    require_once __DIR__ . "/../../back/conexiones/conexion.php";
    
    $traerPeticion = $conexion -> prepare("SELECT id_peticion, peticion_juego, peticion_descripcion, estado FROM Peticion WHERE estado = 'pendiente'");
    $traerPeticion -> execute();
    $peticiones = ($traerPeticion -> get_result()) -> fetch_all(MYSQLI_ASSOC);
    $traerPeticion -> close();
    $rol = $_SESSION["tipo_user"];
    $nombre_usuario = $_SESSION["username"];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Data | Inicio</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../styles/style.css">
</head>
<body>
    
    <aside>
        <a href="index.php" class="header">
            <div class="logo">GD</div>
            <div class="nombre">
                <span class="juego">Game</span>
                <span class="data">Data</span>
            </div>
        </a>

        <!-- //si el usuario es un usuario comun tiene este nav// -->
        <nav>
            <a href="../index.php"><i class="inicio"></i>Inicio</a>
            <?php if($rol == 0):?>
                <a class="boton_modal" onclick="abrirModal()"><i class="mas"></i>Solicitar Juego</a>
            <?php endif?>
            <a href="resenas.php"><i class="estrella"></i>Reseñas</a>
            <a href="amigos.php"><i class="usuario"></i>Amigos</a>
        </nav>

        <!-- //si el usuario es un administrador tiene este nav// -->
        <?php if($rol == 1) :?>
            <nav class="nav-admin"> 
                <h2>Herramientas de Admin</h2>           
                <a href="admin/verPeticiones.php" class="activo"><i class="libro"></i>Ver solicitudes</a>
                <a href="admin/anadirJuego.php"><i class="mas"></i>Agregar Juego</a>
            </nav>
        <?php endif?>
        <a href="perfil.php" class="perfil">
            <div class="avatar"><i class="usuario"></i></div>
            <div class="datos">
                <strong><?= $nombre_usuario ?></strong>
                <span>Perfil principal</span>
            </div>
        </a>
    </aside>

    <!-- Modal de peticion de juegos -->
    <div id="modal" class="modal_overlay">
        <div class="modal_contenedor">
            <div class="modal_header">
                <h2>Solicitar juego</h2>
                <p>
                    Completa los datos para que los administradores revisen y agreguen el juego a la plataforma.
                </p>
            </div>
            <form action="../back/procesar_solicitudJuego.php" method="POST">
                <div class="nombre_peticion">
                    <h2>Nombre Juego</h2>
                    <input type="text" placeholder="Ej: Hollow Knight: Silksong" name="nombre" required>
                </div>
                <div class="descripcion_peticion">
                    <h2>Descripcion</h2>
                    <textarea name="descripcion" id="" placeholder="Describe brevemente el juego, género o por qué te gustaría que lo agreguemos" required></textarea>
                </div>
                <div class="modal_botones">
                    <button type="button" class="boton boton_cancelar" onclick="cerrarModal()">Cancelar</button>
                    <button type="submit" class="boton boton_agregar">Solicitar</button>
                </div>
            </form>
        </div>
    </div>

    
    <main>
        <!-- //barra de busqueda y botones de listas// -->
        <div class="barra">
            <form class="buscador" action="#">
                <i class="buscar"></i>
                <input type="search" placeholder="Buscar juegos, usuarios">
            </form>
            <nav>
                <a href="lista.php?tipo=favoritos"><i class="estrella"></i>Favoritos</a>
                <a href="lista.php?tipo=deseados"><i class="mas"></i>Deseados</a>
                <a href="lista.php?tipo=posesion"><i class="libro"></i>En posesión</a>
            </nav>
        </div>
        
        <section class="peticiones" id="peticiones">

            <?php foreach ($peticiones as $peticion): ?>
                <article class="tarjeta-peticion">
                    <div class="peticion-info">
                        <h2 class="titulo-peticion"><?= $peticion["peticion_juego"] ?></h2>
                        <p class="descripcion-peticion">
                            <?= $peticion["peticion_descripcion"] ?>
                        </p>
                    </div>
    
                    <div class="botones-peticiones">
                        <form action="anadirJuego.php" method="POST" >
                            <input type="hidden" value="agregar" name="accion">
                            <input type="hidden" name="id" value="<?= $peticion["id_peticion"] ?>">
                            <button class="boton-peticion boton-aprobar" type="submit"><i class="libro"></i>Aprobar
                            </button>
                        </form>
        
                        <form action="../../back/procesar_peticion.php" method="POST">
                            <input type="hidden" value="eliminar" name="accion">
                            <input type="hidden" name="id" value="<?= $peticion["id_peticion"] ?>">
                            <button class="boton-peticion boton-rechazar" type="submit">
                                <i class="borrar"></i>
                                Rechazar
                            </button>
                        </form>
                    </div>
                </article>
            <?php endforeach; ?>
    </main>
    <script>
        function abrirModal() {
            document.getElementById('modal').style.display = 'flex';
        }

        function cerrarModal() {
            document.getElementById('modal').style.display = 'none';
        }
    </script>
</body>
</html>