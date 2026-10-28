<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php 
    include(__DIR__."/datos.php");
    
    $mensaje = "";
    $resultado = "";
    $tamanioSeleccionado = "";
    $tipoSeleccionado = "";
    $extrasSeleccionados = [];

    if(isset($_POST["submit"])) {
        $tipoSeleccionado = $_POST["tipo"]; 
        if(isset($_POST["extra"])) {
            $extrasSeleccionados = $_POST["extra"];
        }
        
        if(!isset($_POST["tamanio"])) {
            $mensaje = "Tienes que seleccionar un tamaño";   
        }
        else {
            $tamanioSeleccionado = $_POST["tamanio"];

            $precioTotal = $precios_tipo[$tamanioSeleccionado];
 
            $resultado = "<p>Pizza elegida: $tipoSeleccionado ($tamanioSeleccionado)</p>";
            $resultado .= "<p>Ingredientes incluidos:<p>";
            $resultado .= "<ul>";
            foreach($pizzas_ingredientes[$tipoSeleccionado] as $ingrediente) {
                $resultado .= "<li>$ingrediente</li>";
                $precioTotal += 1;
            }
            $resultado .= "</ul>";
            if(sizeof($extrasSeleccionados) != 0) {
                $resultado .= "<p>Ingredientes extra añadidos:</p>";
                $resultado .= "<ul>";

                foreach($extrasSeleccionados as $extra) {
                    $resultado .= "<li>$extra</li>";
                    $precioTotal += $ingredientes_extra[$extra];
                }
                $resultado .= "</ul>";
            }
            $resultado .= "<p>Precio Total: ".number_format($precioTotal,2)."€</p>";
        }
    }
    
    ?>

    
</head>
<body>
    <?php 
    echo "<form method=\"post\">";
        echo "<p>Selecciona el tamaño:</p>";
        foreach($precios_tipo as $tipo => $precio) {
            if($tipo == $tamanioSeleccionado) {
                echo "<input checked=\"checked\" type=\"radio\" name=\"tamanio\" value=\"$tipo\">$tipo (".number_format($precio,2)."€)";
            }
            else {
                echo "<input type=\"radio\" name=\"tamanio\" value=\"$tipo\">$tipo (".number_format($precio,2)."€)";
            }
            echo "<br>";
        }

        if($mensaje != "") {
            echo "<p style=\"color: red\">$mensaje</p>";
        }

        echo "<p>Selecciona la Pizza:</p>";
        echo "<select name=\"tipo\">";
            foreach($pizzas_ingredientes as $pizza => $ingredientes) {
                if($pizza == $tipoSeleccionado) {
                    echo "<option selected=\"selected\" value=\"$pizza\">$pizza</option>";
                }
                else {
                    echo "<option value=\"$pizza\">$pizza</option>";
                }
            }
        echo "</select>";

        echo "<p>¿Quieres añadir ingredientes extra?</p>";
        foreach($ingredientes_extra as $ingrediente => $precio) {
            if(in_array($ingrediente, $extrasSeleccionados)) {
                echo "<input checked=\"checked\" type=\"checkbox\" name=\"extra[]\" value=\"$ingrediente\">$ingrediente (+".number_format($precio,2)."€)";
            }
            else {
                echo "<input type=\"checkbox\" name=\"extra[]\" value=\"$ingrediente\">$ingrediente (+".number_format($precio,2)."€)";
            }
            echo "<br>";
        }

        echo "<br>";

        echo "<input type=\"submit\" name=\"submit\" value=\"Calcular Precio\">";

        if($resultado != "") {
            echo "<h3>Resumen de tu pedido: </h3>";
            echo $resultado;
        }

    echo "</form>";

    ?>
</body>
</html>