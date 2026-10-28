<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        table, tr, td {
            margin: 5px;
            padding: 5px;
        }
    </style>

    <?php 
        session_start();

        const CIUDAD = "PARIS";
        const MAXIMO = 2;
        $self = $_SERVER["PHP_SELF"];

        $error = "";
        if(!isset($_SESSION["viajeros"])) 
            $_SESSION["viajeros"] = [];

        if(isset($_POST["submit"])) {
            $dni = trim(strtoupper($_POST["dni"]));
            $nombre = trim($_POST["nombre"]);

            if($dni == "" || $nombre == "") {
                $error = "No puedes añadir campos vacios";
            }
            else {
                $_SESSION["viajeros"][$dni] = $nombre;
            }
        }

        if(isset($_GET["reset"])) {
            $_SESSION["viajeros"] = [];
        }
    ?>
</head>
<body>
    <?php
        echo "<p>VIAJE A <strong>".CIUDAD."</strong>. Maximo <strong>".MAXIMO."</strong> personas</p>";

        if(count($_SESSION["viajeros"]) == MAXIMO){
            echo "<table>";
                echo "<tr>";
                    echo "<td><p style=\"color: red\"><strong>COMPLETO</strong></p></td>";
                    echo "<td><a href=\"$self"."?reset"."\">Reiniciar proceso</a></td>";
                echo "</tr>";
            echo "</table>";
        }
        else {
            echo "<form action=\"$self\" method=\"post\">";
                echo "<table>";
                    echo "<tr>";
                        echo "<td><label>DNI: </label></td>";
                        echo "<td><input type=\"text\" required pattern=\"[0-9]{8}[A-Za-z]{1}\" title=\"8 numeros + letra\" name=\"dni\"></td>";
                        echo "<td><label>Nombre: </label></td>";
                        echo "<td><input type=\"text\" required name=\"nombre\"></td>";
                        echo "<td><input type=\"submit\" name=\"submit\" value=\"AÑADIR\"></td>";
                    echo "</tr>";
                echo "</table>";
            echo "</form>";
        }
    
        if($error != "") {
            echo "<p>$error</p>";
        }

        if(count($_SESSION["viajeros"]) != 0) {
            echo "<table>";
                echo "<tr>";
                    echo "<th colspan=\"2\">APUNTADOS</th>";
                echo "</tr>";

                foreach($_SESSION["viajeros"] as $dni => $nombre) {
                    echo "<tr>";
                        echo "<td>$dni</td>";
                        echo "<td>$nombre</td>";
                    echo "</tr>";
                }
            echo "</table>";
        }
    ?>

</body>
</html>