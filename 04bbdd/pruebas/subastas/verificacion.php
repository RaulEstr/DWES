<?php
    require_once __DIR__."/header.php";
    $self = htmlentities($_SERVER["PHP_SELF"]);

    if(isset($_GET["login"])) {
        header("Location: login.php");
        exit();
    }

    if(isset($_GET["email"]) && isset($_GET["cadena"])) {
        if(activarCuenta($conexion, $_GET["email"], $_GET["cadena"])) {
            echo "<h3>Se ha verificado tu cuenta. Puedes entrar punchando <a href=\"$self?login\">log in</a></h3>";
        }
        else {
            echo "<h3>No se puede verificar dicha cuenta</h3>";
        }
    }

    require_once __DIR__."/foot.php";
?>