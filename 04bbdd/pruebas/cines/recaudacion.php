<?php

    require_once "modelo.php";
    $self = htmlentities($_SERVER["PHP_SELF"]);
    $conexion = conexion("bdcines", "root", "");
    if(!$conexion) {
        echo "Error de conexion a base de datos";
        exit();
    }

    const RECAUDACION = 1500;

    $idpelicula = "";
    $funciones = [];
    if(isset($_GET["id"])) {
        $idpelicula = $_GET["id"];
        $funciones = funcionesPorPelicula($conexion, $idpelicula);
    }
    $peliculas = peliculasRecaudacion($conexion, RECAUDACION);
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
        a {
            color: #014bd4;
            text-decoration: none;
        }
        input[type="submit"], button {
            display: block;
            padding: 10px;
        }
    </style>
</head>
<body>
    <?php 
        echo "<h1>PELICULAS RECAUDACION</h1>";
        if(sizeof($peliculas) > 0) {
            echo "<table>";
                foreach($peliculas as $pelicula) {
                    echo "<tr>";
                        echo "<td><a href=\"$self?id=".$pelicula->idpelicula."\">".tituloPelicula($conexion, $pelicula->idpelicula)[0]->titulo."</a></td>";
                        echo "<td>".$pelicula->total."€</td>";
                        echo "<td><input type=\"submit\" value=\"ELIMINAR\" name=\"".$pelicula->idpelicula."\"></td>";
                    echo "</tr>";
                    if($pelicula->idpelicula == $idpelicula) {
                        echo "<tr>";
                            echo "<td>";
                                echo "<table>";
                                    echo "<tr><th>CINE</th><th>SALA</th><th>HORA</th><th>RECAUDADO</th><th>OCUPACIÓN</th></tr>";
                                    foreach($funciones as $funcion) {
                                        echo "<tr>";
                                            $img = imagenCine($conexion, $funcion->idcine)[0]->imagen;
                                            echo "<td><img height=\"50\" width=\"50\" src='data:image/jpeg;base64,".base64_encode($img)."'></td>";
                                            echo "<td>".$funcion->num_sala."</td>";
                                            echo "<td>".date("d-M-Y H:i", strtotime($funcion->fecha_hora))."</td>";
                                            echo "<td>".$funcion->recaudacion."€</td>";
                                            $capacidad = capacidadDeSala($conexion, $funcion->idcine, $funcion->num_sala)[0]->capacidad;
                                            $porcen = $funcion->vendidos * 100 / $capacidad;
                                            echo "<td>".number_format($porcen, 2)."%</td>";
                                        echo "</tr>";
                                    }
                                echo "</table>";
                            echo "</td>";
                        echo "</tr>";
                    }
                }
            echo "</table>";
            
        }

    ?>
</body>
</html>