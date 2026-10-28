<?php

function dibujarTabla($datos) {
    echo "<table>";
        dibujarTitulo($datos["dias"]);

        $ini = explode(":", $datos["horaIni"]);
        $ini = new DateTime($ini[0].":".$ini[1]);
        $fin = explode(":", $datos["horaFin"]);
        $fin = new DateTime($fin[0].":".$fin[1]);

        $intervalo = $datos["intervalo"];
        $cantidad = count($datos["dias"]);

        dibujarLineas($ini, $fin, $intervalo, $cantidad);
    echo "</table>";
}

function dibujarTitulo($titulos) {
    echo "<tr>";
        echo "<td></td>";
        for($i=0; $i<count($titulos); $i++) {
            echo "<td>".$titulos[$i]."</td>";
        }
    echo "</tr>";
}

function dibujarLineas($horaIni, $horaFin, $intervalo, $cantidad) {
    $cont = 1;
    while($horaIni <= $horaFin) {
        if($cont % 2 == 0) {
            echo "<tr class=\"gray\">";
        }
        else {
            echo "<tr>";
        }
        $cont++;

        $hora = $horaIni->format("H:i");        
        echo "<td>".$hora."</td>";    
        for($i=0; $i<$cantidad; $i++) {
            echo "<td></td>";
        }   
        echo "</tr>";     
        $horaIni -> add(new DateInterval("PT".$intervalo."M"));
    }
}

?>