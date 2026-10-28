<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        span {
            color:lightseagreen;
        }
        table, th, tr, td {
            border: 1px solid black;
            border-collapse: collapse;
            margin: 5px;
            padding: 5px;
            text-align: center;
        }
        input[type="submit"] {
            border: 0px transparent;
            border-radius: 10px;
            color: white;
            font-weight: bold;
            height: 50px;
            margin: 10px;
            padding: 10px;
            cursor: pointer;
        }
        input[name="eliminar"] {
            background-color: red;
           
        }
        input[name="archivar"] {
            background-color: blue;
        }
    </style>

    <?php 
    
    const CARPETA = "imagenes/";
    $tiposValidos = ["image/gif", "image/jpeg", "image/jpg", "image/png"];
    $nombre = "";
    $categoria = "";
    $resultado = "";

    if(isset($_POST["subir"])) {
        $categoria = $_POST["categoria"];
        $nombre = $_POST["nombre"];
        $dir = CARPETA.$_POST["categoria"];
        if(is_uploaded_file($_FILES["fich"]["tmp_name"]))  {
            if(in_array($_FILES["fich"]["type"], $tiposValidos)) {
                $destino = CARPETA.$categoria."/".$nombre."_".basename($_FILES["fich"]["name"]);
                move_uploaded_file($_FILES["fich"]["tmp_name"], $destino);
                $resultado = "Imagen ".basename($_FILES["fich"]["name"])." alojada con éxito";
            }
            else {
                $resultado = "Error. Tipo de imagen no valida";
            }  
        }
        else {
            $resultado = "Error. Ha habido algún fallo al subir la imagen";
        }
    }

    if(isset($_POST["archivar"])) {
        $categoria = $_POST["categoria"];
        $nombre = $_POST["nombre"];
        if(isset($_POST["marcado"])) {
            $marcados = $_POST["marcado"];
            $fich = CARPETA.$categoria."/".$categoria.".txt";
            $f = fopen($fich, "a");
            foreach($marcados as $marcado) {
                fputs($f, $marcado."\n");
                $resultado .= "Archivado: ".$marcado.". ";
            }
            fclose($f);
        }
        else {
            $resultado = "Error. No se ha seleccionado ninguna imagen para archivar";
        }  
    }

    if(isset($_POST["eliminar"])) {
        $categoria = $_POST["categoria"];
        $nombre = $_POST["nombre"];
        if(isset($_POST["marcado"])) {
            $marcados = $_POST["marcado"];
            foreach($marcados as $marcado) {
                $ruta = CARPETA.$categoria."/".$marcado;
                unlink($ruta);
                $resultado .= "Eliminado: ".$marcado.". ";
            }
        }
        else {
            $resultado = "Error. No se ha seleccionado ninguna imagen para eliminar";
        }
    }

    ?>
</head>
<body>
    <?php 
    
    echo "<h2>Contenido del Directorio: <span>$categoria</span></h2>";
    echo "<p>Usuario gestionando: <strong>$nombre</strong></p>";
    echo "<p>$resultado</p>"; 
    
    $archivos = scandir(CARPETA.$categoria);
    $cantidad = 0;
    foreach($archivos as $archivo) {
        if($archivo != "." && $archivo != "..") {
            if(in_array(mime_content_type(CARPETA.$categoria."/".$archivo), $tiposValidos)) {
                $cantidad++;
            }
        }
    }
    if($cantidad > 0) {
        echo "<form method=\"post\">";
            echo "<table>";
                echo "<tr>";
                    echo "<th>Marcar</th>";
                    echo "<th>Miniatura</th>";
                    echo "<th>Nombre del Fichero</th>";
                echo "</tr>";
                foreach ($archivos as $archivo) {
                    $ruta = CARPETA.$categoria."/".$archivo;
                    $tipo = mime_content_type($ruta);
                    if(in_array($tipo, $tiposValidos)) {
                        echo "<tr>";
                            echo "<td><input type=\"checkbox\" name=\"marcado[]\" value=\"$archivo\"></td>";
                            echo "<td><img width=100 src=\"$ruta\"></td>";
                            echo "<td width=200>$archivo</td>";
                        echo "</tr>";
                    }
                }
            echo "<input type=\"hidden\" name=\"categoria\" value=\"$categoria\">";
            echo "<input type=\"hidden\" name=\"nombre\" value=\"$nombre\">";
        echo "</table>";
        echo "<div>";
            echo "<input type=\"submit\" name=\"archivar\" value=\"ARCHIVAR SELECCIONADAS\">";
            echo "<input type=\"submit\" name=\"eliminar\" value=\"ELIMINAR FISICAMENTE\">";
        echo "</div>";
        echo "</form>";
    }
    else {
        echo "<p>No hay imágenes que mostrar</p>";
    }
    
    echo "<br>";
    echo "<a href=\"subir_imagen.php?rutaSeleccionada=$categoria\"><- Volver a la pantalla de subida</a>";
    ?>
   
</body>
</html>