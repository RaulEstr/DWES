<?php
    require_once "modelo.php";
    $self = htmlentities($_SERVER["PHP_SELF"]);
    $conexion = conexion("restaurante", "root", "");
    if(!$conexion) {
        echo "Error de conexion a restaurante";
        exit();
    }
    
    if(isset($_POST["aniadirIng"])) {
        aniadirIngPlato($conexion, $_POST["idingrediente"], $_POST["idplato"], $_POST["cantidad"]);
    }

    if(isset($_POST["quitarIng"])) {
        quitarIngPlato($conexion, $_POST["idingrediente"], $_POST["idplato"]);
    }

    $msg = "";
    $arrPlatos = platos($conexion);
    $idplato = null;
    $ingredientesExtra = [];
    $ingredientesActuales = [];
    if(isset($_REQUEST["idplato"])) {
        $idplato = $_REQUEST["idplato"];
        $ingredientesExtra = ingredientesExtra($conexion, $idplato);
        $ingredientesActuales = composicionPlato($conexion, $idplato);
    }

    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        * {
            text-align: center;
        }
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
        input[type="submit"] {
            padding: 10px;
        }
    </style>
</head>
<body>
    <?php 
        echo "<table>";
        echo "<tr><th>ID</th><th>NOMBRE</th><th>PRECIO</th><th>FECHA</th><th>IMAGEN</th><th>COMPOSICION</th></tr>";
            foreach($arrPlatos as $plato) {
                echo "<tr>";
                    echo "<td>".$plato->idplato."</td>";
                    echo "<td>".$plato->nombre."</td>";
                    echo "<td>".number_format($plato->precio, 2)."</td>";
                    echo "<td>".$plato->fecha."</td>";
                    if($plato->imagen==null) {
                        echo "<td><i>Sin imagen</i></td>";
                    }
                    else {
                        $srcImg = "imgs/".htmlentities($plato->imagen);
                        echo "<td><img src=\"$srcImg\" height=\"30\"></td>";
                    }
                    $enlace = "$self?idplato=".$plato->idplato;
                    echo "<td><a href=\"$enlace\"?>INDICAR COMPOSICION</a></td>";

                    if($idplato == $plato->idplato) {
                        echo "<tr><td colspan=\"5\"></td>";
                            echo "<td>";
                                echo "<form method=\"post\" action=\"$self\">";
                                    echo "<table>";
                                        echo "<tr>";
                                            echo "<td><select name=\"idingrediente\">";
                                            foreach($ingredientesExtra as $ingrediente) {
                                                echo "<option value=\"".$ingrediente->id."\">".$ingrediente->nombre."</option>";
                                            }
                                            echo "</select></td>";
                                            echo "<td><input type=\"number\" name=\"cantidad\" value=\"0\"></td>";
                                            echo "<td><input type=\"submit\" name=\"aniadirIng\" value=\"AÑADIR\"></td>";
                                            echo "<input type=\"hidden\" name=\"idplato\" value=\"$idplato\">";
                                        echo "</tr>";
                                echo "</form>";
                                        foreach($ingredientesActuales as $ingrediente) {
                                            echo "<tr>";
                                                echo "<form method=\"post\" action=\"$self\">";
                                                    echo "<td>".$ingrediente->nombre."</td>";
                                                    echo "<td>".$ingrediente->cantidad."</td>";
                                                    echo "<td><input type=\"submit\" name=\"quitarIng\" value=\"QUITAR\"></td>";
                                                    echo "<input type=\"hidden\" name=\"idplato\" value=\"".$idplato."\">";
                                                    echo "<input type=\"hidden\" name=\"idingrediente\" value=\"".$ingrediente->idingrediente."\">";
                                                echo "</form>";
                                            echo "</tr>";
                                        }
                                    echo "</table>";
                            echo "</td>";
                        echo "</tr>";
                    }
                echo "</tr>";
            }
        echo "</table>";
        
        
    ?>
</body>
</html>