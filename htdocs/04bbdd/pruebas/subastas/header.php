<?php
    require_once __DIR__."/config.php";
    require_once "modelo.php";
    $conexion = conexion($bbdd, $usariobbdd, $contraseniabbdd);
    if(!$conexion) {
        echo "Error de conexion a base de datos";
        exit();
    }
    $self = htmlentities($_SERVER["PHP_SELF"]);
    session_start();

    if(isset($_GET["index"])) {
        header("Location: index.php");
        exit();
    }

    if(isset($_GET["logout"])) {
        header("Location: logout.php");
        exit();
    }

    if(isset($_GET["login"])) {
        header("Location: login.php");
        exit();
    }

    if(isset($_GET["vencidas"])) {
        header("Location: vencidas.php");
        exit();
    }

    if(isset($_GET["publi"])) {
        header("Location: publi.php");
        exit();
    }

    if(isset($_GET["inactivos"])) {
        header("Location: inactivos.php");
        exit();
    }

    if(isset($_GET["pujashoy"])) {
        header("Location: pujas_hoy.php");
        exit();
    }


    if(isset($_GET["nuevoitem"])) {
        if(isset($_SESSION["logedUserId"])) {
            header("Location: nuevoitem.php");
            exit(); 
        }
        else{
            header("Location: login.php");
            exit();
        }
        
    }

?>
<html>
    <head>
        <title><?php echo ""; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="stylesheet.css" type="text/css" />
    </head>
<body>
    <div id="header">
        <h1><?php echo $foro ?></h1>
    </div>
    <div id="menu">
        <?php
        echo "<a href=\"$self?index\">Home  </a>";
         
        if(isset($_SESSION["logedUserId"])) {
            echo "<a href=\"$self?logout\">Logout   </a>";
            echo "<a href=\"$self?nuevoitem\">Nuevo item    </a>";
            if($_SESSION["logedUser"] == "admin") {
                echo "<a href=\"$self?vencidas\">Subastas vencidas   </a>";
                echo "<a href=\"$self?publi\">Anunciantes    </a>";
                echo "<a href=\"$self?inactivos\">Inactivos </a>";
                echo "<a href=\"$self?pujashoy\">Pujas hoy  </a>";
            }
        }
        else {
            echo "<a href=\"$self?login\">Login </a>";
        }

        

        ?>
        
    </div>
    <div id="container">
        <div id="bar">
            <?php require_once $ruta."/bar.php" ?>
        </div>
        <div id="main">