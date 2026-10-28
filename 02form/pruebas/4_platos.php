<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <?php 
    
    // Array asociativo de platos con precios $platos = ["goxua" => 7, "Ensalada" => 20]
    // Formulario de dos inputs numericos Precio min, Precio max y botón para buscar plato
    // Se envia a si mismo y te muestra una tabla con los platos en el rango de ese precio, también mantiene los precios introducidos
    // Cada linea de la tabla tiene un enlace que te abre una página nueva
    // Esta nueva pagina tiene un array asociativo de los platos con sus ingredienes y te muestra los ingredientes en modo lista desordenada

    $platos = [
        "Goxua" => 5, 
        "Tarta de queso" => 7, 
        "Tiramisu" => 6, 
        "Ensalada" => 13, 
        "Almejas" => 20, 
        "Cabiar" => 50, 
        "Croquetas" => 12, 
        "Langostinos" => 25, 
        "Chuleta" => 23
    ];
    
    $min = 0;
    $max = 0;
    $platosEnRango = [];
    if(isset($_POST["buscar"])) {
        $min = $_POST["precioMin"];
        $max = $_POST["precioMax"];

        foreach($platos as $plato => $precio) {
            if($precio >= $min && $precio <= $max) {
                $platosEnRango[$plato] = $precio;
            }
        }
    }

    ?>

    <style>
        .platos {
            border: 1px solid black;
            border-collapse: collapse;
        }
        td {
            padding: 5px;
            margin: 5px;
        }
    </style>
</head>
<body>
    <form method="POST" action="<?php echo $_SERVER["PHP_SELF"] ?>">

    <table>
        <tr>
            <td><label>Precio Min</label></td>
            <td><input type="number" name="precioMin" value="<?php echo $min ?>"></td>
        </tr>
        <tr>
            <td><label>Precio Max</label></td>
            <td><input type="number" name="precioMax" value="<?php echo $max ?>"></td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit" value="BUSCAR PLATOS" name="buscar"></td>
        </tr>
    </table>
    </form>

    <?php 
    
    if(count($platosEnRango) != 0) {
        echo "<table class=\"platos\">";
        foreach($platosEnRango as $plato => $precio) {
            echo "<tr class=\"platos\">";
                echo "<td>$plato</td>";
                echo "<td>".$precio."€</td>";
                echo "<td><a href=\"4_ingredientes.php?plato=$plato\" target=\"_blank\">Ver ingredientes</a></td>";
            echo "</tr>";
        }
        echo "</table>";
    } 
    
    ?>
   
</body>
</html>