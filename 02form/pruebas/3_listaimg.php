<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <?php 
    
    function guardarLike($nombreImg) {
        $f = fopen("registros/likesimgs.txt", "a");
        fputs($f, "Le gusta ".$nombreImg."\n");
        fclose($f);
    }

    $tiposValidos = ["image/gif", "image/jpeg", "image/jpg", "image/png"];
    $entradas = [];
    $carpeta = "";
    $errorCarpeta = "";
    if(isset($_POST["cargar"])) {
        $carpeta = $_POST["carpeta"];
        if(!is_dir($carpeta)) {
            $errorCarpeta = "Carpeta inexistente";
        }
        else {
            $entradas = scandir($carpeta);
        }
    }

    if(isset($_GET["imagen"])) {
        guardarLike($_GET["imagen"]);
        $carpeta = $_GET["carpeta"];
        $entradas = scandir($carpeta);
    }

    ?>
</head>
<body>
    <form method="POST" action="<?php echo $_SERVER["PHP_SELF"] ?>">
        <table>
            <tr>
                <td><label>Introduce el nombre de un directorio</label></td>
                <td><input type="text" name="carpeta" value="<?php echo $carpeta ?>"></td>
                <td><input type="submit" value="CARGAR" name="cargar"></td>
            </tr>
        </table>
        <?php echo $errorCarpeta ?>

        <?php 
        
        echo "<table>";
        echo "<tr><th>Miniatura</th><th>Nombre</th><th>Like</th></tr>";
        foreach($entradas as $entrada) {
            $ruta = $carpeta."/".$entrada;
            $tipo = mime_content_type($ruta);
            if(in_array($tipo, $tiposValidos)) {
                $enlace = $_SERVER["PHP_SELF"]."?imagen=".$entrada."&carpeta=".$carpeta;
                echo "<tr>
                <td><img width=\"150\" height=\"150\" src=\"$ruta\"></td>
                <td>$entrada</td>
                <td><a href=\"$enlace\">Me gusta</a></td>
                </tr>";
            }
        }

        echo "</table>";
        
        ?>
    </form>
</body>
</html>