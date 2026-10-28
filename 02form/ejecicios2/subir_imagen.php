<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .seleccionado {
            color: lightseagreen;
        }
        .noSeleccionado {
            color: black;
        }
        nav a {
            margin-left: 20px;
        }
        table, tr, td {
            margin: 5px;
            padding: 5px;
        }
        span {
            color: lightseagreen;
        }
    </style>

    <?php 
    
    // Para tener mejor orden, las subcarpetas van a estar dentro de una carpeta llamada "imagenes"
    // El archivo "CAT.txt" está dentro de la correspondiente subcarpeta

    const CARPETA = "imagenes/";
    $seleccionado = "";
    if(isset($_GET["rutaSeleccionada"])) {
        $seleccionado = $_GET["rutaSeleccionada"];
    }
    
    ?>
</head>
<body>
    <?php 
     
    echo "<nav>";

    $dirs = scandir(CARPETA);
    foreach($dirs as $dir) {
        $rutaDir = $_SERVER["PHP_SELF"]."?rutaSeleccionada=".$dir;
        if($dir != "." && $dir != "..") {
            if($dir == $seleccionado) {
                echo "<a class=\"seleccionado\" href=\"$rutaDir\">$dir</a>";
            }
            else {
                echo "<a class=\"noSeleccionado\" href=\"$rutaDir\">$dir</a>";
            }
        }
    }
    echo "</nav>";
    echo "<p><strong>Subiendo imagen a carpeta: <span>$seleccionado</span></strong></p>";
    ?>

    <form action="gestion_categoria.php" method="POST" enctype="multipart/form-data">
        <table>
            <input type="hidden" name="categoria" value="<?php echo $seleccionado ?>">
            <tr><td><strong>Tu Nombre:</strong></td></tr>
            <tr><td><input required type="text" name="nombre"></td></tr>         
            <tr><td><strong>Tu Nombre:</strong></td></tr>
            <tr><td><input required type="file" name="fich"></td></tr>

            <?php 
            
            if($seleccionado == "") {
                echo "<tr><td><input type=\"submit\" name=\"subir\" value=\"SELECCIONA CATEGORIA\" disabled></td></tr>";
            }
            else {
                echo "<tr><td><input type=\"submit\" name=\"subir\" value=\"SUBIR Y VER CARPETA\"></td></tr>";
            }
            
            ?>          
        </table>
    </form>
</body>
</html>