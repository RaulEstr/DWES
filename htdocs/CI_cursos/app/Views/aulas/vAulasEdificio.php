<?php

/**
 * @var object $edificio 
 * @var array $aulas
**/

if($edificio == null) {
    echo "<p class=\"red\">El edificio seleccionado no existe</p>";
}
else {
    echo "<p>Aulas en <strong>$edificio->nombre</strong></p>";
    echo "<table>";
        echo "<tr><th>Nº AULA</th><th>CAPACIDAD</th></tr>";
        foreach($aulas as $aula) {
            echo "<tr>";
                echo "<td>$aula->numero</td>";
                echo "<td>$aula->capacidad personas</td>";
                $enlace = site_url()."/Edificio/$edificio->idedificio/$aula->numero";
                echo "<td>".anchor($enlace, "Ver cursos")."</td>";
            echo "</tr>";
        }
    echo "</table>";
}