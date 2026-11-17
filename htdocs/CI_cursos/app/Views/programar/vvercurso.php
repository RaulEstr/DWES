<?php

/**
 * @var object $curso // idcurso, idedificio, num_aula, dia, idtema, asistentes, precio
**/

echo "<ul>";
    echo "<li>ID: $curso->idcurso</li>";
    echo "<li>ID_Edificio: $curso->idedificio</li>";
    echo "<li>Aula: $curso->num_aula</li>";
    echo "<li>Dia: $curso->dia</li>";
    echo "<li>ID_Tema: $curso->idtema</li>";
    echo "<li>Asistentes: $curso->asistentes</li>";
    echo "<li>Precio: $curso->precio €</li>";
echo "</ul>";