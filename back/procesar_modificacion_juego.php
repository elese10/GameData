<?php
    require __DIR__ . "/conexiones/conexion.php";

    $id_juego = $_POST["id_juego"];

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

    if ($juego -> num_rows > 1)
    {
        header("Location: ../front/admin/modificarJuego.php?mensaje=repetido"); //Falta poner ubicacion
        exit;
    }

    $categorias = $conexion -> prepare("SELECT id_categoria FROM Categoria WHERE nombre = ? OR nombre = ? OR nombre = ?");
    $categorias -> bind_param("sss", $categoria1, $categoria2, $categoria3);
    $categorias -> execute();
    $categoria = $categorias -> get_result();
    $categorias -> close();

    if ($categoria -> num_rows > 3)
    {
        header("Location: ../front/admin/modificarJuego.php?mensaje=categoria_invalida"); //Falta poner la ubicacion
        exit;
    }

    $editarJuego = $conexion -> prepare("UPDATE Juego SET nombre=?, descripcion=?, img_url=? WHERE id_juego = ?");
    $editarJuego -> bind_param("sssi", $nombreJuego, $descripcion, $urlImagen, $id_juego);
    $editarJuego -> execute();
    $editarJuego -> close();

    
    $id_categoria = $categoria -> fetch_all(MYSQLI_NUM);


    $eliminarCategorias = $conexion -> prepare("DELETE from Juego_categoria WHERE id_juego = ?");
    $eliminarCategorias -> bind_param("i",$id_juego);
    $eliminarCategorias -> execute();
    $eliminarCategorias -> close();


    $juego_categoria = $conexion -> prepare("INSERT INTO Juego_categoria (id_juego, id_categoria) VALUES (?, ?), (?, ?), (?, ?)");
    $juego_categoria -> bind_param("iiiiii", $id_juego, $id_categoria[0][0], $id_juego, $id_categoria[1][0], $id_juego, $id_categoria[2][0]);
    $juego_categoria -> execute();
    $juego_categoria -> close();
    
    header("Location: ../front/admin/modificarJuego.php?mensaje=juego_modificado");
    exit;
?>