<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php require_once("05funcs.php") ?>
</head>
<body>
    <?php 
    
    $personas = [
        "Martin" => ["Tenet", "Spiderman", "Interstellar", "Mario", "Zootopia"],
        "Andrea" => ["Spiderman", "Vengadores", "Superman", "Mario", ],
        "Pedro" => ["Barbie", "Superman", "Ironman", "Zootopia", "Mario"],
    ];
    
    $peliculaABuscar = "Tenet";
    $cantidad = cuantosFavorita($personas,$peliculaABuscar);

    if($cantidad == 1) {
        echo "<p>Hay $cantidad persona que tiene $peliculaABuscar entre sus favoritas</p>";
    }
    else{
        echo "<p>Hay $cantidad personas que tienen $peliculaABuscar entre sus favoritas</p>";
    }
    

    peliculasAleatoria($personas);

    ?>
</body>
</html>