<?php
    session_start();
    if (!isset($_SESSION["id_usuario"])) {
        header("Location: http://localhost/GameData/front/logins/login.php");
        exit;
    }
    require "../../back/conexiones/conexion.php";

    $nombre_usuario = $_GET["perfil"];
    $sql_perfil = "SELECT u.id_usuario, u.username, u.fecha_creacion, p.descripcion, p.img_url 
    FROM Usuario AS u
    JOIN Perfil AS p ON u.id_usuario = p.id_usuario WHERE u.username = ?";
    $resultado = $conexion->prepare($sql_perfil);
    $resultado->bind_param("s", $nombre_usuario);
    $resultado->execute();
    $perfil = $resultado->get_result()->fetch_assoc();

    $id_usuario = $perfil["id_usuario"];
    $descripcion = $perfil["descripcion"];
    $img_url = $perfil["img_url"];
    $fecha_creacion = $perfil["fecha_creacion"];

    
    if($descripcion == ''){
        $descripcion = 0;
    }
    if($img_url == ''){
        $img_url = 0;
    }
    

    $sql_juegosListas = "SELECT Juego.id_juego, Juego.img_url, Juego.nombre AS nombre_juego, Lista.nombre AS nombre_lista FROM Juego
    JOIN Usuario_juego ON Juego.id_juego = Usuario_juego.id_juego
    JOIN Lista ON Usuario_juego.id_lista = Lista.id_lista
    WHERE Usuario_juego.id_usuario = ?";

    $listas = $conexion->prepare($sql_juegosListas);
    $listas->bind_param("i", $id_usuario);
    $listas->execute();
    $resultado_listas = $listas->get_result();
    $favoritos=[];
    $deseos=[];
    $posesion=[];
    if ($resultado_listas->num_rows > 0) {
        while($fila = $resultado_listas->fetch_assoc()){
            if ($fila["nombre_lista"] === "favoritos") {
                $favoritos[] = $fila;
            }elseif($fila["nombre_lista"] === "deseo"){
                $deseos[] = $fila;
            }elseif($fila["nombre_lista"] === "posesion"){
                $posesion[] = $fila;
            }
        }
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
                <?php if($nombre_usuario == $_SESSION["username"]): ?>
                    <form action="modificar_perfil.php" method="POST">
                        <input type="hidden" value="<?= $descripcion ?>" name="descripcion">
                        <input type="hidden" value="<?= $img_url ?>" name="img_url">
                        <button class="boton" id="btn-modificar" type="submit">Modificar perfil</button>
                    </form>
                    <a class="boton boton-primario" id="btn-logout" href="../../back/procesar_modificacion_perfil.php?accion=cerrarsesion">Cerrar sesión</a>
                <?php endif ?>
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
                <a class="lista" href="../lista.php?lista=favoritos">
                    <div class="lista-cabecera">
                        <div class="lista-titulo">
                            <i class="estrella"></i>
                            <span>Favoritos</span>
                        </div>
                        <span class="contador"><?= count($favoritos) . " juegos" ?></span>
                    </div>
                    <ul class="juegos">
                        <?php foreach($favoritos as $indice => $favorito){?>
                            <li class="juego">
                                <div class="portada"><img src="<?= $favorito["img_url"] ?>" alt=""> </div>
                                <div class="juego-info">
                                    <p class="juego-nombre"><?= $favorito["nombre_juego"] ?></p>
                                    <p class="juego-etiqueta">Favorito <?= $indice+1 ?></p>
                                </div>
                                <span class="posicion"><?= $indice+1 ?></span>
                            </li>
                        <?php }; ?>
                    </ul>
                </a>

                <a class="lista" href="../lista.php?lista=deseados">
                    <div class="lista-cabecera">
                        <div class="lista-titulo">
                            <i class="mas"></i>
                            <span>Deseados</span>
                        </div>
                        <span class="contador"><?= count($deseos) . " juegos" ?></span>
                    </div>
                    <ul class="juegos">
                        <?php foreach($deseos as $indice => $deseado){?>
                            <li class="juego">
                                <div class="portada"><img src="<?= $deseado["img_url"] ?>" alt=""> </div>
                                <div class="juego-info">
                                    <p class="juego-nombre"><?= $deseado["nombre_juego"] ?></p>
                                    <p class="juego-etiqueta">Favorito <?= $indice+1 ?></p>
                                </div>
                                <span class="posicion"><?= $indice+1 ?></span>
                            </li>
                        <?php }; ?>
                    </ul>
                </a>

                <a class="lista" href="../lista.php?lista=posesion">
                    <div class="lista-cabecera">
                        <div class="lista-titulo">
                            <i class="libro"></i>
                            <span>En posesión</span>
                        </div>
                        <span class="contador"><?= count($posesion) . " juegos" ?></span>
                    </div>
                    <ul class="juegos">
                        <?php foreach($posesion as $indice => $enPosesion){?>
                            <li class="juego">
                                <div class="portada"><img src="<?= $enPosesion["img_url"] ?>" alt=""> </div>
                                <div class="juego-info">
                                    <p class="juego-nombre"><?= $enPosesion["nombre_juego"] ?></p>
                                    <p class="juego-etiqueta">Favorito <?= $indice+1 ?></p>
                                </div>
                                <span class="posicion"><?= $indice+1 ?></span>
                            </li>
                        <?php }; ?>
                    </ul>
                </a>
            </div>
        </section>
    </main>
</body>
</html>