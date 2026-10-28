<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php 
    
    // Raúl Estrada García
    // Dado 1 array asociativo
        // Claves: Destinos
        // Valor: Array de horas String
    // Script index.php
    // Visualiza Tabla
        // Columna de la izquierda: Destinos
        // Columna derecha: último bus
    

    $horaraioBuses = [
        "Madrid" => ["15:00","16:00", "18:00", "12:00", "13:00", "14:00"],
        "Bilbao" => ["5:10", "20:45"], 
        "Zaragoza" => ["23:15", "23:45", "12:30"],
        "Burgos" => ["1:00","2:00", "1:45"],
        "Barcelona" => ["8:00", "4:00", "3:00"],
        "Valladolid" => ["00:00"]
    ];

    $horaMasTarde = [];
    foreach($horaraioBuses as $ciudad => $horas) {
        $tarde = new DateTime("00:00");

        foreach($horas as $hora) {
            $tarde2 = explode(":", $hora);
            $tarde2 = new DateTime($tarde2[0].":".$tarde2[1]);

            if($tarde2 >= $tarde) {
                $horaMasTarde[$ciudad] = $tarde2;
                $tarde = $tarde2;
            }
        }
    }

    echo "<table>";

    foreach($horaMasTarde as $ciudad => $hora) {

        echo "<tr>";
            echo "<td>$ciudad</td>";
            echo "<td>".$hora->format("H:i")."</td>";
        echo "</tr>";

    }

    echo "</table>";

    ?>
</body>
<style>
    table, tr,td {
        border: 1px solid black;
        border-collapse: collapse;
        padding: 5px;
    }
</style>
</html>