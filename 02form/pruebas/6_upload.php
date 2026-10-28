<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <?php 
    
    $tiposValidos = ["image/gif", "image/jpeg", "image/jpg", "image/png"];

    if(isset($_POST["submit"])) {
        if(is_uploaded_file($_FILES["fich"]["tmp_name"])) {

            if(in_array($_FILES["fich"]["type"], $tiposValidos)) {
                $destino = "imgs/uploaded/".basename($_FILES["fich"]["name"]);
                move_uploaded_file($_FILES["fich"]["tmp_name"], $destino);
                echo "<p>Archivo subido</p>";
            }
            else {
                echo "<p>No se ha subido el archivo, el archivo no era una imagen</p>";
            }
        }
    }

    ?>

</head>
<body>
    <form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="POST" enctype="multipart/form-data">
        <table>
            <tr><td><label>Elige imagen</label></td></tr>
            <tr><td><input type="file" name="fich"></td></tr>
            <tr><td><input type="submit" name="submit" value="SUBIR ARCHIVO"></td></tr>
        </table>
     </form>

    <?php 
    echo "<table>";
        echo "<tr><th>Nombre</th><th></th><th>Imagen</th></tr>";
        $ruta = "imgs/uploaded";
        $dir = scandir($ruta);
        foreach($dir as $file) {
            $img = $ruta."/".$file;
            $tipo = mime_content_type($img);
            if(in_array($tipo, $tiposValidos)) {
                echo "<tr>";
                    echo "<td><p>$file</p></td>";
                    echo "<td><a href=\"".$_SERVER["PHP_SELF"]."?img=".$file."\">VER IMAGEN</a></td>";
                    if(isset($_GET["img"]) && $_GET["img"] == $file) {
                        echo "<td><img width=\"150\" height=\"150\" src=\"$img\"></td>";
                    }       
                echo "</tr>";
               
            }
        }
    echo "</table>";
    ?>
   
</body>
</html>