<?php
    session_start();
    require "../back/conexiones/conexion.php";
     if (!isset($_SESSION["id_usuario"])) {
        header("Location: http://localhost/GameData/front/index.php");
        exit;
    }
    $rol = $_SESSION["tipo_user"];
    $id_juego = $_GET["id"] ?? "";

    $sql_juego = "SELECT j.nombre, j.descripcion, j.img_url, GROUP_CONCAT(c.nombre SEPARATOR ', ') AS Categorias
    FROM Juego AS j
    JOIN Juego_categoria AS jc
    ON j.id_juego = jc.id_juego
    JOIN Categoria AS c
    ON jc.id_categoria = c.id_categoria WHERE j.id_juego = ?
    GROUP BY j.id_juego, j.nombre, j.descripcion, j.img_url;";
    $resultado = $conexion->prepare($sql_juego);
    $resultado->bind_param("i", $id_juego);
    $resultado->execute();
    //aun falta mejorar los distintos casos y errores//
    $datos = $resultado->get_result();
    if ($datos->num_rows <= 0) {
        header("location: http://localhost/GameData/front/index.php");
    }
     $juego = $datos->fetch_assoc();
?>

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
        <img src="<?= $juego["img_url"] ?>" alt="">
    </div>
    <main>
        <h1><?= $juego["nombre"] ?></h1>
        <!-- //falta mejorar el estilo de los botones de admin// -->
        <?php if($rol == 1):?>
            <div class="botones-admin">
                <button>modificar Juego</button>
                <button>Eliminar Juego</button>
            </div>
        <?php endif?>
        <div class="columnas">
            <div class="izquierda">
                <section>
                    <h2>Descripción</h2>
                    <p><?= $juego["descripcion"] ?></p>
                </section>
                <section>
                    <h2>Valoración</h2>
                    <p class="nota">Valoración: Muy Positiva</p>
                </section>
                <section>
                    <h2>Categorías</h2>
                    <div class="etiquetas">
                        <?php  $cats = explode(",", $juego["Categorias"])?>
                        <?php foreach($cats as $cat){?>
                                <span><?= $cat ?></span>       
                        <?php } ?> 
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