<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php require_once("03funciones.php") ?>
     
</head>
<body>
    <?php 
        // 1. Crear array asociativo de módilos y por cada módulo un array por horas por dia
        // 2. Funcion arrTales que devuelve otro array asociativo que devuelve lo mismo y como valor el total de horas
        // 3. Funcion limpiar que elimina el array así: ordena cada subarray y elimina las posiciones con numeros negativos

        // 1.
        $modulos["PROG"] = [4, -3];
        $modulos["ENDE"] = [-1, 1, 6, 4];
        $modulos["DEWS"] = [3, 1, 0, 0, 4];
        var_dump($modulos);

        // 2
        $modulosTotal = arrTotales($modulos);
        echo "<ul>";
            foreach($modulosTotal as $modulo => $total) {
                echo "<li>$modulo: $total</li>";
            }
        echo "</ul>";

        // 3
        $modulosLimpio = limpiar($modulos);
        var_dump($modulosLimpio);

        $modulosTotalLimpio = arrTotales($modulosLimpio);
        echo "<ul>";
            foreach($modulosTotalLimpio as $modulo => $total) {
                echo "<li>$modulo: $total</li>";
            }
        echo "</ul>";

        
    ?>
</body>
</html>