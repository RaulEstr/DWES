<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php 
    
    echo "<p>". time(). " es el timestamp actual</p>";
    echo "<p>Fecha actual: ".date("d-m-Y H:i")."</p>";

    $strVerano = "2026/06/21";
    $tVerano = strtotime($strVerano);
    $tHoy = time();

    $dias = (int)(($tHoy - $tVerano)/(24*60*60));
    echo "<p>Han pasado $dias desde el inicio del verano</p>";

    $ahora = new DateTime();
    echo "<p>Hoy: ".$ahora->format("d-m-Y H:i")."</p>";

    $sanPru = new Datetime("2027-04-28");
    echo "<p>Próximo San Prucendio: ".$sanPru->format("d-m-Y")."</p>";

    $diferencia = $sanPru->diff($ahora);
    echo "<p>Quedan ".$diferencia->days." dias para San Prudencio</p>";
    
    $salida = new DateTime("today 14:30");
    $minutosParaLaSalida = ceil((($salida->getTimestamp() - $ahora->getTimestamp())/60));
    echo "<p>Quedan ".$minutosParaLaSalida." minutos para salir</p>";

    ?>
</body>
</html>