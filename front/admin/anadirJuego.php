<?php
    session_start();
    $tipo_user = $_SESSION["tipo_user"];
    if ($tipo_user !== 1)
    {
        header("Location: logins/login.php");
        exit();
    }

    $mensaje = $_GET["mensaje"];
?>
<!DOCTYPE html>
<html lang="es">


    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Game Data | Añadir juego</title>
        <link rel="stylesheet" href="../styles/gestion_juegos.css">
    </head>


    <body>
        <main class="pagina-agregar-juego">
            <section class="panel-formulario" aria-labelledby="titulo-formulario">
                <a class="enlace-volver" href="../index.php">← Volver al inicio</a>
                <h1 id="titulo-formulario">Añadir juego</h1>
                <br><br>

                <form class="formulario-juego" id="formulario-juego" action="../../back/procesar_juego.php" method="POST">
                    <div class="campos-juego">
                        
                        <div class="vista-previa" id="vista-previa-portada">
                            <span>Vista previa de la portada</span>
                        </div>

                        <input
                            class="entrada-formulario"
                            id="nombre-juego"
                            name="nombre_juego"
                            type="text"
                            maxlength="160"
                            placeholder="Nombre del juego"
                            required
                        >
                        <?php if ($mensaje === "repetido"): ?>
                            <p>Este juego ya existe</p>
                        <?php endif; ?>

                        <input
                            class="entrada-formulario"
                            id="url-imagen"
                            name="url_imagen"
                            type="url"
                            placeholder="URL de la imagen"
                            required
                        >

                        <textarea
                            class="entrada-formulario campo-descripcion"
                            id="descripcion-juego"
                            name="descripcion"
                            maxlength="2000"
                            placeholder="Descripcion"
                            required
                        ></textarea>
                    </div>

                    <div class="opciones-juego">
                        <span class="etiqueta-campo">Categorías</span>
                        <div class="fila-categorias">
                            <select class="entrada-formulario selector-categoria" name="categoria1" aria-label="Primera categoría" required>
                                <option value="" selected disabled>Categoría 1</option>
                                <option>Accion</option>
                                <option>Aventura</option>
                                <option>RPG</option>
                                <option>Estrategia</option>
                                <option>Simulacion</option>
                                <option>Deportes</option>
                                <option>Terror</option>
                            </select>

                            <select class="entrada-formulario selector-categoria" name="categoria2" aria-label="Segunda categoría" required>
                                <option value="" selected disabled>Categoría 2</option>
                                <option>Accion</option>
                                <option>Aventura</option>
                                <option>RPG</option>
                                <option>Estrategia</option>
                                <option>Simulacion</option>
                                <option>Deportes</option>
                                <option>Terror</option>
                            </select>
                            
                            <select class="entrada-formulario selector-categoria" name="categoria3" aria-label="Tercera categoría" required>
                                <option value="" selected disabled>Categoría 3</option>
                                <option>Accion</option>
                                <option>Aventura</option>
                                <option>RPG</option>
                                <option>Estrategia</option>
                                <option>Simulacion</option>
                                <option>Deportes</option>
                                <option>Terror</option>
                            </select>
                        </div>
                        <?php if ($mensaje === "categoria_invalida"): ?>
                            <p>Categorias Invalidas</p>
                        <?php endif; ?>
                        
                        <div class="acciones-formulario">
                            <a class="boton-cancelar" href="#">Cancelar</a>
                            <button class="boton-agregar" type="submit">Añadir</button>
                        </div>
                    </div>
                </form>
            </section>
        </main>


        <script>
            const campoUrlImagen = document.getElementById('url-imagen');
            const vistaPreviaPortada = document.getElementById('vista-previa-portada');
            const formularioJuego = document.getElementById('formulario-juego');

            function actualizarVistaPrevia() 
            {
                const urlImagen = campoUrlImagen.value.trim();

                if (urlImagen.length > 0) 
                {
                    const urlParaFondo = urlImagen.replaceAll();
                    vistaPreviaPortada.style.backgroundImage = `url("${urlParaFondo}")`;
                    vistaPreviaPortada.classList.add('con-imagen');
                    return;
                }

                vistaPreviaPortada.style.backgroundImage = 'none';
                vistaPreviaPortada.classList.remove('con-imagen');
            }

            campoUrlImagen.addEventListener('input', actualizarVistaPrevia);
        </script> 
    </body>

</html>
