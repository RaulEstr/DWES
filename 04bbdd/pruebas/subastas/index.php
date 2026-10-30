<?php
    require_once __DIR__."/header.php";

    $items = [];
    if(isset($_GET["id"])) {
        $items = itemsPorCategoria($conexion, $_GET["id"]);
    }
    else {
        $items = todosLosItems($conexion);
    }

    echo "<table>";
        echo "<tr><th>IMAGEN</th><th>ITEM</th><th>PUJAS</th><th>PRECIO</th><th>PUJAS HASTA</th></tr>";
        foreach($items as $item) {
            echo "<tr>";
                if($item->imagen == null) {
                    echo "<td>NO IMAGEN</td>";
                }
                else {
                    echo "<td>$item->imagen</td>";
                }
                echo "<td><a href=\"itemdetalles.php?$item->id\">$item->nombre</a></td>";
                echo "<td>$item->cantidadPujas</td>";
                if($item->maxPuja == null) {
                    echo "<td>$item->preciopartida</td>";
                }
                else {
                    echo "<td>$item->maxPuja</td>";
                }
                echo "<td>$item->fechafin</td>";
            echo "</tr>";
        }
    echo "</table>";

    require_once __DIR__."/foot.php";
?>