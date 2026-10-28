<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php require_once("01funcs.php") ?>
</head>
<body>
    <?php 
    
    // 1
    $ahora = new DateTime("today");
    echo "<p>Hoy: ".$ahora->format("dS F Y, l")."</p>";

    // 2
    $finAnio = new DateTime("2026/12/31");
    $difDias = $finAnio->diff($ahora);
    echo "<p>Dias que faltan para fin de año: ".$difDias->days."</p>";

    // 3
    $arrPalabras = ["Hola", "mi", "nombre", "es", "Paco", "y", "soy", "medico"];
    $cadena = implode(" ", $arrPalabras);
    echo "<p>Cadena creada a partir de array de palabras: $cadena</p>";

    // 4
    $cadenaEnies = "ññññññññññññññññ";
    echo "<p>Cadena de ñ: $cadenaEnies</p>";
    $cadenaReemplazada = str_replace("ñ", "gn", $cadenaEnies);
    echo "<p>Cadena reemplazada: $cadenaReemplazada</p>";

    // 5
    $arrAleatorios = numerosRandom(10, 50, 100);
    print_r($arrAleatorios);
    
    // 6
    $sinCifrar = "HOLA AMO";
    $cifrado = cifrar($sinCifrar);

    echo "<p>Cadena sin cifrar: $sinCifrar </p>";
    echo "<p>Cadena cifrada: $cifrado </p>";

    ?>
</body>
</html>