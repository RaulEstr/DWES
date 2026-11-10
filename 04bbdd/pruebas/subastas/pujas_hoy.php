<?php
    require_once __DIR__."/header.php";
    $self = htmlentities($_SERVER["PHP_SELF"]);

    if(isset($_SESSION["logedUser"])) {
        if($_SESSION["logedUser"] != "admin") {
            header("Location: index.php");
            exit();
        }
    }

    $itemSel = 0;
    if(isset($_GET["itemId"])) {
        $itemSel = $_GET["itemId"];
    }

    $itemsPujasHoy = itemsPujasHoy($conexion);

    echo "<h1>Pujas de hoy</h1>";
    if(count($itemsPujasHoy) == 0) {
        echo "<p>Hoy no se han realizado pujas</p>";
    }
    else {
        echo "<table>";
        echo "<th>ITEM</th><th>PRECIO PARTIDA</th><th>HISTORIAL PUJAS</th>";
        foreach($itemsPujasHoy as $itemHoy) {
            $pujas = pujasDeHoy($conexion, $itemHoy->id);
            $pujasAnteriores = pujasAnteriores($conexion, $itemHoy->id);
            $imagenes = imagenesDeItem($conexion, $itemHoy->id);
            echo "<tr>";
            echo "<td>";
                if(count($imagenes) > 0) {
                    echo "<a href=\"$self?itemId=$itemHoy->id\">$itemHoy->nombre</a>";
                }
                else{
                    echo "$itemHoy->nombre";
                }
                if($itemHoy->id == $itemSel) {
                    echo "<br>";
                    foreach($imagenes as $img) {
                        echo "<img width=\"50\" height=\"50\" src=\"$rutaImgs/".$img->imagen."\">";
                    }
                }
                echo "</td>";
                
                echo "<td>".$itemHoy->preciopartida."€</td>";
                echo "<td>";
                    foreach($pujas as $puja) {
                        echo "<p><strong>".$puja->nomUsuario." - ".$puja->cantidad."€</strong></p>";
                    }

                    foreach($pujasAnteriores as $puja) {
                        echo "<p>".$puja->nomUsuario." - ".$puja->cantidad."€</p>";
                    }
                echo "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }

    require_once __DIR__."/foot.php";
?>