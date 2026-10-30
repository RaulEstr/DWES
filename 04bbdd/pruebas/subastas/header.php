<?php
    require_once __DIR__."/config.php";
    require_once "modelo.php";
    $conexion = conexion($bbdd, $usario, $contrasenia);
    if(!$conexion) {
        echo "Error de conexion a base de datos";
        exit();
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
        <a href="index.php">Home</a>
        <a href="registro.php">Login</a>
    </div>
    <div id="container">
        <div id="bar">
            <?php require_once $ruta."/bar.php" ?>
        </div>
        <div id="main">