<?php
    require_once __DIR__."/header.php";
    $self = htmlentities($_SERVER["PHP_SELF"]);
    $_SESSION["lastPage"] = $self;

    
    $itemID = $_SESSION["itemID"];

    $msg = "";
    if(isset($_POST["pujar"])) {
        if($_POST["puja"] == "") {
            $msg = "Tienes que introducir una puja";
        }
        else {
            if(cantidadUltimaPuja($conexion, $itemID)[0]->precioActual >= $_POST["puja"]) {
                $msg = "Puja muy baja!";
            }
            else if (cantidadPujasHoy($conexion, $itemID, $_SESSION["logedUserId"])[0]->cantidadHoy >= 3) {
                $msg = "Límite de 3 pujas por día";
            }
            else {
                aniadirPuja($conexion, $itemID, $_SESSION["logedUserId"], $_POST["puja"]);
            }
        }
        
    }

    $item = itemPorId($conexion, $itemID)[0];
    $imagenes = imagenesDeItem($conexion, $itemID);
    $pujas = pujasDeItem($conexion, $itemID);

    echo "<h2>$item->nombre</h2>";

    echo "<p>";
        echo "<strong>Número de pujas:</strong> $item->cantPujas - ";
        if($item->precioActual == null) {
            echo "<strong>Precio actual:</strong> $item->preciopartida - ";
        }
        else {
            echo "<strong>Precio actual:</strong> $item->precioActual €- ";
        }
        echo "<strong>Fecha fin para pujar:</strong> $item->fechafin";
    echo "</p>";

    foreach($imagenes as $imagen) {
        
    }

    echo "<p>$item->descripcion</p>";

    echo "<h2>Puja por este item</h2>";
    if(!isset($_SESSION["logedUserId"])) {
        echo "<p>Para pujar, debes autenticarte <a href=\"login.php\">aquí</a></p>";
    }
    else {
        echo "<form method=\"post\" action=\"$self\">";
            echo "<table>";
                echo "<tr>";
                    echo "<td><input type=\"number\" name=\"puja\">€</td>";
                    echo "<td><input type=\"submit\" name=\"pujar\" value=\"¡Puja!\"></td>";
                    if($msg != "") {
                        echo "<td style=\"color:red\">$msg</td>";
                    }
                echo "</tr>";
            echo "</table>";
        echo "</form>";
    }

    echo "<h2>Historial de la puja</h2>";
    if(count($pujas) > 0) {
        echo "<ul>";
        foreach($pujas as $puja) {
            echo "<li>$puja->nomUsuario - $puja->cantidad €</li>";
        }
        echo "</ul>";
    }
    else{
        echo "<p>Todavia no hay pujas</p>";
    }



    require_once __DIR__."/foot.php";
?>