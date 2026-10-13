<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Data | Juego</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles/juego.css">
</head>
<body>
    <div class="fondo">
        <img src="https://shared.akamai.steamstatic.com/store_item_assets/steam/apps/1030300/header.jpg" alt="">
    </div>
    <main>
        <h1>Hollow Knight: Silksong</h1>
        <div class="columnas">
            <div class="izquierda">
                <section>
                    <h2>Descripción</h2>
                    <p>Descubre un nuevo reino, explora territorios desconocidos y enfrenta peligros en esta aventura llena de misterios.</p>
                </section>
                <section>
                    <h2>Valoración</h2>
                    <p class="nota">Valoración: Muy Positiva</p>
                </section>
                <section>
                    <h2>Categorías</h2>
                    <div class="etiquetas">
                        <span>RPG</span>
                        <span>Acción</span>
                        <span>Aventura</span>
                    </div>
                </section>
            </div>
            <div class="derecha">
                <section>
                    <h2>Listas</h2>
                    <nav class="listas">
                        <a href="lista.php?tipo=favoritos" class="activo"><i class="estrella"></i>Favoritos</a>
                        <a href="lista.php?tipo=deseados"><i class="mas"></i>Deseados</a>
                        <a href="lista.php?tipo=posesion"><i class="libro"></i>En posesión</a>
                    </nav>
                </section>
                <section>
                    <h2>Reseñas y comentarios</h2>
                    <a href="comentar.php?id=1" class="comentar"><i class="mas"></i>Comentar</a>
                    <article>
                        <div class="autor">
                            <div class="avatar"><i class="usuario"></i></div>
                            <div class="datos">
                                <strong>Ezequiel</strong>
                                <span>Ejemplo / reseña positiva</span>
                            </div>
                            <span class="positivo">Me gusta</span>
                        </div>
                        <p>La exploración, el arte y la narrativa están a otro nivel. Me encantó el ritmo y la sensación de descubrir cada nuevo entorno.</p>
                    </article>
                    <article>
                        <div class="autor">
                            <div class="avatar"><i class="usuario"></i></div>
                            <div class="datos">
                                <strong>Luna</strong>
                                <span>Ejemplo / reseña negativa</span>
                            </div>
                            <span class="negativo">No me gusta</span>
                        </div>
                        <p>Me costó entrar al ritmo inicial y sentí que la dificultad se disparaba demasiado rápido. No terminé de conectar con la historia.</p>
                    </article>
                </section>
            </div>
        </div>
    </main>
</body>
</html>