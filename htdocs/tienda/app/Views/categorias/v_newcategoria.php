<?php

echo "<h2>CREAR NUEVA CATEGORIA</h2>";
echo form_open("/categorias/nuevo");
    echo "<table>";
        echo "<tr>";
            echo "<td>".form_label("NOMBRE: ")."</td>";
            echo "<td>".form_input("nombre")."</td>";
        echo "</tr>";
        echo "<tr>";
            echo "<td>".form_label("COMISIÓN: ")."</td>";
            echo "<td>".form_input(["type"=>"number", "name"=>"comision", "min"=>"0", "step"=>"0.01"])."</td>";
        echo "</tr>";
        echo "<tr><td colspan=\"2\">".form_submit("submitCategoria", "CREAR CATEGORIA")."</td></tr>";
    echo "</table>";
echo form_close();