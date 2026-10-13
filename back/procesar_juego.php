<?php
    require __DIR__ . "/conexiones/conexion.php";

    $nombreJuego = $_POST["nombre_juego"] ?? "";
    $descripcion = $_POST["descripcion"] ?? "";
    $urlImagen = $_POST["url_imagen"] ?? "";

    $categoria1 = $_POST["categoria1"] ?? "";
    $categoria2 = $_POST["categoria2"] ?? "";
    $categoria3 = $_POST["categoria3"] ?? "";

    
    $comprobarJuego = $conexion -> prepare("SELECT * FROM Juego WHERE nombre = ?");
    $comprobarJuego -> bind_param("s", $nombreJuego);
    $comprobarJuego -> execute();
    $juego = $comprobarJuego -> get_result();
    $comprobarJuego -> close();

    if ($juego -> num_rows > 0)
    {
        header("Location: #?mensaje=repetido"); //Falta poner ubicacion
        exit;
    }

    $categorias = $conexion -> prepare("SELECT id_categoria FROM Categoria WHERE nombre = ? OR nombre = ? OR nombre = ?");
    $categorias -> bind_param("sss", $categoria1, $categoria2, $categoria3);
    $categorias -> execute();
    $categoria = $categorias -> get_result();
    $categorias -> close();

    if ($categoria -> num_rows < 3)
    {
        header("Location: #?mensaje=categoria_invalida"); // Falta poner ubicacion
        exit;
    }

    $insercion_juego = $conexion -> prepare("INSERT INTO Juego (nombre, descripcion, img_url) VALUES (?, ?, ?)");
    $insercion_juego -> bind_param("sss", $nombreJuego, $descripcion, $urlImagen);
    $insercion_juego -> execute();
    $id_juego = $conexion->insert_id;
    $insercion_juego -> close();

    $id_categoria = $categoria -> fetch_all(MYSQLI_NUM);
    $juego_categoria = $conexion -> prepare("INSERT INTO Juego_categoria (id_juego, id_categoria) VALUES (?, ?), (?, ?), (?, ?)");
    $juego_categoria -> bind_param("iiiiii", $id_juego, $id_categoria[0][0], $id_juego, $id_categoria[1][0], $id_juego, $id_categoria[2][0]);
    $juego_categoria -> execute();
    $juego_categoria -> close();
    
    header("Location: #"); //Falta poner ubicacion
    exit;
?>