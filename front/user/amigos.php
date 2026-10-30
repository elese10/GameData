<?php
    session_start();
    if (!isset($_SESSION["id_usuario"])) {
        header("Location: http://localhost/GameData/front/logins/login.php");
        exit;
    }
    require "../../back/conexiones/conexion.php";

    $sql_amigos = "SELECT u.id_usuario,u.username,p.img_url FROM Solicitud_Amistad AS a
    JOIN Usuario AS u ON u.id_usuario = 
    CASE 
        WHEN a.id_solicitante = ? THEN a.id_destinatario
        ELSE a.id_solicitante
    END
    LEFT JOIN Perfil AS p ON p.id_usuario = u.id_usuario WHERE 
    (a.id_solicitante = ? OR a.id_destinatario = ?) AND a.estado = 'aceptada'";
    $res_amigos = $conexion->prepare($sql_amigos);
    $res_amigos->bind_param("iii", $_SESSION["id_usuario"], $_SESSION["id_usuario"], $_SESSION["id_usuario"]);
    $res_amigos->execute();
    $amigos = $res_amigos->get_result()->fetch_all(MYSQLI_ASSOC);

    $sql_solicitudes = "SELECT u.id_usuario, u.username, p.img_url, a.id_solicitante FROM Solicitud_Amistad AS a
    JOIN Usuario AS u ON u.id_usuario = a.id_solicitante
    JOIN Perfil AS p ON u.id_usuario = p.id_usuario
    WHERE a.id_destinatario = ? AND a.estado = 'pendiente'";
    $res_solicitudes = $conexion->prepare($sql_solicitudes);
    $res_solicitudes->bind_param("i", $_SESSION["id_usuario"]);
    $res_solicitudes->execute();
    $solicitudes = $res_solicitudes->get_result()->fetch_all(MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amigos</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@700&family=Space+Grotesk:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../styles/amigos.css">
</head>
<body>
    <main class="amigos-contenedor">
        <header class="amigos-barra">
            <a class="amigos-boton amigos-boton-volver" href="../index.php">
                <i class="icono-volver" aria-hidden="true"></i>
                Volver
            </a>
        </header>

        <section class="amigos-contenido">
            <div class="amigos-titulo-pagina">
                <h1>Amigos</h1>
                <p>Revisa a tus amigos y responde las solicitudes de amistad.</p>
            </div>

            <div class="amigos-columnas">
                <section class="amigos-panel" aria-labelledby="titulo-amigos">
                    <header class="amigos-panel-cabecera">
                        <div class="amigos-panel-titulo">
                            <i class="icono-usuario icono-morado" aria-hidden="true"></i>
                            <h2 id="titulo-amigos">Amigos</h2>
                        </div>
                        <span class="amigos-contador"><?= count($amigos) . " amigos"?></span>
                    </header>

                    <div class="amigos-lista">
                        <?php foreach($amigos as $indice=>$amigo){?>
                            <article class="amigos-fila">
                                <div class="amigos-perfil-resumen">
                                    <?php if($amigo["img_url"]!== ''): ?>
                                        <div class="amigos-avatar"><img src="<?= $amigo["img_url"] ?>" alt=""></i></div>
                                    <?php else: ?>
                                        <div class="amigos-avatar"><i class="icono-usuario" aria-hidden="true"></i></div>
                                    <?php endif ?>
                                    <div class="amigos-datos">
                                        <h3><?= $amigo["username"] ?></h3>
                                        <span><a href="perfil.php?perfil=<?=$amigo["username"]?>">Ver perfil</a></span>
                                    </div>
                                </div>
                            </article>
                        <?php } ?>
                    </div>
                </section>

                <section class="amigos-panel" aria-labelledby="titulo-solicitudes">
                    <header class="amigos-panel-cabecera">
                        <div class="amigos-panel-titulo">
                            <i class="icono-mas icono-morado" aria-hidden="true"></i>
                            <h2 id="titulo-solicitudes">Solicitudes</h2>
                        </div>
                        <span class="amigos-contador"><?= count($solicitudes) . " solicitudes"?></span>
                    </header>
                    
                    <div class="amigos-lista amigos-lista-solicitudes">
                        <?php foreach($solicitudes as $indice => $solicitud) {?>
                        <article class="amigos-fila amigos-fila-solicitud">
                            <div class="amigos-perfil-resumen">
                                <?php if($amigo["img_url"] === ''): ?>
                                    <div class="amigos-avatar"><i class="icono-usuario" aria-hidden="true"></i></div>
                                <?php else: ?>
                                    <div class="amigos-avatar"><img src="<?= $solicitud["img_url"] ?>" alt=""></i></div>
                                <?php endif ?>
                                <div class="amigos-datos">
                                    <h3><?= $solicitud["username"] ?></h3>
                                    <span>Quiere ser tu amigo</span>
                                </div>
                            </div>
                            <div class="amigos-acciones">
                                <form action="../../back/procesar_solicitudAmistad.php?accion=aceptar" method="POST">
                                    <input type="hidden" value="<?= $_SESSION["id_usuario"] ?>" name="id_destinatario">
                                    <input type="hidden" value="<?= $solicitud["id_solicitante"] ?>" name="id_solicitante">
                                    <button class="amigos-boton-aceptar" type="submit">Aceptar</button>
                                </form>
                                <form action="../../back/procesar_solicitudAmistad.php?accion=rechazar" method="POST">
                                    <input type="hidden" value="<?= $_SESSION["id_usuario"] ?>" name="id_destinatario">
                                    <input type="hidden" value="<?= $solicitud["id_solicitante"] ?>" name="id_solicitante">
                                    <button class="amigos-boton-rechazar" type="submit">Rechazar</button>
                                </form>
                            </div>
                        </article>
                        <?php } ?>
                    </div>
                </section>
            </div>
        </section>
    </main>
</body>
</html>
