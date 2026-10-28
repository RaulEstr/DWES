<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        table, tr, td {
            margin: 20px;
            padding: 5px;
            border-collapse: collapse;
        }
        .sitio {
            border: 1px solid black;
            vertical-align: top;
        }
        input[type="submit"] {
            cursor: pointer;
        }
    </style>

    <?php 
        session_start();

        const DESTINOS = ["Londres" => 3, "Viena" => 5, "Praga" => 4, "Madrid" => 2];
        $self = $_SERVER["PHP_SELF"];

        // if(!isset($_SESSION["apuntados"])) {
        //     foreach(array_keys(DESTINOS) as $destino) {
        //         $_SESSION["apuntados"][$destino] = [];
        //     }     
        // }

        $error = "";
        foreach(array_keys(DESTINOS) as $destino) {
            if(!isset($_SESSION["apuntados"][$destino])) {
                $_SESSION["apuntados"][$destino] = [];
            }

            if(isset($_POST["submit$destino"])) {
                $dni = trim(strtoupper($_POST["dni"]));
                $nombre = trim($_POST["nombre"]);

                if($dni == "" || $nombre == "") {
                    $error = "No puede haber campos vacios";
                }
                else {
                    foreach(array_keys(DESTINOS) as $destino2) {
                        if(array_key_exists($dni, $_SESSION["apuntados"][$destino2])) {
                            unset($_SESSION["apuntados"][$destino2][$dni]);
                        }
                    }
                    $_SESSION["apuntados"][$destino][$dni] = $nombre;
                }
            }

            if(isset($_GET["reset$destino"])) {
                $_SESSION["apuntados"][$destino] = [];
            }
        }
    ?>
</head>
<body>
    <?php
        echo "<form action=\"$self\" method=\"post\">";
            echo "<table>";
                echo "<tr>";
                    echo "<td><label>DNI: </label></td>";
                    echo "<td><input type=\"text\" required pattern=\"[0-9]{8}[A-Za-z]{1}\" title=\"8 numeros + letra\" name=\"dni\"></td>";
                    echo "<td><label>Nombre: </label></td>";
                    echo "<td><input type=\"text\" required name=\"nombre\"></td>";
                echo "</tr>";
            echo "</table>";
        
            if($error != "") {
                echo "<p>$error</p>";
            }

            echo "<table>";
                echo "<tr>";
                    foreach(DESTINOS as $destino => $capacidad) {
                        echo "<td class=\"sitio\">";
                            echo "<table>";
                                echo "<tr>";
                                if(count($_SESSION["apuntados"][$destino]) < $capacidad) {
                                    echo "<td><input type=\"submit\" value=\"$destino\" name=\"submit$destino\"></td>";
                                    echo "<td><p>MAX $capacidad personas</p></td>";
                                }
                                else {
                                    echo "<td><p style=\"color: red\"><strong>¡COMPLETO!</strong></p></td>";
                                    echo "<td><a href=\"$self"."?reset$destino"."\">Reiniciar viaje $destino</a></td>";
                                }
                                    
                                echo "</tr>";
                                if(count($_SESSION["apuntados"][$destino]) > 0) {
                                    echo "<tr><th colspan=\"2\">APUNTADOS</th></tr>";
                                    foreach($_SESSION["apuntados"][$destino] as $dni => $nombre) {
                                        echo "<tr>";
                                            echo "<td>$dni</td>";
                                            echo "<td>$nombre</td>";
                                        echo "</tr>";
                                    }
                                }  
                            echo "</table>";
                        echo "</td>";
                    }
                echo "</tr>";
            echo "</table>";
        echo "</form>";
    ?>

</body>
</html>