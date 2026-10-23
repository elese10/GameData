<?php
    session_start();
    $tipo_user = $_SESSION["tipo_user"];
    if ($tipo_user !== 1)
    {
        header("Location: #"); //Falta poner ubicacion
        exit();
    }
    require __DIR__ . "../../../back/conexiones/conexion.php";
    $mensaje = $_GET["mensaje"] ?? "";

    $id_juego = $_GET["id_juego"] ?? "";

    $datosJuego = $conexion -> prepare("SELECT nombre, descripcion, img_url FROM Juego WHERE id_juego = ?");
    $datosJuego -> bind_param("i", $id_juego);
    $datosJuego -> execute();
    $juegos = $datosJuego -> get_result();
    $juego = $juegos -> fetch_assoc();
    $datosJuego -> close();

    $nombreJuego = $juego["nombre"];
    $descripcion = $juego["descripcion"];
    $url_img = $juego["img_url"];


    $juegoCategorias = $conexion -> prepare("SELECT id_categoria FROM Juego_categoria WHERE id_juego = ?");
    $juegoCategorias -> bind_param("i", $id_juego);
    $juegoCategorias -> execute();
    $indiceCategorias = ($juegoCategorias -> get_result()) -> fetch_all(MYSQLI_NUM);
    $juegoCategorias -> close();

    $busquedaCategorias = $conexion -> prepare("SELECT nombre FROM Categoria WHERE id_categoria = ? OR id_categoria = ? OR id_categoria = ?");
    $busquedaCategorias -> bind_param("iii", $indiceCategorias[0][0], $indiceCategorias[1][0], $indiceCategorias[2][0]);
    $busquedaCategorias -> execute();
    $nombreCategorias = ($busquedaCategorias -> get_result()) -> fetch_all(MYSQLI_NUM);
    $busquedaCategorias -> close();
?>

<!DOCTYPE html>
<html lang="es">


    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Game Data | Modificar juego</title>
        <link rel="stylesheet" href="../styles/gestion_juegos.css">
    </head>


    <body>
        <main class="pagina-agregar-juego">
            <section class="panel-formulario" aria-labelledby="titulo-formulario">
                <a class="enlace-volver" href="../juego.php?juego=<?= str_replace(' ', '-', $nombreJuego) ?>">← Volver al juego</a>
                <h1 id="titulo-formulario">Modificar juego</h1>
                <br><br>

                <form class="formulario-juego" id="formulario-juego" action="../../back/procesar_modificacion_juego.php" method="POST">
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
                            value="<?= htmlspecialchars($nombreJuego) ?>"
                            required
                        >
                        <?php if ($mensaje === "repetido"): ?>
                            <p>Este juego ya existe</p>
                        <?php elseif($mensaje === "juego_modificado"): ?>
                            <p>Juego Modificado correctamente</p>
                        <?php endif; ?>
                        <input
                            class="entrada-formulario"
                            id="url-imagen"
                            name="url_imagen"
                            type="url"
                            placeholder="URL de imagen"
                            value="<?= htmlspecialchars($url_img) ?>"
                            required
                        >

                        <textarea
                            class="entrada-formulario campo-descripcion"
                            id="descripcion-juego"
                            name="descripcion"
                            maxlength="2000"
                            placeholder="Descripcion"
                            required
                        ><?= htmlspecialchars($descripcion) ?></textarea>
                    </div>

                    <div class="opciones-juego">
                        <span class="etiqueta-campo">Categorías</span>
                        <div class="fila-categorias">
                            <select class="entrada-formulario selector-categoria" name="categoria1" aria-label="Primera categoría" required>
                                <option value="" selected disabled>Categoria 1</option>
                                <option value="Accion" <?= $nombreCategorias[0][0] === "Accion" ? "selected" : "" ?>>Accion</option>
                                <option value="Aventura" <?= $nombreCategorias[0][0] === "Aventura" ? "selected" : "" ?>>Aventura</option>
                                <option value="RPG" <?= $nombreCategorias[0][0] === "RPG" ? "selected" : "" ?>>RPG</option>
                                <option value="Estrategia" <?= $nombreCategorias[0][0] === "Estrategia" ? "selected" : "" ?>>Estrategia</option>
                                <option value="Simulacion" <?= $nombreCategorias[0][0] === "Simulacion" ? "selected" : "" ?>>Simulacion</option>
                                <option value="Deportes" <?= $nombreCategorias[0][0] === "Deportes" ? "selected" : "" ?>>Deportes</option>
                                <option value="Terror" <?= $nombreCategorias[0][0] === "Terror" ? "selected" : "" ?>>Terror</option>
                            </select>

                            <select class="entrada-formulario selector-categoria" name="categoria2" aria-label="Segunda categoría" required>
                                <option value="" selected disabled>Categoria 2</option>
                                <option value="Accion" <?= $nombreCategorias[1][0] === "Accion" ? "selected" : "" ?>>Accion</option>
                                <option value="Aventura" <?= $nombreCategorias[1][0] === "Aventura" ? "selected" : "" ?>>Aventura</option>
                                <option value="RPG" <?= $nombreCategorias[1][0] === "RPG" ? "selected" : "" ?>>RPG</option>
                                <option value="Estrategia" <?= $nombreCategorias[1][0] === "Estrategia" ? "selected" : "" ?>>Estrategia</option>
                                <option value="Simulacion" <?= $nombreCategorias[1][0] === "Simulacion" ? "selected" : "" ?>>Simulacion</option>
                                <option value="Deportes" <?= $nombreCategorias[1][0] === "Deportes" ? "selected" : "" ?>>Deportes</option>
                                <option value="Terror" <?= $nombreCategorias[1][0] === "Terror" ? "selected" : "" ?>>Terror</option>
                            </select>
                            
                            <select class="entrada-formulario selector-categoria" name="categoria3" aria-label="Tercera categoría" required>
                                <option value="" selected disabled>Categoria 3</option>
                                <option value="Accion" <?= $nombreCategorias[2][0] === "Accion" ? "selected" : "" ?>>Accion</option>
                                <option value="Aventura" <?= $nombreCategorias[2][0] === "Aventura" ? "selected" : "" ?>>Aventura</option>
                                <option value="RPG" <?= $nombreCategorias[2][0] === "RPG" ? "selected" : "" ?>>RPG</option>
                                <option value="Estrategia" <?= $nombreCategorias[2][0] === "Estrategia" ? "selected" : "" ?>>Estrategia</option>
                                <option value="Simulacion" <?= $nombreCategorias[2][0] === "Simulacion" ? "selected" : "" ?>>Simulacion</option>
                                <option value="Deportes" <?= $nombreCategorias[2][0] === "Deportes" ? "selected" : "" ?>>Deportes</option>
                                <option value="Terror" <?= $nombreCategorias[2][0] === "Terror" ? "selected" : "" ?>>Terror</option>
                            </select>
                        </div>
                        <?php if ($mensaje === "categoria_invalida"): ?>
                            <p>Categorias Invalidas</p>
                        <?php endif; ?>
                        
                        <input type="hidden" name="id_juego" value=<?= $id_juego ?>>
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
                    vistaPreviaPortada.style.backgroundImage = `url("${urlImagen}")`;
                    vistaPreviaPortada.classList.add('con-imagen');
                    return;
                }

                vistaPreviaPortada.style.backgroundImage = 'none';
                vistaPreviaPortada.classList.remove('con-imagen');
            }

            campoUrlImagen.addEventListener('input', actualizarVistaPrevia);
            actualizarVistaPrevia();
        </script> 
    </body>

</html>
