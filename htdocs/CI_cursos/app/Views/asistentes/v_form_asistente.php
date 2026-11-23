<?php

/**
 * @var object $asistente // dni, nombre, telefono 
 * @var array $cursos // Array de objetos de curso -> temas.tema, cursos.dia
**/

echo "<h2>$asistente->nombre</h2>";

echo form_open(site_url()."/Asistente/$asistente->dni");
echo "<table>";
    echo "<tr><th>DNI</th><th>Nombre</th><th>Telefono</th><th>Apuntado a</th></tr>";
        echo form_hidden("dni", $asistente->dni);
        echo "<td>".form_label($asistente->dni)."</td>";
        echo "<td>".form_input("nombre",$asistente->nombre)."</td>";
        echo "<td>".form_input("telefono", $asistente->telefono)."</td>";
        echo "<td>";
        if(count($cursos) == 0) {
            echo "No está apuntado a ningún curso";
        }
        else {
            foreach($cursos as $curso) {
                echo form_checkbox("cursos[]", $curso->idcurso, TRUE);
                echo form_label($curso->tema."(".$curso->dia.")");
                echo "<br>";
            }
        }
        echo "</td>";
        echo "<td>".form_submit("submitActualizar", "ACTUALIZAR")."</td>";
echo "</table>";
echo form_close();