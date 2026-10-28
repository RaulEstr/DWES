<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        table, tr, th, td {
            margin: 5px;
            padding: 5px;
        }

        .asistentes, .asistentes tr {
            border: 1px solid black;
            border-collapse: collapse;
        }
    </style>

    <?php 
        session_start();

        function total_comensales() {
            $total = 0;
            foreach($_SESSION["apuntados"] as $apuntado) {
                $total += $apuntado->asistentes;
            }
            return $total;
        }

        if(!isset($_SESSION["apuntados"])) 
            $_SESSION["apuntados"] = [];
        

        if(isset($_POST["submit"])) {
            $invitado = (object)[
                "nombre" => $_POST["nombre"], 
                "asistentes" => $_POST["asistentes"], 
                "lleva" => $_POST["lleva"]];
            $_SESSION["apuntados"][] = $invitado;
        }
    
    ?>
</head>
<body>
    <form action="<?php $_SERVER["PHP_SELF"] ?>" method="post">
        <table>
            <tr>
                <td><label>Nombre: </label></td>
                <td><input required type="text" name="nombre"></td>
            </tr>
            <tr>
                <td><label>Asistentes: </label></td>
                <td><input required type="number" name="asistentes" value="1"></td>
            </tr>
            <tr>
                <td><label>Lleva: </label></td>
                <td><input required type="text" name="lleva"></td>
            </tr>
            <tr>
                <td colspan="2"><input type="submit" name="submit" value="APUNTAR"></td>
            </tr>
        </table>
    </form>

    <?php 
        if(count($_SESSION["apuntados"]) != 0) {
            echo "<table class=\"asistentes\">";
            echo "<tr><th>NOMBRE</th><th>ASISTENTES</th><th>LLEVA</th></tr>";
            foreach($_SESSION["apuntados"] as $apuntado) {
                echo "<tr>";
                    echo "<td>$apuntado->nombre</td>";
                    echo "<td>$apuntado->asistentes</td>";
                    echo "<td>$apuntado->lleva</td>";
                echo "</tr>";
            }   
            echo "</table>";

            $totalComensales = total_comensales();
            echo "<p>Total comensales: $totalComensales</p>";
            if($totalComensales > 20) {
                echo "<a href=\"2organizar.php\">ORGANIZAR CENA</a>";
            }
        }
    
    ?>
</body>
</html>