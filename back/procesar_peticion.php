<?php
    require __DIR__ . "/conexiones/conexion.php";
    $accion = $_POST["accion"];
    $id = $_POST["id"];

    if ($accion === "agregar")
    {
        header("Location: ../front/admin/anadirJuego.php");
        exit;
    }

    elseif ($accion === "eliminar")
    {
        $eliminar = $conexion -> prepare("DELETE FROM Peticion WHERE id_peticion = ?");
        $eliminar -> bind_param("i", $id);
        $eliminar -> execute();
        $eliminar -> close();
        header("Location: ../front/admin/verPeticiones.php");
        exit;         
    }

    else
    {
        echo "hola";
    }

?>