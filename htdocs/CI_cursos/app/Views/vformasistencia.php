<?php

echo $mensaje??"";

echo form_open(site_url()."/newasistente");
    echo form_label("DNI");
    echo form_input("dni");
    echo "<br>";
    echo form_label("Nombre");
    echo form_input("nombre");
    echo "<br>";
    echo form_label("Telefono");
    echo form_input("telefono");
    echo "<br>";
    echo form_submit("submitNuevoAsistente", "AÑADIR");
echo form_close();