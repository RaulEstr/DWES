<?php
    require_once __DIR__."/header.php";
    $self = htmlentities($_SERVER["PHP_SELF"]);

    if(isset($_GET["registro"])) {
        header("Location: registro.php");
        exit();
    }

    $msg = "";
    if(isset($_POST["botonSubmit"])) {
        $usuarioLogin = login($conexion, $_POST["usuario"], $_POST["password"]);
        if(count($usuarioLogin) == 0) {
            $msg = "El usuario o la contraseña son incorrectos, intentalo de nuevo";
        }
        else {
            $usuarioLogin = $usuarioLogin[0];
            if($usuarioLogin->activo == 0) {
                $msg = "Esta cuenta no está verificada. Te hemos enviado un email para verificarla";
            }
            else {
                $_SESSION["logedUserId"] = $usuarioLogin->id;
                $_SESSION["logedUser"] = $usuarioLogin->username;
                header("Location: ".$_SESSION["lastPage"]);
                exit();
            }
        }
    }

    if($msg != "") {
        echo "<p>$msg</p>";
    }
    echo "<form action=\"$self\" method=\"post\">";
        echo "<table id=\"tabla\">";
            echo "<tr>";
                echo "<td>Usuario</td>";
                echo "<td><input type=\"text\" name=\"usuario\"></td>";
            echo "</tr>";
            echo "<tr>";
                echo "<td>Password</td>";
                echo "<td><input type=\"password\" name=\"password\"></td>";
            echo "</tr>";
            echo "<tr>";
                echo "<td></td>";
                echo "<td><input type=\"submit\" name=\"botonSubmit\" value=\"Login\"></td>";
            echo "</tr>";
        echo "</table>";
    echo "</form>";
    echo "<p>No tienes una cuenta? <a href=\"$self?registro\">Regístrate!</a></p>";

    require_once __DIR__."/foot.php";
?>