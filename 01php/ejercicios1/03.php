<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php 
    
    $arrProductos = ["Cubo", "Pala", "Cepillo", "Mesa", "Mesa", "Silla", "Pala", "Camiseta", "Botella", "Raton", "Cubo"];
    echo "<p>Productos: ";
    for($i=0; $i<count($arrProductos); $i++) {
        echo $arrProductos[$i].", ";
    }
    echo "</p>";

    $arrProductosSinRepetir = array_unique($arrProductos);
    sort($arrProductosSinRepetir);

    echo "<p>Productos sin repetir: ";
    for($i=0; $i<count($arrProductosSinRepetir); $i++) {
        echo $arrProductosSinRepetir[$i].", ";
    }
    echo "</p>";

    echo "<p>Hay ".count($arrProductosSinRepetir)." productos distintos</p>"

    ?>
</body>
</html>