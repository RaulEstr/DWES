<?php
    require_once "modelo.php";
    $conexion = conexion("bdcines", "root", "");
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
        <h1>SUBASTAS CIUDAD JARDIN</h1>
    </div>
    <div id="menu">
        <a href="error_ventas.php">Errores Ventas</a>
        <a href="error_recaudacion.php">Errores Recaudacion</a>
    </div>
    <div id="container">
        <div id="bar">
        </div>
        <div id="main">