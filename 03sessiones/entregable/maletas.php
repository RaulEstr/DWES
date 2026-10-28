<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        table, tr, th, td {
            margin: 10px;
            padding: 10px;
        }
    </style>
    <?php 

        session_start();

        $self = $_SERVER["PHP_SELF"];

        $maximo = $_SESSION["pesoTotal"];

        if(!isset($_SESSION["maletas"])) {
            $_SESSION["maletas"] = [];
        }

        $error = "";     
        if(isset($_POST["submit"])) {
            $total = 0;
            foreach($_SESSION["maletas"] as $dni => $pesos) {    
                $total += array_sum($pesos);
            }

            $dni = strtoupper(trim($_POST["dni"]));
            $peso = $_POST["peso"];

            if($dni == "" || $peso < 0) {
                $error = "El DNI no puede estar vacio y el peso tiene que ser mayor a 0";
            }
            else {
                if($total + $peso > $maximo) {
                    $error = "El peso máximo no puede superar $maximo kgs";
                }
                else {
                    $_SESSION["maletas"][$dni][] = $peso;                                       
                }
            }
        }

        if(isset($_GET["dni"])) {
            $dni = $_GET["dni"];
            unset($_SESSION["maletas"][$dni]);
        }
    ?>
    
</head>
<body>
    <?php
        echo "<h1>GESTION DE EQUIPAJE</h1>";
        echo "<p>Capacidad máxima del maletero: $maximo kg</p>";
        echo "<form action=\"$self\" method=\"post\">";
            echo "<table>";
                echo "<tr>";
                    echo "<td><label>DNI Pasajero: </label></td>";
                    echo "<td><input type=\"text\" name=\"dni\"></td>";
                echo "</tr>";
                echo "<tr>";
                    echo "<td><label>Paso maleta (kg): </label></td>";
                    echo "<td><input type=\"number\" name=\"peso\"></td>";
                echo "</tr>";
                echo "<tr><td colspan=\"2\"><input type=\"submit\" name=\"submit\" value=\"AÑADIR MALETA\"></td></tr>";
            echo "</table>";

            if($error != "") {
                echo "<p>$error</p>";
            }

        echo "</form>";
    
        echo "<table>";
            echo "<tr>";
                echo "<th>DNI Pasajero</th><th>Nº Maletas</th><th>Peso Total Pasajero</th><th>Acciones</th>";
                if(count($_SESSION["maletas"]) == 0) {
                    echo "<tr>";
                        echo "<td colspan=\"4\">El maletero está vacio</td>";
                    echo "</tr>";
                }
                else {
                    foreach($_SESSION["maletas"] as $dni => $pesos) {
                        echo "<tr>";
                            echo "<td>$dni</td>";
                            echo "<td>".count($pesos)."</td>";
                            echo "<td>".array_sum($pesos)."</td>";
                            echo "<td><a href=\"$self?dni=$dni\">Quitar maletas</a></td>";
                        echo "</tr>";
                    }
                }
            echo "</tr>";
            echo "<tr>";
                echo "<th colspan=\"2\">PESO TOTAL ACUMULADO MALETERO:</th>";
                $total = 0;
                foreach($_SESSION["maletas"] as $dni => $pesos) {
                    $total += array_sum($pesos);
                }
                echo "<th colspan=\"2\">$total kg / $maximo kg (".number_format(100 * $total / $maximo, 0)."%)</th>";
            echo "</tr>";
        echo "</table>";
    ?>
    
</body>
</html>