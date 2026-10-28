<?php
    session_start();
    if (!isset($_SESSION["id_usuario"])) {
        header("Location: http://localhost/GameData/front/logins/login.php");
        exit;
    }
    require "../../back/conexiones/conexion.php";

    $id_usuario = $_SESSION["id_usuario"];
    $nombre_usuario = $_SESSION["username"];
    $fecha_creacion = $_SESSION["fecha_creacion"];

    $sql_perfil = "SELECT descripcion, img_url FROM Perfil WHERE id_usuario = ?";
    $perfil = $conexion->prepare($sql_perfil);
    $perfil->bind_param("i", $id_usuario);
    $perfil->execute();
    $resultado_perfil = $perfil->get_result();
    if ($resultado_perfil->num_rows > 0) {
        $fila_perfil = $resultado_perfil->fetch_assoc();
        if($fila_perfil["descripcion"] == ''){
            $descripcion = 0;
        }else{
            $descripcion = $fila_perfil["descripcion"];
        }
        if($fila_perfil["img_url"] == ''){
            $img_url = 0;
        }else{
            $img_url = $fila_perfil["img_url"];
        }
    }else{
        $descripcion = 0;
        $img_url = 0;
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@700&family=Space+Grotesk:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../styles/perfil.css">
</head>
<body>
    <main class="contenedor">
        <header class="barra">
            <a class="boton boton-volver" id="btn-volver" href="../index.php">
                <i class="volver"></i>
                Volver
            </a>
            <div class="acciones">
                <form action="modificar_perfil.php" method="POST">
                    <input type="hidden" value="<?= $descripcion ?>" name="descripcion">
                    <input type="hidden" value="<?= $img_url ?>" name="img_url">
                    <button class="boton" id="btn-modificar" type="submit">Modificar perfil</button>
                </form>
                <a class="boton boton-primario" id="btn-logout" href="#">Cerrar sesión</a>
            </div>
        </header>

        <section class="banner">
            <div class="banner-fondo" style="background-image: url(../logos/banner.jpg);"></div>

            <div class="banner-izq">
                <div class="avatar" aria-hidden="true">
                    <?php if($img_url == 0) :?>
                        <i class="usuario"></i>
                    <?php else: ?>
                        <img src="<?= $img_url ?>" alt="no">
                    <?php endif ?>
                </div>
                <div class="datos">
                    <h1 id="nombre"><?= $nombre_usuario ?></h1>
                    <span class="fecha"><span class="punto"></span>Desde: <span id="desde"><?= $fecha_creacion ?></span></span>
                </div>
            </div>

            <div class="biografia">
                <h2>Biografía</h2>
                <?php if($descripcion == 0): ?>
                    <p id="bio">Aun no hay descripcion. Este jugador prefiere dejar que sus partidas hablen por él.</p>
                <?php else: ?>
                    <p id="bio"><?= $descripcion ?></p>
                <?php endif ?>
            </div>
        </section>

        <section class="seccion-listas">
            <h2 class="titulo-seccion">Listas</h2>

            <div class="listas" id="listas">

                <a class="lista" href="#">
                    <div class="lista-cabecera">
                        <div class="lista-titulo">
                            <i class="estrella"></i>
                            <span>Favoritos</span>
                        </div>
                        <span class="contador">2 juegos</span>
                    </div>
                    <ul class="juegos">
                        <li class="juego">
                            <div class="portada"></div>
                            <div class="juego-info">
                                <p class="juego-nombre">Dark Souls</p>
                                <p class="juego-etiqueta">Favorito 1</p>
                            </div>
                            <span class="posicion">1</span>
                        </li>
                        <li class="juego">
                            <div class="portada"></div>
                            <div class="juego-info">
                                <p class="juego-nombre">Dark Souls</p>
                                <p class="juego-etiqueta">Favorito 2</p>
                            </div>
                            <span class="posicion">2</span>
                        </li>
                    </ul>
                </a>

                <a class="lista" href="#">
                    <div class="lista-cabecera">
                        <div class="lista-titulo">
                            <i class="mas"></i>
                            <span>Deseados</span>
                        </div>
                        <span class="contador">2 juegos</span>
                    </div>
                    <ul class="juegos">
                        <li class="juego">
                            <div class="portada"></div>
                            <div class="juego-info">
                                <p class="juego-nombre">Dark Souls</p>
                                <p class="juego-etiqueta">Deseado 1</p>
                            </div>
                            <span class="posicion">1</span>
                        </li>
                        <li class="juego">
                            <div class="portada"></div>
                            <div class="juego-info">
                                <p class="juego-nombre">Dark Souls</p>
                                <p class="juego-etiqueta">Deseado 2</p>
                            </div>
                            <span class="posicion">2</span>
                        </li>
                    </ul>
                </a>

                <a class="lista" href="#">
                    <div class="lista-cabecera">
                        <div class="lista-titulo">
                            <i class="libro"></i>
                            <span>En posesión</span>
                        </div>
                        <span class="contador">2 juegos</span>
                    </div>
                    <ul class="juegos">
                        <li class="juego">
                            <div class="portada"></div>
                            <div class="juego-info">
                                <p class="juego-nombre">Dark Souls</p>
                                <p class="juego-etiqueta">En posesión 1</p>
                            </div>
                            <span class="posicion">1</span>
                        </li>
                        <li class="juego">
                            <div class="portada"></div>
                            <div class="juego-info">
                                <p class="juego-nombre">Dark Souls</p>
                                <p class="juego-etiqueta">En posesión 2</p>
                            </div>
                            <span class="posicion">2</span>
                        </li>
                    </ul>
                </a>

            </div>
        </section>
    </main>
</body>
</html>