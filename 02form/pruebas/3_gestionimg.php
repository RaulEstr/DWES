<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <?php 

    const CARPE = "imgs";

    function nombreDuplicado($img) {
        $partes = explode(".", $img);
        $duplicado = $partes[0]."_D".".".$partes[1];
        return $duplicado;
    }

    if(isset($_POST["borrar"])) {
        $rutaABorrar = CARPE."/".$_POST["img"];
        unlink($rutaABorrar);
    }

    if(isset($_POST["duplicar"])) {
        $rutaADuplicar = CARPE."/".$_POST["img"];
        $nuevaRuta = nombreDuplicado($rutaADuplicar);
        var_dump($rutaADuplicar);
        var_dump($nuevaRuta);
        copy($rutaADuplicar, $nuevaRuta);
    }
    
    $nombreScript = $_SERVER["PHP_SELF"];
    
    $entradas = scandir(CARPE);
    $tiposValidos = ["image/gif", "image/jpeg", "image/jpg", "image/png"];
    $imgs = [];

    foreach($entradas as $entrada) {
        $ruta = CARPE."/".$entrada;
        if(in_array(mime_content_type($ruta), $tiposValidos)) {
            $imgs[] = $entrada;
        }
    }

    ?>
</head>
<body>
    <?php 
    
    echo "<table>";
        echo "<tr><th>IMAGEN</th><th>BORRAR</th><th>DUPLICAR</th></tr>";
        foreach($imgs as $img) {
            $ruta =CARPE."/".$img;
         //   $enlace = $_SERVER["PHP_SELF"]."?imagen=".$entrada."&carpeta=".$carpeta;
            echo "<tr>";
                echo "<form method=\"POST\" action=\"$nombreScript\">";
                    echo "<input type=\"hidden\" name=\"img\" value=\"$img\">";
                    echo "<td><img width=\"150\" height=\"150\" src=\"$ruta\"></td>";
                    echo "<td><input type=\"submit\" value=\"Borrar\" name=\"borrar\"></td>";
                    echo "<td><input type=\"submit\" value=\"Duplicar\" name=\"duplicar\"></td>";
                echo "</form>";
            echo "</tr>";
        }

        echo "</table>";

    ?>
</body>
</html>