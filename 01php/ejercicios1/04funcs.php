<?php

function mostrarImagenes($arrRutas) {
    $arrRutas = array_unique($arrRutas);

    echo "<table>";

        $cantidadFilas = count($arrRutas) / 3;
        if(count($arrRutas) % 3 != 0) {
            $cantidadFilas++;
        }

        $contRutas = 0;
        for($fila=1; $fila<=$cantidadFilas; $fila++) {
            echo "<tr>";
            for($col=1; $col<=3; $col++) {
                if($contRutas < count($arrRutas)) {
                    echo "<td>";
                        echo "<img width=\"200\" height=\"200\" src=\"".$arrRutas[$contRutas]."\">";
                    echo "</td>";
                    $contRutas++;
                }
            }
            echo "</tr>";
        }
        
    echo "</table>";
}

?>