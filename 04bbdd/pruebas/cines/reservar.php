<?php
    require_once "modelo.php";
    $self = htmlentities($_SERVER["PHP_SELF"]);
    $conexion = conexion("bdcines", "root", "");
    if(!$conexion) {
        echo "Error de conexion a base de datos";
        exit();
    }
    session_start();

    if(!isset($_SESSION["funciones"])) {
        header("Location: index.php");
        exit();
    }

    if(isset($_GET["volver"])) {
        session_destroy();
        header("Location: index.php");
        exit();
    }

    $datosReserva = [];
    foreach($_SESSION["funciones"] as $idfuncion=>$cantidad) {
        $datosReserva[] = datosReserva($conexion, $idfuncion);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        table {
            display: inline-block;
        }
        tr, td, th {
            margin: 10px;
            padding: 5px;
        }
    </style>
</head>
<body>
    <?php
        echo "<h1>Su reserva</h1>";
        echo "<hr>";
        echo "<table>";
            foreach($datosReserva as $reserva) {
                echo "<tr>";
                    echo "<td>Funcion ".$reserva[0]["idfuncion"]."</td>";
                    echo "<td>(".$reserva[0]["nombre"].", sala ".$reserva[0]["num_sala"].", ".$reserva[0]["titulo"].")</td>";
                    if($reserva[0]["restantes"] >= $_SESSION["funciones"][$reserva[0]["idfuncion"]]) {
                        //aniadirVendidas($conexion, $_SESSION["funciones"][$reserva[0]["idfuncion"]] + $reserva[0]["vendidos"], $reserva[0]["idfuncion"]);
                        echo "<td>ENTRADAS RESERVADAS: <b>".$_SESSION["funciones"][$reserva[0]["idfuncion"]]."</b></td>";
                        echo "<td>".$_SESSION["funciones"][$reserva[0]["idfuncion"]]." entradas x ".$reserva[0]["precio_entrada"]." € = ".($_SESSION["funciones"][$reserva[0]["idfuncion"]] * $reserva[0]["precio_entrada"])."€</td>";
                    }
                    else {
                        echo "<td colspan=\"2\">IMPOSIBLE RESERVAR ".$_SESSION["funciones"][$reserva[0]["idfuncion"]]." ENTRADAS</td>";
                    }
                    
                echo "</tr>";
            }
        echo "</table>";
        echo "<p><a href=\"$self?volver\">VOLVER</a></p>";
    
    ?>
</body>
</html>