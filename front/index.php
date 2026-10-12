<?php
    session_start();
    $id_usuario = $_SESSION["id_usuario"];
    $nombre_usuario = $_SESSION["username"];
    $rol = $_SESSION["tipo_user"];
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
            <a href="solicitar-juego.php"><i class="mas"></i>Solicitar Juego</a>
            <a href="resenas.php"><i class="estrella"></i>Reseñas</a>
            <a href="amigos.php"><i class="usuario"></i>Amigos</a>
        </nav>
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
                        <a href="juego.php?id=1" class="ver">Ver</a>
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
                <article>
                    <a href="juego.php?id=8"><img src="https://shared.akamai.steamstatic.com/store_item_assets/steam/apps/367520/header.jpg" alt="Hollow Knight"></a>
                    <div class="info">
                        <h3>Hollow Knight</h3>
                        <p>Metroidvania</p>
                        <div class="etiquetas"><span>Acción</span></div>
                    </div>
                </article>
                <article>
                    <a href="juego.php?id=9"><img src="https://shared.akamai.steamstatic.com/store_item_assets/steam/apps/1145360/header.jpg" alt="Hades"></a>
                    <div class="info">
                        <h3>Hades</h3>
                        <p>Roguelike</p>
                        <div class="etiquetas"><span>RPG</span></div>
                    </div>
                </article>
                <article>
                    <a href="juego.php?id=10"><img src="https://shared.akamai.steamstatic.com/store_item_assets/steam/apps/814380/header.jpg" alt="Sekiro"></a>
                    <div class="info">
                        <h3>Sekiro: Shadows Die Twice</h3>
                        <p>Acción</p>
                        <div class="etiquetas"><span>Acción</span></div>
                    </div>
                </article>
                <article>
                    <a href="juego.php?id=11"><img src="https://shared.akamai.steamstatic.com/store_item_assets/steam/apps/504230/header.jpg" alt="Celeste"></a>
                    <div class="info">
                        <h3>Celeste</h3>
                        <p>Plataformas</p>
                        <div class="etiquetas"><span>Aventura</span></div>
                    </div>
                </article>
            </div>
        </section>
    </main>
</body>
</html>