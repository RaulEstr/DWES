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
    echo "</table>";


    require_once __DIR__."/foot.php";
?>