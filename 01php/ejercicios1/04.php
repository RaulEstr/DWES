<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php require_once("04funcs.php") ?>
</head>
<body>
    <?php 
    
    $rutas = [
        "imgs/imagen1.jpg", 
        "imgs/imagen2.jpg", 
        "imgs/imagen3.jpg", 
        "imgs/imagen4.jpg", 
        "imgs/imagen5.jpg", 
        "imgs/imagen4.jpg",
        "imgs/imagen1.jpg"];
    mostrarImagenes($rutas);

    ?>
</body>
</html>