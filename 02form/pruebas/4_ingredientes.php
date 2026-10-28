<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <?php 
    
    $ingredientes = [
        "Goxua" => ["Huevos"], 
        "Tarta de queso" => ["Queso crema", "Azucar", "Huevos", "Maicena", "Trigo", "Mantequilla"], 
        "Tiramisu" => ["Huevos"], 
        "Ensalada" => ["Lechuga", "Tomate", "Aceite de oliva", "Atun", "Sal", "Vinagre"], 
        "Almejas" => ["Almejas", "Perejil", "Aceite de oliva"], 
        "Croquetas" => ["Leche", "Harina", "Jamon", "Mantequilla", "Huevo"], 
        "Langostinos" => ["Langostinos", "Sal"], 
        "Chuleta" => ["Ternera", "Sal"]
    ];

    $plato = "";
    if(isset($_GET["plato"])) {
        $plato = $_GET["plato"];
    }

    ?>
</head>
<body>
    <?php 
    
    if(key_exists($plato, $ingredientes)) {
        echo "<h2>Ingredientes de $plato </h2>";
        echo "<ul>";

        foreach($ingredientes[$plato] as $ingrediente) {
            echo "<li>$ingrediente</li>";
        }
        echo "</ul>";
    }
    else {
        if($plato == "") {
            echo "<h2>Ha ocurrido un error</h2>";
        }
        else {
            echo "<h2>Lo sentimos, no disponemos de la lista de ingredientes de $plato</h2>";
        }
        
    }
    
    ?>
</body>
</html>