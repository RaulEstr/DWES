<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php 
    
    // Las variables superglobales que empiezan por _ son arrays asociativos
    // Tiene info como la del servidor, cliente, sesión, etc

    echo "<p>IP del servidor: ".$_SERVER["SERVER_ADDR"]."</p>";
    echo "<p>IP del cliente: ".$_SERVER["SERVER_ADDR"]."</p>";
    echo "<br>";
    
    // Este script puede recibir por GET valores de nombre, ciclo y anio

    if(isset($_GET["nombre"])) echo "<p>Nombre: ".$_GET["nombre"]."</p>";
    if(isset($_GET["ciclo"])) echo "<p>Ciclo: ".$_GET["ciclo"]."</p>";
    if(isset($_GET["anio"])) echo "<p>anio: ".$_GET["anio"]."</p>";

    ?>
</body>
</html>