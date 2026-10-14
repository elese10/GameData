<?php
    require "../back/conexiones/conexion.php";
    session_start();
    
    if (!isset($_SESSION["id_usuario"])) {
        header("Location: http://localhost/GameData/front/index.php");
        exit;
    }

    $id_usuario = $_SESSION["id_usuario"];
    $nombre_usuario = $_SESSION["username"];
    $rol = $_SESSION["tipo_user"];

    $sql_juegos = "SELECT j.id_juego, j.nombre, j.descripcion, j.img_url, GROUP_CONCAT(c.nombre SEPARATOR ', ') AS Categorias
    FROM Juego AS j
    JOIN Juego_categoria AS jc
    ON j.id_juego = jc.id_juego
    JOIN Categoria AS c
    ON jc.id_categoria = c.id_categoria
    GROUP BY j.id_juego, j.nombre, j.descripcion, j.img_url;";
    $resultado = $conexion->query($sql_juegos);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Data | Inicio</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles/style.css">
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
        <nav>
            <a href="index.php" class="activo"><i class="inicio"></i>Inicio</a>
            <?php if($rol == 0):?>
                <a href="solicitar-juego.php"><i class="mas"></i>Solicitar Juego</a>
            <?php endif?>
            <a href="resenas.php"><i class="estrella"></i>Reseñas</a>
            <a href="amigos.php"><i class="usuario"></i>Amigos</a>
        </nav>
        <?php if($rol == 1) :?>
            <nav>            
                <a href="solicitar-juego.php"><i class="libro"></i>Ver solicitudes</a>
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

    <main>
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
        <section class="destacados">
            <article class="destacado">
                <div class="portada">
                    <img src="https://shared.akamai.steamstatic.com/store_item_assets/steam/apps/1030300/header.jpg" alt="Hollow Knight: Silksong">
                    <span>Destacado</span>
                </div>
                <div class="info">
                    <h1>Hollow Knight: Silksong</h1>
                    <p>Descubre un nuevo reino, explora territorios desconocidos y enfrenta peligros en esta aventura llena de misterios.</p>
                    <div class="pie">
                        <div class="etiquetas">
                            <span>RPG</span>
                            <span>Acción</span>
                        </div>
                        <a href="juego.php" class="ver">Ver</a>
                    </div>
                </div>
            </article>

            <section class="favoritos">
                <div class="titulo">
                    <h2><i class="tendencia"></i>Nuestros Favoritos</h2>
                    <span>6 juegos</span>
                </div>
                <a href="juego.php?id=2">
                    <img src="https://shared.akamai.steamstatic.com/store_item_assets/steam/apps/374320/header.jpg" alt="Dark Souls 3">
                    <div><strong>Dark Souls 3</strong><span>Acción, RPG</span></div>
                    <span class="puesto">1</span>
                </a>
                <a href="juego.php?id=3">
                    <img src="https://shared.akamai.steamstatic.com/store_item_assets/steam/apps/1245620/header.jpg" alt="Elden Ring">
                    <div><strong>Elden Ring</strong><span>Acción, RPG</span></div>
                    <span class="puesto">2</span>
                </a>
                <a href="juego.php?id=4">
                    <img src="https://shared.akamai.steamstatic.com/store_item_assets/steam/apps/1091500/header.jpg" alt="Cyberpunk 2077">
                    <div><strong>Cyberpunk 2077</strong><span>RPG</span></div>
                    <span class="puesto">3</span>
                </a>
                <a href="juego.php?id=5">
                    <img src="https://shared.akamai.steamstatic.com/store_item_assets/steam/apps/1086940/header.jpg" alt="Baldur's Gate 3">
                    <div><strong>Baldur's Gate 3</strong><span>RPG</span></div>
                    <span class="puesto">4</span>
                </a>
                <a href="juego.php?id=6">
                    <img src="https://shared.akamai.steamstatic.com/store_item_assets/steam/apps/292030/header.jpg" alt="The Witcher 3">
                    <div><strong>The Witcher 3</strong><span>Aventura, RPG</span></div>
                    <span class="puesto">5</span>
                </a>
                <a href="juego.php?id=7">
                    <img src="https://shared.akamai.steamstatic.com/store_item_assets/steam/apps/1174180/header.jpg" alt="Red Dead Redemption 2">
                    <div><strong>Red Dead Redemption 2</strong><span>Aventura</span></div>
                    <span class="puesto">6</span>
                </a>
            </section>
        </section>

        <section class="agregados">
            <h2>Juegos agregados</h2>
            <div class="grilla">
                <?php
                while($juego = $resultado->fetch_assoc()){
                ?>
                    <article>
                        <a href="juego.php?id=<?= $juego["id_juego"] ?>"><img src="<?= $juego["img_url"]?>" alt="<?= $juego["nombre"]?>"></a>
                        <div class="info">
                            <h3><?= $juego["nombre"] ?></h3>
                            <p><?= $juego["descripcion"] ?></p>
                            <div class="etiquetas">
                                <?php  $cats = explode(",", $juego["Categorias"])?>
                                <?php foreach($cats as $cat){?>
                                    <span><?= $cat ?></span>       
                                <?php } ?> 
                            </div>
                        </div>
                    </article>
                <?php
                };
                ?>
            </div>
        </section>
    </main>
</body>
</html>