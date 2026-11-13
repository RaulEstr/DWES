<?php

/**
 * @var array $cursosbaratos // Array de objetos: idcurso, dia, tema, categoria, precio
 * @var int $cuantos
 * @var array $cursoscongente // Array asociativo: idcurso, idedificio, num_aula, dia, asistentes
**/
echo "<h2>Cursos Baratos</h2>";
echo "<table>";
echo "<tr><th>DIA</th><th>CATEGORIA</th><th>TEMA</th><th>PRECIO</th></tr>";
    foreach($cursosbaratos as $curso) {
        echo "<tr>";
            echo "<td>$curso->dia</td>";
            echo "<td>$curso->categoria</td>";
            echo "<td>$curso->tema</td>";
            echo "<td>$curso->precio €</td>";
        echo "</tr>";
    }
echo "</table>";

echo "<h2>Cursos con 2 personas</h2>";
echo "<table>";
echo "<tr><th>IDCURSO</th><th>IDEDIFICIO</th><th>NUM_AULA</th><th>DIA</th><th>ASISTENTES</th></tr>";
    foreach($cursoscongente as $curso) {
        echo "<tr>";
            echo "<td>".$curso["idcurso"]."</td>";
            echo "<td>".$curso["idedificio"]."</td>";
            echo "<td>".$curso["num_aula"]."</td>";
            echo "<td>".$curso["dia"]."</td>";
            echo "<td>".$curso["asistentes"]."</td>";
        echo "</tr>";
    }
echo "</table>";