<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../styles/perfil.css">
</head>
<body>
    <main class="contenedor">
        <header class="barra">
            <button class="boton boton-secundario" id="btn-volver" type="button">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                Volver
            </button>
            <div class="acciones">
                <button class="boton boton-secundario" id="btn-modificar" type="button">Modificar perfil</button>
                <button class="boton boton-primario" id="btn-logout" type="button">Cerrar sesión</button>
            </div>
        </header>

        <section class="banner">
            <div class="usuario">
                <div class="avatar" aria-hidden="true">
                    <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="4"/><path d="M4 21v-1a6 6 0 0 1 6-6h4a6 6 0 0 1 6 6v1"/></svg>
                </div>
                <div class="datos">
                    <h1 id="nombre">Usuario</h1>
                    <span class="fecha"><i class="punto"></i>Desde: <span id="desde">05-07-2026</span></span>
                </div>
            </div>
            <div class="biografia">
                <h2>Biografía</h2>
                <p id="bio">Soy un jugador que registra sus juegos, comparte listas y busca recomendaciones con un toque personal. Me gusta explorar mundos oscuros, seguir historias densas y completar colecciones con cuidado.</p>
            </div>
        </section>

        <h2 class="titulo-seccion">Listas</h2>
        <section class="listas" id="listas"></section>
    </main>

    <scrip src="script.js"></script>
  </body>
</html>