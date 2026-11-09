<?php
    require_once __DIR__."/header.php";
    $self = htmlentities($_SERVER["PHP_SELF"]);

    if(!isset($_SESSION["itemID"])) {
        header("Location: index.php");
        exit();
    }

    $itemId = $_SESSION["itemID"];
    $item = itemPorId($conexion, $itemId);

    $msg = "";
    if(isset($_POST["subir"])) {
        if($_POST["cantidad"] == "") {
            $msg = "Tienes que introducir una cantidad";
        }
        else {
            cambiarPrecio($conexion, $itemId, $item->preciopartida + $_POST["cantidad"]);
        }
    }

    if(isset($_POST["bajar"])) {
        if($_POST["cantidad"] == "") {
            $msg = "Tienes que introducir una cantidad";
        }
        else {
            if($item->preciopartida - $_POST["cantidad"] <= 0) {
                $msg = "El precio de partida tiene que ser mayor a 0";
            }
            else {
                cambiarPrecio($conexion, $itemId, $item->preciopartida - $_POST["cantidad"]);
            }
        }
    }

    if(isset($_POST["unahora"])) {
        $fecha = DateTime::createFromFormat("Y-m-d H:i:s", $item->fechafin);
        $nuevaFecha = $fecha -> modify("+60 minutes");
        $nuevaFecha = $nuevaFecha -> format("Y-m-d H:i:s");

        cambiarHora($conexion, $itemId, $nuevaFecha);
    }

    if(isset($_POST["undia"])) {
        $fecha = DateTime::createFromFormat("Y-m-d H:i:s", $item->fechafin);
        $nuevaFecha = $fecha -> modify("+1 day");
        $nuevaFecha = $nuevaFecha -> format("Y-m-d H:i:s");

        cambiarHora($conexion, $itemId, $nuevaFecha);
    }

    if(isset($_POST["subirimg"])) {
        if(is_uploaded_file($_FILES["imagen"]["tmp_name"])) {
            $nombreImg = $_FILES["imagen"]["name"];
            $i = 1;
            while(existeImagen($conexion, $nombreImg)) {
                $nombreImg = $_FILES["imagen"]["name"]."_".$i;
                $i++;
            }
            aniadirImagen($conexion, $itemId, $nombreImg);
            move_uploaded_file($_FILES["imagen"]["tmp_name"], $rutaImgs."/". $nombreImg);
        }
    }

    if(isset($_GET["imagenId"])) {
        if(existeImagenPorId($conexion, $_GET["imagenId"])) {
            borrarImagen($conexion, $_GET["imagenId"]);
            unlink($rutaImgs."/".$_GET["nombreImg"]);
        }  
    }

    $imagenes = imagenesDeItem($conexion, $itemId);

    if($item->id_user != $_SESSION["logedUserId"]) {
        echo "<p>No eres el creador del item</p>";
    }
    else {
        echo "<h2>$item->nombre</h2>";
        if($msg != "") {
            echo "<p>$msg</p>";
        }
        echo "<table>";
            echo "<tr>";
                echo "<form method=\"post\" action\"$self\">";
                    echo "<td><strong>Precio de salida: </strong>$item->preciopartida €</td>";
                    if($item->cantPujas == 0) {
                        echo "<td>
                            <input type=\"number\" name=\"cantidad\">€
                            <input type=\"submit\" name=\"bajar\" value=\"BAJAR\">
                            <input type=\"submit\" name=\"subir\" value=\"SUBIR\">
                            </td>";
                    }
                echo "</form>";
            echo "</tr>";
            echo "<tr>";
                echo "<form method=\"post\" action\"$self\">";
                    echo "<td><strong>Fecha fin para pujar: </strong>$item->fechafin</td>";
                    if($item->cantPujas == 0) {
                        echo "<td>
                            <input type=\"submit\" name=\"unahora\" value=\"POSPONER 1 HORA\">
                            <input type=\"submit\" name=\"undia\" value=\"POSPONER 1 DIA\">
                            </td>";
                    }
                echo "</form>";
            echo "</tr>";
        echo "</table>";

        echo "<h1>Imagenes actuales</h1>";
        if(count($imagenes) == 0) {
            echo "<p>No hay imágenes del item</p>";
        }
        else {
            echo "<table>";
            foreach($imagenes as $imagen) {
                echo "<tr>";
                    echo "<td><img width=\"50\" src=\"$rutaImgs/$imagen->imagen\"></td>";
                    echo "<td><a href=\"$self?imagenId=$imagen->id&nombreImg=$imagen->imagen\">[BORRAR]</a></td>";
                echo "</tr>";
            }
            echo "</table>";
        }
        echo "<form method=\"post\" action\"$self\" enctype=\"multipart/form-data\">";
            echo "<table>";
                echo "<tr>";
                    echo "<td>Imagen a subir</td>";
                    echo "<td><input type=\"file\" name=\"imagen\"></td>";
                echo "</tr>";
                echo "<tr>";
                    echo "<td colspan=\"2\"><input style=\"width:100%\" type=\"submit\" name=\"subirimg\" value=\"Subir\"></td>";
                echo "</tr>";
            echo "</table>";
        echo "</form>";
    }

    require_once __DIR__."/foot.php";
?>