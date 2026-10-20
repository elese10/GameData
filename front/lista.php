<?php
    require "../back/conexiones/conexion.php";
    session_start();
    if (!isset($_SESSION["id_usuario"])) {
        header("Location: http://localhost/GameData/front/logins/login.php");
        exit;
    }
    $id_usuario = $_SESSION["id_usuario"];
    $nombre_usuario = $_SESSION["username"];
    $rol = $_SESSION["tipo_user"];
    $lista = $_GET["lista"];

    if($lista === "favoritos"){
        $lista = 1;
    }else if($lista === "deseados"){
        $lista = 2;
    }else if($lista === "posesion"){
        $lista = 3;
    } else{
        header("Location: index.php");
    }

    $sql = "SELECT j.id_juego, j.nombre, j.img_url, GROUP_CONCAT(c.nombre SEPARATOR ', ') AS Categorias
    FROM Juego AS j
    JOIN Juego_categoria AS jc ON j.id_juego = jc.id_juego
    JOIN Categoria AS c ON jc.id_categoria = c.id_categoria
    WHERE j.id_juego IN 
    (SELECT id_juego FROM Usuario_juego WHERE id_usuario = ? AND id_lista = ?)
    GROUP BY j.id_juego, j.nombre, j.img_url ;";
    $resultado = $conexion->prepare($sql);
    $resultado->bind_param("ii", $id_usuario, $lista);
    $resultado->execute();
    $res_lista = $resultado->get_result();

    if ($res_lista->num_rows > 0) {
        $bandera = 1;
    }else{
        $bandera = 0;
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Data | Inicio</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
    
    <aside>
        <a href="index.php" class="header">
            <div class="logo">GD</div>
            <div class="nombre">
                <span class="juego">Game</span>
                <span class="data">Data</span>
            </div>
        </a>

        <!-- //si el usuario es un usuario comun tiene este nav// -->
        <nav>
            <a href="index.php"><i class="inicio"></i>Inicio</a>
            <?php if($rol == 0):?>
                <a class="boton_modal" onclick="abrirModal()"><i class="mas"></i>Solicitar Juego</a>
            <?php endif?>
            <a href="resenas.php"><i class="estrella"></i>Reseñas</a>
            <a href="amigos.php"><i class="usuario"></i>Amigos</a>
        </nav>

        <!-- //si el usuario es un administrador tiene este nav// -->
        <?php if($rol == 1) :?>
            <nav class="nav-admin"> 
                <h2>Herramientas de Admin</h2>           
                <a href="admin/verPeticiones.php"><i class="libro"></i>Ver solicitudes</a>
                <a href="admin/anadirJuego.php"><i class="mas"></i>Agregar Juego</a>
            </nav>
        <?php endif?>
        <a href="perfil.php" class="perfil">
            <div class="avatar"><i class="usuario"></i></div>
            <div class="datos">
                <strong><?= $nombre_usuario ?></strong>
                <span>Perfil principal</span>
            </div>
        </a>
    </aside>

    <!-- Modal de peticion de juegos -->
    <div id="modal" class="modal_overlay">
        <div class="modal_contenedor">
            <div class="modal_header">
                <h2>Solicitar juego</h2>
                <p>
                    Completa los datos para que los administradores revisen y agreguen el juego a la plataforma.
                </p>
            </div>
            <form action="../back/procesar_solicitudJuego.php" method="POST">
                <div class="nombre_peticion">
                    <h2>Nombre Juego</h2>
                    <input type="text" placeholder="Ej: Hollow Knight: Silksong" name="nombre" required>
                </div>
                <div class="descripcion_peticion">
                    <h2>Descripcion</h2>
                    <textarea name="descripcion" id="" placeholder="Describe brevemente el juego, género o por qué te gustaría que lo agreguemos" required></textarea>
                </div>
                <div class="modal_botones">
                    <button type="button" class="boton boton_cancelar" onclick="cerrarModal()">Cancelar</button>
                    <button type="submit" class="boton boton_agregar">Solicitar</button>
                </div>
            </form>
        </div>
    </div>

    
    <main>
        <!-- //barra de busqueda y botones de listas// -->
        <div class="barra">
            <form class="buscador" action="#">
                <i class="buscar"></i>
                <input type="search" placeholder="Buscar juegos, usuarios">
            </form>
            <nav>
                <?php if($lista == 1) :?>
                    <a href="lista.php?lista=favoritos" class="activo"><i class="estrella"></i>Favoritos</a>
                <?php else: ?>
                    <a href="lista.php?lista=favoritos"><i class="estrella"></i>Favoritos</a>
                <?php endif ?>
                <?php if($lista == 2) :?>
                    <a href="lista.php?lista=deseados" class="activo"><i class="mas"></i>Deseados</a>
                <?php else: ?>
                    <a href="lista.php?lista=deseados"><i class="mas"></i>Deseados</a>
                <?php endif ?>
                <?php if($lista == 3) :?>
                    <a href="lista.php?lista=posesion" class="activo"><i class="libro"></i>En posesión</a>
                <?php else: ?>
                    <a href="lista.php?lista=posesion"><i class="libro"></i>En posesión</a>
                <?php endif ?>
            </nav>
        </div>
        
        <div class="contenedor_lista">
            <div class="cabecera">
            <?php if($lista == 1):?>
                <h1>Favoritos</h1>
                <p>Mis juegos favoritos, reunidos en mi lista personal.</p>
            <?php elseif($lista == 2) :?>
                <h1>Deseados</h1>
                <p>Los juegos que me gustarian tener, guardados en mi lista de deseos.</p>
            <?php elseif($lista == 3):?>
                <h1>En posesion</h1>
                <p>Los juegos que tengo reunidos en mi colección personal.</p>
            <?php endif?>
            </div>
            <div class="juegos_lista">
                <?php if($bandera == 0):?>
                    <div class="vacio">
                        <div class="img"></div>
                         <?php if($lista == 1):?>
                            <h1>Tus favoritos están descansando.</h1>
                            <p>Aún no hay juegos aquí. Añade aqui los que se ganaron un lugar en tu corazón.</p>
                        <?php elseif($lista == 2) :?>
                            <h1>Tu próxima aventura aún no está en la lista.</h1>
                            <p>Por ahora, el control descansa. Guarda aquí los juegos que te gustaría tener.</p>
                        <?php elseif($lista == 3):?>
                            <h1>Inventario vacío.</h1>
                            <p>Aún no has añadido juegos a tu colección.</p>
                        <?php endif?>
                    </div>
                <?php else :?>
                    <section class="agregados">
                        <div class="grilla">
                            <?php
                            while($juego = $res_lista -> fetch_assoc()){
                            ?>
                                <article>
                                    <!-- str_replace remplaza los simbolos de un string que asignes por otro simbolo que le asignes -->
                                    <a href="juego.php?juego=<?= str_replace(' ', '-', $juego["nombre"]) ?>"><img src="<?= $juego["img_url"]?>" alt="<?= $juego["nombre"]?>"></a>
                                    <div class="info">
                                        <h3><?= $juego["nombre"] ?></h3>
                                        <div class="etiquetas">
                                            <?php  $cats = explode(",", $juego["Categorias"])?>
                                            <?php foreach($cats as $cat){?>
                                                <span><?= $cat ?></span>       
                                            <?php } ?> 
                                        </div>
                                    </div>
                                </article>
                            <?php
                            };
                            ?>
                        </div>
                    </section>
                <?php endif?>
            </div>
        </div>
    </main>
    <script>
        function abrirModal() {
            document.getElementById('modal').style.display = 'flex';
        }

        function cerrarModal() {
            document.getElementById('modal').style.display = 'none';
        }
    </script>
</body>
</html>