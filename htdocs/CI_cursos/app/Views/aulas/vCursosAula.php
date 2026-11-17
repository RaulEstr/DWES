<?php

/**
 * @var array $cursos 
 * @var string $error
**/

if(count($cursos) == 0) {
    echo "<p class=\"red\">No hay cursos es este aula</p>";
}
else {
    echo "<p><strong>Aula ".$cursos[0]->num_aula." - Cursos impartidos</strong></p>";
    if(isset($error)) {
        echo "<p class=\"red\">$error</p>";
    }
    echo "<table>";
    foreach($cursos as $curso) {
        echo "<tr>";
        echo form_open(site_url()."/Edificio/$curso->idedificio/$curso->num_aula");
            echo form_hidden("idtema", $curso->idtema);
            echo form_hidden("idcurso", $curso->idcurso);
            echo "<td>".form_input("tema", $curso->tema)."</td>";
            echo "<td>".form_input(["name"=>"dia", "type"=>"date","value"=>$curso->dia])."</td>";
            echo "<td>".form_input(["name"=>"asistentes", "type"=>"number","value"=>$curso->asistentes])." asistentes</td>";
            echo "<td>".form_input(["name"=>"precio", "type"=>"number", "min"=>"0", "step"=>"0.01", "value"=>$curso->precio])."€</td>";
            echo "<td>".form_submit("submitCambio", "CAMBIAR")."</td>";
        echo form_close();
        echo "</tr>";
    }
    echo "</table>";
}
