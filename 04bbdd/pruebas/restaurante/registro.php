<?php
    require_once "modelo.php";
    $self = htmlentities($_SERVER["PHP_SELF"]);
    $conexion = conexion("restaurante", "root", "");
    if(!$conexion) {
        echo "Error de conexion a restaurante";
        exit();
    }

    $msg = "";
    if(isset($_POST["registrar"])) {
        $resultado = registrar($conexion, strtoupper($_POST["dni"]), $_POST["login"], $_POST["password"], $_POST["nombre"]);
        $msg = $resultado[1];

        if($resultado[0]) {
            if(is_uploaded_file($_FILES["imagen"]["tmp_name"])) {
                $resultado2 = guardarImagenCliente($conexion, $_POST["dni"], $_FILES["imagen"]["tmp_name"]);
                $msg .= "<br>".$resultado2[1];
            }
        }
    }

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
         echo "<form action=\"$self\" method=\"post\" enctype=\"multipart/form-data\">";
            echo "<table>";
                echo "<tr>";
                    echo "<td>DNI: </td>";   
                    echo "<td><input type=\"text\" name=\"dni\" pattern=\"[0-9]{8}[A-Za-z]{1}\" title=\"8 numeros + letra\" required></td>";
                echo "</tr>";
                echo "<tr>";
                    echo "<td>Login: </td>";   
                    echo "<td><input type=\"email\" name=\"login\" required></td>";
                echo "</tr>";
                echo "<tr>";
                    echo "<td>Contraseña: </td>";   
                    echo "<td><input type=\"password\" name=\"password\" required></td>";
                echo "</tr>";
                echo "<tr>";
                    echo "<td>Nombre: </td>";   
                    echo "<td><input type=\"text\" name=\"nombre\" required></td>";
                echo "</tr>";
                echo "<tr>";
                    echo "<td>Imagen: </td>";   
                    echo "<td><input type=\"file\" name=\"imagen\"></td>";
                echo "</tr>";
                echo "<tr>";  
                    echo "<td colspan=\"2\"><input type=\"submit\" name=\"registrar\" value=\"REGISTRAR\"></td>";
                echo "</tr>";
                if($msg != ""){
                    echo "<tr><td colspan=\"2\">$msg</td></tr>";
                }   
                echo "</table>";
        echo "</form>";
    ?>
</body>
</html>