<?php

/**
 * @var array $aulas // Array de objetos: idedificio, numero, capacidad
 * @var array $temas // Array de objectos: idtema, tema, categoria
 * @var object $edificio // Objeto: idedificio, nombre
**/

$opAulas = [""=>"Elige aula"];
foreach($aulas as $aula) {
    $opAulas[$aula->numero] = "Aula nº$aula->numero ($aula->capacidad de capacidad)";
}

$opTemas = [""=>"Elige tema"];
foreach($temas as $tema) {
    $opTemas[$tema->idtema] = "$tema->tema ($tema->categoria)";
}

echo "<h2>Creando nuevo curso en edificio $edificio->nombre</h2>";

echo form_open(site_url()."/programar/$edificio->idedificio");
echo form_fieldset("Datos generales");

echo form_label("Elige aula: ");
echo form_dropdown("num_aula", $opAulas);
echo "<br>";
echo form_label("Elige tema: ");
echo form_dropdown("tema", $opTemas);

echo form_fieldset_close();
echo form_fieldset("Datos extra");

echo form_label("Elige día: ");
echo form_input(["name"=>"dia", "type"=>"date"]);

echo form_label("Elige precio: ");
echo form_input(["name"=>"precio", "type"=>"number", "min"=>"0", "step"=>"0.01"]);

echo form_fieldset_close();

echo form_submit("submitNuevoCurso", "AÑADIR CURSO");
echo form_close();