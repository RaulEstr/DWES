<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php 
    
    $edad = 20;
    echo "<p>Hola tengo \"$edad\" años</p>";

    $saludo = "Hola buenos días";
    echo "<p>Longitud de \"$saludo\": ".strlen($saludo)."</p>";
    echo "<p>Ultimo caracter de \"$saludo\": ".$saludo[strlen($saludo) - 1]."</p>";
    
    $pos = strpos($saludo, "hola");
    echo "<p>Aparece en posición: ".$pos."</p>";

    $ip = "192.168.20.120";
    $arr = explode(".", $ip);
    
    echo "<p>La IP \"$ip\" está formada por ".count($arr)." partes y el identificador del equipo es ". $arr[count($arr) - 1]." </p>";

    ?>
</body>
</html>