<?php
    require_once __DIR__."/header.php";
    $self = htmlentities($_SERVER["PHP_SELF"]);

    if(isset($_SESSION["logedUser"])) {
        if($_SESSION["logedUser"] != "admin") {
            header("Location: index.php");
            exit();
        }
    }

    if(!isset($_SESSION["borrados"])) {
        $_SESSION["borrados"] = 0;
    }

    if(!isset($_SESSION["activados"])) {
        $_SESSION["activados"] = 0;
    }

    if(isset($_POST["borrar"])) {
        if(borrarUsuario($conexion, $_POST["usuarioId"])) {
            $_SESSION["borrados"]++;
        }
    }

    if(isset($_POST["activar"])) {
        if(activarCuentaPorAdmin($conexion, $_POST["usuarioId"])) {
            $_SESSION["activados"]++;
        }
    }


    $inactivos = usuariosInactivos($conexion);

    echo "<h1>Usuarios inactivos</h1>";
    if(count($inactivos) == 0) {
        echo "<p>No hay usuarios inactivos</p>";
    }
    else {
        echo "<table>";
        echo "<th>USUARIO</th><th>NOMBRE</th><th>EMAIL</th><th>CADENA VERIFICACIÓN</th><th>ACCIONES</th>";
        foreach ($inactivos as $inactivo) {
            echo "<tr>";
                echo "<form method=\"post\" action=\"$self\">";
                    echo "<input type=\"hidden\" name=\"usuarioId\" value=\"$inactivo->id\">";
                    echo "<td>$inactivo->username</td>";
                    echo "<td>$inactivo->nombre</td>";
                    echo "<td>$inactivo->email</td>";
                    echo "<td>".substr($inactivo->cadenaverificacion, 0, 10)."...</td>";
                    echo "<td>";
                        echo "<input type=\"submit\" name=\"borrar\" value=\"BORRAR\">";
                        echo "<input type=\"submit\" name=\"activar\" value=\"ACTIVAR\">";
                    echo "</td>";
                echo "</form>";
            echo "</tr>";
        }
        echo "</table>";
    }

    if($_SESSION["borrados"] > 0) {
        echo "<p>Se han borrado ".$_SESSION["borrados"]." usuarios inactivos</p>";
    }

    if($_SESSION["activados"] > 0) {
        echo "<p>Se han activado ".$_SESSION["activados"]." usuarios inactivos</p>";
    }


    require_once __DIR__."/foot.php";
?>