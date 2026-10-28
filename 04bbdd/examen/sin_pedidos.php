<?php
    require_once "modelo.php";
    $self = htmlentities($_SERVER["PHP_SELF"]);
    $conexion = conexion("restaurante", "root", "");
    if(!$conexion) {
        echo "Error de conexion a restaurante";
        exit();
    }

    $platosSinPedidos = platosSinPedidos($conexion);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php 
        echo "<h2>Selecciona un plato sin pedidos</h2>";
        if(count($platosSinPedidos) > 0) {
            echo "<form method=\"post\" action=\"modificar_plato.php\">";
                echo "<ul>";
                foreach($platosSinPedidos as $plato) {
                    echo "<li><input type=\"radio\" name=\"plato\" value=\"".$plato->idplato."\"> ".$plato->nombre." - ".number_format($plato->precio,2)."€</li>";
                }
                echo "</ul>";
                echo "<input type=\"submit\" name=\"submit\" value=\"MODIFICAR PLATO\">";
            echo "</form>";
        }

    ?>
</body>
</html>