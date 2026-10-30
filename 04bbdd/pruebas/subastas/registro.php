<?php
    require_once __DIR__."/header.php";

    $self = htmlentities($_SERVER["PHP_SELF"]);

    $msg = "";
    if(isset($_POST["botonSubmit"])) {
        $usuario = trim($_POST["usuario"]);
        $nombre = trim($_POST["nombre"]);
        $password1 = $_POST["password1"];
        $password2 = $_POST["password2"];
        $email = trim($_POST["email"]);

        if(existeUsuario($conexion, $usuario)) {
            $msg = "Ya existe el usuario $usuario";
        }
        else {
            
        }
    }

    echo "<h2>REGISTRO</h2>";
    if($msg != ""){
        echo "<h3>$msg</h3>";
    }   
    echo "<p>Para registrate en $foro, rellena el siguiente formulario</p>";
    echo "<form action=\"$self\" method=\"post\" id=\"formu\">";
        echo "<table id=\"tabla\">";
            echo "<tr>";
                echo "<td>Usuario</td>";
                echo "<td><input type=\"text\" name=\"usuario\"></td>";
            echo "</tr>";
            echo "<tr>";
                echo "<td>Nombre completo</td>";
                echo "<td><input type=\"text\" name=\"nombre\"></td>";
            echo "</tr>";
            echo "<tr>";
                echo "<td>Password</td>";
                echo "<td><input type=\"password\" name=\"password1\" id=\"password1\"></td>";
            echo "</tr>";
            echo "<tr>";
                echo "<td>Password (de nuevo)</td>";
                echo "<td><input type=\"password\" name=\"password2\" id=\"password2\"></td>";
            echo "</tr>";
            echo "<tr>";
                echo "<td>Email</td>";
                echo "<td><input type=\"email\" name=\"email\"></td>";
            echo "</tr>";
            echo "<tr>";
                echo "<td></td>";
                echo "<td><input id=\"botonSubmit\" type=\"submit\" name=\"botonSubmit\" value=\"Registrate\"></td>";
            echo "</tr>";
        echo "</table>";
    echo "</form>";
    echo "<script src=\"registro.js\" defer></script>";

    require_once __DIR__."/foot.php";
?>