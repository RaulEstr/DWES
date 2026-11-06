<?php
    require_once __DIR__."/header.php";
    $self = htmlentities($_SERVER["PHP_SELF"]);
  
    if(!isset($_SESSION["logedUser"]) || $_SESSION["logedUser"] != "admin") {
        header("Location: index.php");
        exit();
    }

    if(isset($_POST["submit"])) {
        if(isset($_POST["items"])) {
            $imgs = [];
            foreach($_POST["items"] as $itemId) {
                $imgs[$itemId] = imagenesDeItem($conexion, $itemId);
            }
            if(borrarItems($conexion, $_POST["items"])) {
                foreach($_POST["items"] as $itemId) {
                    foreach($imgs as $id=>$imagenes) {
                        foreach($imagenes as $imagen) {
                            unlink($rutaImgs."/".$imagen->imagen);
                        } 
                    }
                }
            }
        }
        else {
            echo "<p>Tienes que seleccionar items para borrarlos</p>";
        }
    }

    $items = itemsVencidos($conexion);
    if(count($items) == 0) {
        echo "<p>No hay items vencidos todavia</p>";
    }
    else {
        echo "<h1>Subastas vencidas</h1>";
        echo "<form method=\"post\" action=\"$self\">";
            echo "<table>";
            echo "<tr><th></th><th>ITEM</th><th>PRECIO FINAL</th><th>GANADOR</th></tr>";
            foreach($items as $item) {
                echo "<tr>";
                    echo "<td><input type=\"checkbox\" name=\"items[]\" value=\"$item->id\"></td>";
                    if(isset($_GET["itemId"]) && $_GET["itemId"] == $item->id) {
                        echo "<td><table>";
                            echo "<tr><td><a href=\"$self?itemId=$item->id\">$item->nombre</a></td></tr>";
                            echo "<tr><td>$item->descripcion</td></tr>";
                        echo "</table></td>";
                    }
                    else {
                        echo "<td><a href=\"$self?itemId=$item->id\">$item->nombre</a></td>";
                    }
                    if($item->maxPuja == null) {
                        echo "<td>Sin pujas</td>";
                        echo "<td>Sin ganador</td>";
                    }
                    else {
                        echo "<td>PRECIO FINAL: $item->maxPuja €</td>";
                        echo "<td>GANADOR: $item->ganador</td>";
                    }
                echo "</tr>";
            }
            echo "<tr><td colspan=\"4\"><input style=\"width:100%\" type=\"submit\" name=\"submit\" value=\"BORRAR\"></td></tr>";
            echo "</table>";
        echo "</form>";
    }

    require_once __DIR__."/foot.php";
?>