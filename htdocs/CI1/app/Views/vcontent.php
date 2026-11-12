<?php

$dias = ["Lunes" => 23, "Martes" => 12, "Miercoles" => 12, "Jueves" => 12, "Viernes" => 2, "Sabado" => 3, "Domingo" => 0];

echo "<h1>Temperaturas de esta semana</h1>";
echo "<table>";
    foreach($dias as $dia=>$temp) {
        echo "<tr>";
            echo "<td>$dia</td>";
            echo "<td>$temp ºC</td>";
        echo "</tr>";
    }
echo "</table>";
?>