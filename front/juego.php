<?php
    session_start();
    require "../back/conexiones/conexion.php";
    if (!isset($_SESSION["id_usuario"])) {
        header("Location: http://localhost/GameData/front/index.php");
        exit;
    }
    $id_usuario = $_SESSION["id_usuario"];
    $rol = $_SESSION["tipo_user"];
    $nombre_juego = str_replace('-', ' ', $_GET["juego"]);

    $sql_juego = "SELECT j.id_juego, j.nombre, j.descripcion, j.img_url, GROUP_CONCAT(c.nombre SEPARATOR ', ') AS Categorias
    FROM Juego AS j
    JOIN Juego_categoria AS jc
    ON j.id_juego = jc.id_juego
    JOIN Categoria AS c
    ON jc.id_categoria = c.id_categoria WHERE j.nombre = ?
    GROUP BY j.id_juego, j.nombre, j.descripcion, j.img_url;";
    $resultado = $conexion->prepare($sql_juego);
    $resultado->bind_param("s", $nombre_juego);
    $resultado->execute();
    //aun falta mejorar los distintos casos y errores//
    $datos = $resultado->get_result();
    if ($datos->num_rows <= 0) {
        header("location: http://localhost/GameData/front/index.php");
    }
    $juego = $datos->fetch_assoc();

    $resultado_valoracion = $conexion->prepare("SELECT AVG(r.me_gusta) FROM Review AS r JOIN Juego AS j ON r.id_juego = j.id_juego WHERE j.nombre = ?");
    $resultado_valoracion->bind_param("s", $nombre_juego);
    $resultado_valoracion->execute();
    $valoracion = $resultado_valoracion->get_result()->fetch_assoc()["AVG(r.me_gusta)"];

    $sql_comentarios = "SELECT r.me_gusta, r.review, r.fecha, u.username, p.img_url 
    FROM Review AS r 
    JOIN Usuario AS u 
    ON r.id_usuario = u.id_usuario 
    JOIN Juego AS j 
    ON r.id_juego = j.id_juego 
    JOIN Perfil AS p
    ON r.id_usuario = p.id_usuario
    WHERE j.nombre = ?";

    $resultado_reseñas = $conexion->prepare($sql_comentarios);
    $resultado_reseñas->bind_param("s", $nombre_juego);
    $resultado_reseñas->execute();
    $comentarios = $resultado_reseñas->get_result();

    //Consultas de listas
    $sql_favorito = "SELECT * FROM Usuario_juego WHERE id_usuario = ? AND id_juego = ? AND id_lista = 1";
    $res_favorito = $conexion->prepare($sql_favorito);
    $res_favorito->bind_param("ii", $id_usuario, $juego["id_juego"]);
    $res_favorito->execute();
    $favorito = $res_favorito->get_result();
    $res_favorito->close();
    if($favorito->num_rows > 0){
        $favorito = 1;
    }else{
        $favorito = 0;
    }

    $sql_deseos = "SELECT * FROM Usuario_juego WHERE id_usuario = ? AND id_juego = ? AND id_lista = 2";
    $res_deseos = $conexion->prepare($sql_deseos);
    $res_deseos->bind_param("ii", $id_usuario, $juego["id_juego"]);
    $res_deseos->execute();
    $deseos = $res_deseos->get_result();
    $res_deseos->close();
    if($deseos->num_rows > 0){
        $deseos= 1;
    }else{
        $deseos= 0;
    }

    $sql_posesion = "SELECT * FROM Usuario_juego WHERE id_usuario = ? AND id_juego = ? AND id_lista = 3";
    $res_posesion = $conexion->prepare($sql_posesion);
    $res_posesion->bind_param("ii", $id_usuario, $juego["id_juego"]);
    $res_posesion->execute();
    $posesion = $res_posesion->get_result();
    $res_posesion->close();

    if($posesion->num_rows > 0){
        $posesion = 1;
    }else{
        $posesion= 0;
    }
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
        <div class="boton_volver">
            <button class="boton_lista"><a href="index.php"><i class="volver"></i>Volver</a></button>
        </div>
        <div style="position: relative;">
            <h1><?= $juego["nombre"] ?></h1>
            <?php if($rol == 1):?>
                <div class="botones-admin">
                    <button class="boton modificar"><a href="admin/modificarJuego.php?id_juego=<?= $juego["id_juego"] ?>">Editar</a></button>
                    <button class="boton eliminar" onclick="abrirModal()">Eliminar</button>
                </div>
            <?php endif?>
        </div>

        <!-- Modal de eliminacion -->
        <div id="modal" class="modal_overlay">
            <div class="modal_contenedor">
                <form action="../back/procesar_eliminarJuego.php" method="POST">
                    <h2>Seguro que quiere eliminar el juego?</h2>
                    <input type="hidden" name="id" value="<?=$juego["id_juego"]?>">
                    <div class="modal_botones">
                        <button type="button" class="boton modificar" onclick="cerrarModal()">Cancelar</button>
                        <button type="submit" class="boton eliminar">Eliminar</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal de comentar -->
        <div id="modalResena" class="modal_overlay">
            <div class="modal_contenedor">
                <div class="modal_header">
                    <h2>Reseñar: <?= $juego["nombre"] ?></h2>
                    <p>
                        Deja tu reseña para que los usuarios puedan leer tu experiencia
                    </p>
                </div>
                <form action="../back/procesar_resena.php" method="POST">
                    <input type="hidden" name="id_juego" value="<?= $juego["id_juego"] ?>">
                    <input type="hidden" name="nombre_juego" value="<?= $juego["nombre"] ?>">
                    <input type="hidden" name="id_usuario" value="<?= $id_usuario ?>">
                    <div class="area_resena">
                        <textarea name="review" placeholder="Describe brevemente el juego, género o por qué te gustaría que lo agreguemos" required></textarea>
                    </div>
                    <h2>Calificacion</h2>
                    <div class="calificacion">
                        <input type="radio" name="calificacion" value="1" id="resena_like" required>
                        <label for="resena_like"><img src="logos/like.svg" alt=""></label>
                        <input type="radio" name="calificacion" value="0" id="resena_dislike" required>
                        <label for="resena_dislike"><img src="logos/dislike.svg" alt=""></label>
                    </div>
                    <div class="modal_botones">
                        <button type="button" class="boton_lista boton_cancelar" onclick="cerrarModal()">Cancelar</button>
                        <button type="submit" class="boton_lista activo">Solicitar</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="columnas">
            <div class="izquierda">
                <section>
                    <h2>Descripción</h2>
                    <p><?= $juego["descripcion"] ?></p>
                </section>
                <section>
                    <h2>Valoración</h2>
                    <?php if ($valoracion === null): ?>
                        <p class="nota">Sin valoraciones</p>
                    <?php elseif ($valoracion >= 0.80): ?>
                        <p class="nota">Valoración: Muy positiva</p>
                    <?php elseif ($valoracion >= 0.60): ?>
                        <p class="nota">Valoración: Positiva</p>
                    <?php elseif ($valoracion >= 0.45): ?>
                        <p class="nota">Valoración: Regular</p>
                    <?php elseif ($valoracion >= 0.25): ?>
                        <p class="nota">Valoración: Negativa</p>
                    <?php else: ?>
                        <p class="nota">Valoración: Muy negativa</p>
                    <?php endif; ?>
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
                        <form action="../back/procesar_listas.php" method="POST">
                            <input type="hidden" value="<?= $juego["id_juego"] ?>" name="juego">
                            <input type="hidden" value="<?= $juego["nombre"] ?>" name="nombre">
                            <?php  if($favorito == 0):?>
                                <input type="hidden" value="agregar" name="accion">
                                <input type="hidden" value="1" name="lista">
                                <button type="submit" class="boton_lista"><i class="estrella"></i>Favoritos</button>
                            <?php else:?>
                                <input type="hidden" value="eliminar" name="accion">
                                <input type="hidden" value="1" name="lista">
                                <button type="submit" class="boton_lista activo"><i class="estrella"></i>Favoritos</button>
                            <?php endif ?>
                        </form>
                        
                        <form action="../back/procesar_listas.php" method="POST">
                            <input type="hidden" value="<?= $juego["id_juego"] ?>" name="juego">
                            <input type="hidden" value="<?= $juego["nombre"] ?>" name="nombre">
                            <?php  if($deseos == 0):?>
                                <input type="hidden" value="agregar" name="accion">
                                <input type="hidden" value="2" name="lista">
                                <button type="submit" class="boton_lista"><i class="mas"></i>Deseos</button>
                        
                            <?php else:?>
                                <input type="hidden" value="eliminar" name="accion">
                                <input type="hidden" value="2" name="lista">
                                <button type="submit" class="boton_lista activo"><i class="mas"></i>Deseos</button>
                            <?php endif ?>
                        </form>
                        
                        <form action="../back/procesar_listas.php" method="POST">
                            <input type="hidden" value="<?= $juego["id_juego"] ?>" name="juego">
                            <input type="hidden" value="<?= $juego["nombre"] ?>" name="nombre">
                            <?php  if($posesion == 0):?>
                                <input type="hidden" value="agregar" name="accion">
                                <input type="hidden" value="3" name="lista">
                                <button type="submit" class="boton_lista"><i class="libro"></i>En posesion</button>
                            <?php else :?>
                                <input type="hidden" value="eliminar" name="accion">
                                <input type="hidden" value="3" name="lista">
                                <button type="submit" class="boton_lista activo"><i class="libro"></i>En posesion</button>
                            <?php endif ?>
                        </form>
                    </nav>

                </section>
                <section>
                    <h2>Reseñas y comentarios</h2>
                    <a class="comentar" onclick="abrirModalResena()"><i class="mas"></i>Comentar</a>
                    <?php while($comentario = $comentarios->fetch_assoc()) {?>
                        <?php 
                            $img_url = $comentario["img_url"] ?? 0;
                        ?>
                        <article>
                            <div class="autor">
                                <div class="avatar">
                                    <?php if($img_url === 0): ?>
                                        <i class="usuario"></i>
                                    <?php else: ?>
                                        <img src="<?= $img_url ?>" alt="">
                                    <?php endif ?>
                                </div>
                                <div class="datos">
                                    <a href="user/perfil.php?perfil=<?=$comentario["username"]?>"class="perfil"><strong><?= $comentario["username"] ?></strong></a>
                                    <span><?= $comentario["fecha"] ?></span>
                                </div>
                                <?php if($comentario["me_gusta"] == 1): ?>
                                    <span class="positivo">Me gusta</span>
                                <?php else:?>
                                    <span class="negativo">No me gusta</span>
                                <?php endif ?>
                            </div>
                            <p><?= $comentario["review"] ?></p>
                        </article>
                    <?php } ?>
                </section>
            </div>
        </div>
    </main>
    <script>
        function abrirModal() {
            document.getElementById('modal').style.display = 'flex';
        }

        function cerrarModal() {
            document.getElementById('modal').style.display = 'none';
            document.getElementById('modalResena').style.display = 'none';
        }

        function abrirModalResena() {
            document.getElementById('modalResena').style.display = 'flex';
        }
    </script>
</body>
</html>