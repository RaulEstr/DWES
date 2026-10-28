<?php
    require_once "modelo.php";
    $self = htmlentities($_SERVER["PHP_SELF"]);
    $conexion = conexion("restaurante", "root", "");
    if(!$conexion) {
        echo "Error de conexion a restaurante";
        exit();
    }
    
    $msg = "";
    if(isset($_POST["insertar"])) {
        if(is_uploaded_file($_FILES["imagen"]["tmp_name"])) {
            insertarPlato($conexion, $_POST["nombre"], $_POST["precio"], $_POST["fecha"], $_FILES["imagen"]["name"]);
            move_uploaded_file($_FILES["imagen"]["tmp_name"], "imgs/".$_FILES["imagen"]["name"]);
            $msg = "Plato añadido con imagen";
        }
        else {
            insertarPlato($conexion, $_POST["nombre"], $_POST["precio"], $_POST["fecha"], null);
            $msg = "Plato añadido sin imagen";
        }
    }

    if(isset($_GET["subir"])) {
        $id = $_GET["id"];
        subirPrecio($conexion, $id, 5);
    }

    $arrPlatos = platos($conexion);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        table, tr, td, th {
            margin: 10px;
            padding: 5px;
        }
    </style>
</head>
<body>
    <?php 
        echo "<table>";
        echo "<tr><th>ID</th><th>NOMBRE</th><th>PRECIO</th><th>FECHA</th><th>IMAGEN</th><th>ACCION</th></tr>";
            foreach($arrPlatos as $plato) {
                echo "<tr>";
                    echo "<td>".$plato->idplato."</td>";
                    echo "<td>".$plato->nombre."</td>";
                    echo "<td>".number_format($plato->precio, 2)."</td>";
                    echo "<td>".$plato->fecha."</td>";
                    if($plato->imagen==null) {
                        echo "<td>Sin imagen</td>";
                    }
                    else {
                        $srcImg = "imgs/".htmlentities($plato->imagen);
                        echo "<td><img src=\"$srcImg\" height=\"30\"></td>";
                    }
                    $enlace = $self."?subir&id=".$plato->idplato;
                    echo "<td><a href=\"$enlace\">Subir precio 5%</a></td>";
                echo "</tr>";
            }
        echo "</table>";
        
        echo "<form action=\"$self\" method=\"post\" enctype=\"multipart/form-data\">";
            echo "<table>";
                echo "<tr>";
                    echo "<td>Nombre: </td>";   
                    echo "<td><input type=\"text\" name=\"nombre\" required></td>";
                echo "</tr>";
                echo "<tr>";
                    echo "<td>Precio: </td>";   
                    echo "<td><input type=\"number\" name=\"precio\" step=\".1\" required></td>";
                echo "</tr>";
                echo "<tr>";
                    echo "<td>Fecha: </td>";   
                    echo "<td><input type=\"date\" name=\"fecha\" required></td>";
                echo "</tr>";
                echo "<tr>";
                    echo "<td>Imagen: </td>";   
                    echo "<td><input type=\"file\" name=\"imagen\"></td>";
                echo "</tr>";
                echo "<tr>";  
                    echo "<td colspan=\"2\"><input type=\"submit\" name=\"insertar\" value=\"Insertar\"></td>";
                echo "</tr>";
                if($msg != ""){
                    echo "<tr><td colspan=\"2\">$msg</td></tr>";
                }   
                echo "</table>";
        echo "</form>";
    ?>
</body>
</html>