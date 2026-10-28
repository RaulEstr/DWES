<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php 
    
    function leeStock($fich) {
        $arr = [];
        $f = fopen($fich, "r");

        if($f) {
            while (!feof($f)){
                $linea = trim(fgets($f));
                $partes = explode(";", $linea);
                $arr[$partes[0]] = $partes[1];
            }
            fclose($f);
        }

        return $arr;
    }

    function guardarStock($fich, $arr) {

        $f = fopen($fich, "w");
        foreach($arr as $clave => $uds) {

            if($clave == array_key_last($arr)) {
                $linea = $clave.";".$uds;
                fputs($f, $linea);
            }
            else {
                $linea = $clave.";".$uds."\n";
                fputs($f, $linea);
            }
            
        }

        fclose($f);

    }

    if(isset($_POST["restar"])) {
        $prod = $_POST["prod"];

        $arr = leeStock("registros/stock.txt");
        if(key_exists($prod,$arr)){
            $nueva_cant = $arr[$prod] - 1;
            if ($nueva_cant <= 0) {
                unset($arr[$prod]);
            }
            else {
                $arr[$prod] = $nueva_cant;
            }
        }

        guardarStock("registros/stock.txt", $arr);
    }

    ?>
    <style>
        table, tr, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
    </style>
</head>
<body>

    <table>
        <tr>
            <th>Producto</th>
            <th>Unidades</th>
            <th></th>
        </tr>

        <?php 
        $valores = leeStock("registros/stock.txt");
        foreach($valores as $producto => $unidades) {
            echo "<form method=\"POST\">";
                echo "<tr>";
                    echo "<td>$producto</td>";
                    echo "<td>$unidades</td>";
                    echo "<input type=\"hidden\" name=\"prod\" value=\"$producto\">";
                    echo "<td><input type=\"submit\" name=\"restar\" value=\"RESTAR UNIDAD\"></td>";
                echo "</tr>";
            echo "</form>";
        }
        ?>

    </table>
</body>
</html>