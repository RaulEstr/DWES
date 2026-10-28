<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php 
    
    $handle = fopen("documentos/urls.txt","r");
    echo "<ul>";
    while(!feof($handle)) {
        $linea = fgets($handle);
        $linea = explode(" ", $linea);
        echo "<li><a href=\"$linea[0]\" target=\"_blank\">$linea[1]</a></li>";
        echo "<br>";
    }
    echo "</ul>";

    fclose($handle);
    
    ?>
</body>
</html>