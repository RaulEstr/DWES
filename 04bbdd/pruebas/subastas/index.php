<?php
    require_once __DIR__."/header.php";
    $self = htmlentities($_SERVER["PHP_SELF"]);

    $_SESSION["lastPage"] = $self;
    
    unset($_SESSION["itemID"]);

    if(isset($_GET["editar"])) {
        $_SESSION["itemID"] = $_GET["editar"];
        header("Location: editaritem.php");
        exit();
    }

    if(isset($_GET["detalles"])) {
        $_SESSION["itemID"] = $_GET["detalles"];
        header("Location: itemdetalles.php");
        exit();
    }

    $items = [];
    if(isset($_GET["id"])) {
        $items = itemsPorCategoria($conexion, $_GET["id"]);
    }
    else {
        $items = todosLosItems($conexion);
    }

    
    if(count($items) == 0) {
        echo "<p>No hay items</p>";
    }
    else {
        echo "<table>";
            echo "<tr><th>IMAGEN</th><th>ITEM</th><th>PUJAS</th><th>PRECIO</th><th>PUJAS HASTA</th></tr>";
            foreach($items as $item) {
                echo "<tr>";
                    if($item->imagen == null) {
                        echo "<td>NO IMAGEN</td>";
                    }
                    else {
                        echo "<td><img width=\"50\" src=\"$rutaImgs/$item->imagen\"></td>";
                    }
                    echo "<td><a href=\"$self?detalles=$item->id\">$item->nombre</a>";
                        if(isset($_SESSION["logedUserId"])) {
                            if($_SESSION["logedUserId"] == $item->id_user) {
                                echo " - <a href=\"$self?editar=$item->id\">[editar]</a>";
                            }
                        }
                    echo "</td>";
                    echo "<td>$item->cantidadPujas</td>";
                    if($item->maxPuja == null) {
                        echo "<td>$item->preciopartida €</td>";
                    }
                    else {
                        echo "<td>$item->maxPuja €</td>";
                    }
                    echo "<td>$item->fechafin</td>";
                echo "</tr>";
            }
        echo "</table>";
    }
        

    require_once __DIR__."/foot.php";
?>