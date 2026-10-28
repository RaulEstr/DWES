<?php
    require_once "modelo.php";
    $self = htmlentities($_SERVER["PHP_SELF"]);
    $conexion = conexion("bdcines", "root", "");
    if(!$conexion) {
        echo "Error de conexion a base de datos";
        exit();
    }

    session_start();
  
    if(isset($_GET["reservar"])) {
        header("Location: reservar.php");
        exit();
    }

    $msg = "";
    if(isset($_POST["submit"])) {
        if(isset($_POST["pelicula"])) {
            if(isset($_SESSION["idpelicula"])) {
                if($_POST["pelicula"] != $_SESSION["idpelicula"]) {
                    unset($_SESSION["funciones"]);
                }
            }
            $_SESSION["idpelicula"] = $_POST["pelicula"];
        }
        else {
            $msg = "Debes seleccionar una película";
        }
    }

    if(isset($_GET["idFuncion"])) {
        $idFuncion = $_GET["idFuncion"];
        if(!isset($_SESSION["funciones"][$idFuncion])) {
            $_SESSION["funciones"][$idFuncion] = 1;
        }
        else {
            $_SESSION["funciones"][$idFuncion]++;
        }
    }

    $idpelicula = "";
    $funciones = [];
    if(isset($_SESSION["idpelicula"])) {
        $idpelicula = $_SESSION["idpelicula"];
        $funciones = funcionesPorPelicula($conexion, $idpelicula);
    }

    $categorias = categorias($conexion);
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
        i {
            font-size: 0.8em;
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
        echo "<form action=\"$self\" method=\"post\">";
            echo "<table>";
                foreach($categorias as $categoria) {
                    $peliculasDeCategoria = peliculasPorCategoria($conexion, $categoria->categoria);
                    if(count($peliculasDeCategoria) > 0) {
                        echo "<tr>";
                            echo "<th>".$categoria->categoria."</th>";
                            echo "<td>";
                            foreach($peliculasDeCategoria as $pelicula) {
                                if($pelicula->idpelicula == $idpelicula) {
                                    echo "<input type=\"radio\" name=\"pelicula\" value=\"".$pelicula->idpelicula."\" checked=\"checked\">".ucwords($pelicula->titulo);
                                }
                                else {
                                    echo "<input type=\"radio\" name=\"pelicula\" value=\"".$pelicula->idpelicula."\">".ucwords($pelicula->titulo);
                                }
                                
                            }
                            echo "</td>";
                        echo "</tr>";
                    }   
                }
            echo "</table>";
            echo "<input type=\"submit\" name=\"submit\" value=\"VER FUNCIONES\">";
            if($msg != "") {
                echo "<p>$msg</p>";
            }
        echo "</form>";

        if($idpelicula != "") {
            $tituloPelicula = ucwords(tituloPelicula($conexion, $idpelicula)[0]->titulo);
            echo "<h2>FUNCIONES DE $tituloPelicula</h2>";
            echo "<table>";
                if(isset($_SESSION["funciones"])) {
                    echo "<tr><th>CINE</th><th>SALA</th><th>FECHA DE PROYECCIÓN</th><th>VENDIDAS</th><th>PEDIR</th><th>PEDIDAS</th></tr>";
                }
                else {
                    echo "<tr><th>CINE</th><th>SALA</th><th>FECHA DE PROYECCIÓN</th><th>VENDIDAS</th><th>PEDIR</th></tr>";
                }
                
                foreach($funciones as $funcion) {
                    echo "<tr>";
                        $img = imagenCine($conexion, $funcion->idcine)[0]->imagen;
                        echo "<td><img height=\"50\" width=\"50\" src='data:image/jpeg;base64,".base64_encode($img)."'></td>";
                        echo "<td>".$funcion->num_sala."</td>";
                        echo "<td>".date("d-M-Y H:i", strtotime($funcion->fecha_hora))."</td>";
                        $total = capacidadDeSala($conexion, $funcion->idcine, $funcion->num_sala)[0]->capacidad;
                        
                        if($total == $funcion->vendidos) {
                            echo "<td>TODAS</td>";
                        }
                        else{
                            echo "<td>".$funcion->vendidos."</td>";
                            echo "<td><a href=\"$self?idFuncion=".$funcion->idfuncion."\">PEDIR 1 ENTRADA</a></td>";
                        }

                        if(isset($_SESSION["funciones"][$funcion->idfuncion])) {
                            echo "<td>".$_SESSION["funciones"][$funcion->idfuncion]." entradas pedidas</td>";
                        }
                        
                    echo "</tr>";
                }
            echo "</table>";
            if(isset($_SESSION["funciones"])) {
                echo "<p><a href=\"$self?reservar\">GRABAR RESERVA</a></p>";
            }
        }
    ?>
</body>
</html>