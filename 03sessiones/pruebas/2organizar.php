<?php
    session_start();

    if(empty($_SESSION["apuntados"])) {
        header("location:2cena.php");
        exit();
    }

    function lleva_otro($queLleva) {
        $cuantos = 0;
        foreach($_SESSION["apuntados"] as $apuntado) {
            if($apuntado->lleva == $queLleva) {
                $cuantos += 1;
            }
        }

        return ($cuantos > 1);
    }

    if(isset($_POST["cambiar"])) {
        $nombre = $_POST["nombre"];
        $cambiarPor = $_POST["cambiarPor"];
        // foreach($_SESSION["apuntados"] as $apuntado)  {
        //     if($apuntado->nombre == $nombre) {
        //         $apuntado->lleva = $cambiarPor;
        //     }
        // }

        $ind = array_search($nombre, array_column($_SESSION["apuntados"], "nombre"));
        $_SESSION["apuntados"][$ind]->lleva = $cambiarPor;
    }    

    if(isset($_POST["anular"])) {
        $nombre = $_POST["nombre"];
        $ind = array_search($nombre, array_column($_SESSION["apuntados"], "nombre"));

        unset($_SESSION["apuntados"][$ind]);
        $_SESSION["apuntados"] = array_values($_SESSION["apuntados"]);

        if(empty($_SESSION["apuntados"])) {
            header("location:2cena.php");
            exit();
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
        table, th, tr, td {
            margin: 5px;
            padding: 5px;
        }
        .asistentes, .asistentes tr {
            border: 1px solid black;
            border-collapse: collapse;
        }
    </style>
</head>
<body>
    <?php 
    
    echo "<table class=\"asistentes\">";
        echo "<tr><th>NOMBRE</th><th>ASISTENTES</th><th>LLEVA</th><th>DESAPUNTAR</th></tr>";
        foreach($_SESSION["apuntados"] as $apuntado) {
            echo "<form action=\"".$_SERVER["PHP_SELF"]."\" method=\"post\">";
            echo "<tr>";
                echo "<input type=\"hidden\" name=\"nombre\" value=\"$apuntado->nombre\">";
                echo "<td>$apuntado->nombre</td>";
                echo "<td>$apuntado->asistentes</td>";
                echo "<td>$apuntado->lleva</td>";
                echo "<td><input type=\"submit\" value=\"ANULAR\" name=\"anular\"></td>";
                if(lleva_otro($apuntado->lleva)) {
                    echo "<td><input required type=\"text\" name=\"cambiarPor\"></td>";
                    echo "<td><input type=\"submit\" value=\"CAMBIAR\" name=\"cambiar\"></td>"; 
                }
            echo "</tr>";
            echo "</form>";
        }   
    echo "</table>";
    
    ?>
</body>
</html>