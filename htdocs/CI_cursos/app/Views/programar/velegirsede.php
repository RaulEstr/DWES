<?php

/**
 * @var array $edificios // Array de objetos: idedificio, nombre
 * @var string $error
**/

if(isset($error)) {
    echo "<p class=\"red\">$error</p>";
}

echo "<h2>Elige sede del nuevo curso</h2>";

echo form_open(site_url()."/programar");
echo form_fieldset("Elige edificio");
foreach($edificios as $edificio) {
    echo form_radio("idedificio", $edificio->idedificio, false);
    echo form_label($edificio->nombre);
    echo "<br>";
}
echo "<br>";
echo form_submit("submitSede", "CONTINUAR");
echo form_fieldset_close();
echo form_close();