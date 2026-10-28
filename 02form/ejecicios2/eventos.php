<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        table,td,tr {
            border: 1px solid black;
            border-collapse: collapse;
            margin: 5px;
            padding: 5px;
        }
    </style>

    <?php 
    
    // Para tener mejor orden el archivo eventos.txt va a estar dentro de una carpeta llamada "archivos"

    $archivo = "archivos/eventos.txt";
    $resultado = "";
    $evento = "";
    $precioEvento = 0;
    $precio = 0;
    $total = 0;

    if(isset($_GET["precio"])) {
        $precio = $_GET["precio"];
    }
    if(isset($_GET["total"])) {
        $total = $_GET["total"];
    }

    if(isset($_POST["registrar"])) {
        $evento = $_POST["evento"];
        $precioEvento = $_POST["precio"];
        if(trim($evento) != "" && trim($precioEvento) != "") {
            $f = fopen($archivo, "a");
            if($f) {
                $linea = "\n".$evento."|".number_format($precioEvento,2);
                fputs($f, $linea);
                fclose($f);
            }
        }
        else {
            $resultado = "No puede haber campos vacios al añadir eventos";
        }
    }

    ?>

</head>
<body>
    <table>
        <caption>ELIGE TU ENTRADA</caption>
        <?php
        $f = fopen($archivo, "r");
        if($f) {
            while(!feof($f)) {
                $linea = fgets($f);
                $partes = explode("|", $linea);
                echo "<tr>";
                    echo "<td>".trim($partes[0])."</td>";
                    echo "<td>".trim($partes[1])." €</td>";
                    $href = $_SERVER["PHP_SELF"]."?precio=$partes[1]&total=".($total + $partes[1]);
                    echo "<td><a href=\"$href\">Reservar entrada</a></td>";
                echo "</tr>";
            }
            fclose($f);
        }

        echo "<tr><td colspan=3>TOTAL RESERVA: ".number_format($total,2)." €</td></tr>";
        ?>
    </table>
    <br>
    <form method="POST">
        <table>
            <caption>AÑADIR NUEVO EVENTO</caption>
            <tr>
                <td>
                    <label>Nombre: </label>
                    <input type="text" name="evento" value="<?php echo $evento ?>">
                    <label>Precio (€): </label>
                    <input type="number" name="precio" step="0.01" value="<?php echo $precioEvento ?>">
                    <input type="submit" name="registrar" value="Registrar">
                </td>
            </tr>
            <?php 
        
            if($resultado != "") {
                echo "<tr><td><p>$resultado</p></td></tr>";
            }

            ?>
        </table>
    </form>
</body>
</html>