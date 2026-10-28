<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php 
    
    $arrTemperaturas = [5,10,15,6,8,3,20,35,18,17,30, 22, -1, 0, 21];
    print_r($arrTemperaturas);

    $media = array_sum($arrTemperaturas) / sizeof($arrTemperaturas);
    $mediaRedondeada = round($media);
    $mediaTruncada = round($media, 2);
    echo "<p>La madia de las temperaturas del mes (redondeada) es: $mediaRedondeada </p>";
    echo "<p>La media de las temperaturas del mes es: $mediaTruncada </p>";

    sort($arrTemperaturas);
    echo "<p> Las temperaturas más bajas del mes son: ";
    for($i=0; $i<count($arrTemperaturas) && $i < 5; $i++) {
        echo $arrTemperaturas[$i].",";
    }
    echo "</p>";
    
    rsort($arrTemperaturas);
    echo "<p> Las temperaturas más altas del mes son: ";
    for($i=0; $i<count($arrTemperaturas) && $i < 5; $i++) {
        echo $arrTemperaturas[$i].",";
    }
    echo "</p>"

    ?>
</body>
</html>