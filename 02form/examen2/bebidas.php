<?php


function fichero_a_array($nombre_fichero)
{
    $arr = [];
   
    $fichero = fopen($nombre_fichero, "r");
    if ($fichero !== false) {
     
        while (($linea = fgets($fichero)) !== false) {

           
            $linea = trim($linea);
            // Ignoramos líneas vacías
            if ($linea != "") {               
                $datos = explode(";", $linea);
                $nombre = trim($datos[0]);
                $precio = (float)trim($datos[1]);
                $arr[$nombre] = $precio;
            }
        }
        fclose($fichero);
    }

    return $arr;
}

function cambiar_precio($fichero, $bebidaSel, $nuevoPrecio) {
    $bebidas = fichero_a_array($fichero);
    $precioOriginal = $bebidas[$bebidaSel];

    if($nuevoPrecio > $precioOriginal * 2) {
        return false;
    }
    else {
        $bebidas[$bebidaSel] = $nuevoPrecio;

        $fich = fopen($fichero, "w");
        foreach($bebidas as $bebida => $precio) {
            fputs($fich, $bebida.";".number_format($precio,2)."\n");
        }
        fclose($fich);
        return true;
    } 
}

$error = "";
$bebidaElegida = "";
if(isset($_POST["submit"])) {
    $bebidaElegida = $_POST["bebida"];
    $precioNuevo = $_POST["precio"];
    if(!cambiar_precio("bebidas.txt", $bebidaElegida, $precioNuevo)) {
        $error = "La bebida no puede superar el doble del precio actual";
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Precios de bebidas</title>
</head>

<body>

    <?php 
    echo "<table>";
        echo "<tr>";
            echo "<th>Bebida</th>";
            echo "<th>Precio</th>";
            echo "<th>Accion</th>";
        echo "</tr>";

        $bebidas = fichero_a_array("bebidas.txt");
        foreach($bebidas as $bebida => $precio){
            echo "<form method=\"post\">";
                echo "<input type=\"hidden\" name=\"bebida\" value=\"$bebida\">";
                echo "<tr>";
                    echo "<td>$bebida</td>";
                    echo "<td><input type=\"number\" step=\"0.01\" name=\"precio\" value=\"".number_format($precio,2)."\"></td>";
                    echo "<td><input type=\"submit\" name=\"submit\" value=\"CAMBIAR\"></td>";
                    if($bebida == $bebidaElegida && $error != "") {
                        echo "<td>$error</td>";
                    }
                echo "</tr>";
            echo "</form>";
        }

    echo "</table>";
    ?>

</body>

</html>
