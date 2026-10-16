<?php
    require_once __DIR__ . "/../../back/conexiones/conexion.php";
    

    $traerPeticion = $conexion -> prepare("SELECT id_peticion, peticion_juego, peticion_descripcion, estado FROM Peticion WHERE estado = 'pendiente'");
    $traerPeticion -> execute();
    $peticiones = ($traerPeticion -> get_result()) -> fetch_all(MYSQLI_ASSOC);
    $traerPeticion -> close();
?>

<!DOCTYPE html>
<html lang="es">


    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Peticiones</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="../../front/styles/gestion_juegos.css">
    </head>

    <body>
    <div class="layout">
        <aside class="lateral">
            <div class="lateral-superior">
                <div class="header">
                    <div class="logo">GD</div>
                    <div class="nombre">
                        <span class="juego">Game</span>
                        <span class="data">Data</span>
                    </div>
                </div>

                <nav class="menu">
                    <a class="enlace" href="inicio.html">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 11l9-8 9 8v10a1 1 0 0 1-1 1h-5v-7H9v7H4a1 1 0 0 1-1-1z"/>
                        </svg>
                        Inicio
                    </a>
                    <a class="enlace" href="resenias.html">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linejoin="round">
                            <path d="M12 3l2.7 5.6 6.1.9-4.4 4.3 1 6.1L12 17l-5.4 2.9 1-6.1L3.2 9.5l6.1-.9z"/>
                        </svg>
                        Reseñas
                    </a>
                    <a class="enlace" href="amigos.html">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="4"/>
                            <path d="M4 21v-1a6 6 0 0 1 6-6h4a6 6 0 0 1 6 6v1"/>
                        </svg>
                        Amigos
                    </a>

                    <hr class="separador">

                    <a class="enlace activo" href="peticiones.html" aria-current="page">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="3" width="16" height="18" rx="2"/>
                            <path d="M8 8h8M8 12h8M8 16h5"/>
                        </svg>
                        Peticiones
                    </a>
                    <a class="enlace" href="anadirJuego.php">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                            <path d="M12 5v14M5 12h14"/>
                        </svg>
                        Añadir juego
                    </a>
                </nav>
            </div>

            <a class="cuenta" href="perfil.html">
                <span class="cuenta-avatar" aria-hidden="true">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="4"/><path d="M4 21v-1a6 6 0 0 1 6-6h4a6 6 0 0 1 6 6v1"/></svg>
                </span>
                <span class="cuenta-datos">
                    <span class="cuenta-nombre" id="cuenta-nombre">Admin</span>
                    <span class="cuenta-rol" id="cuenta-rol">Perfil principal</span>
                </span>
            </a>
        </aside>

        <main class="contenido">
            <label class="buscador">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="11" cy="11" r="7"/><path d="M20 20l-3.5-3.5"/></svg>
                <input type="search" id="buscador" placeholder="Buscar juego, usuario">
            </label>

            <h1 class="titulo">Peticiones</h1>

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
                            <button class="boton-peticion boton-aprobar" type="submit">
                                <svg class="icono-boton" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                    <path d="M7.5 9.16667L10 11.6667L18.3333 3.33333M17.5 10V15.8333C17.5 16.2754 17.3244 16.6993 17.0118 17.0118C16.6993 17.3244 16.2754 17.5 15.8333 17.5H4.16667C3.72464 17.5 3.30072 17.3244 2.98816 17.0118C2.67559 16.6993 2.5 16.2754 2.5 15.8333V4.16667C2.5 3.72464 2.67559 3.30072 2.98816 2.98816C3.30072 2.67559 3.72464 2.5 4.16667 2.5H13.3333" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                Aprobar
                            </button>
                        </form>
        


                        <form action="../../back/procesar_peticion.php" method="POST">
                            <input type="hidden" value="eliminar" name="accion">
                            <input type="hidden" name="id" value="<?= $peticion["id_peticion"] ?>">
                            <button class="boton-peticion boton-rechazar" type="submit">
                                <svg class="icono-boton" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M4 7h16M9 7V4h6v3M6 7l1 13h10l1-13"/>
                                </svg>
                                Rechazar
                            </button>
                        </form>
                    </div>
                </article>
            <?php endforeach; ?>
            

            </section>
        </main>

    </div>
    </body>


</html>