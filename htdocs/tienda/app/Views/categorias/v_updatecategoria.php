<?php

/**
 * @var object $categoria
    // Objecto MCategoria (int) id, (string) nombre, (float) comision 
**/

echo "<h2>ACTUALIZANDO CATEGORIA</h2>";
echo form_open("");
    echo "<table>";
        echo "<tr>";
            echo "<td>".form_label("NOMBRE: ")."</td>";
            echo "<td>".form_input("nombre", $categoria->nombre)."</td>";
        echo "</tr>";
        echo "<tr>";
            echo "<td>".form_label("COMISIÓN: ")."</td>";
            echo "<td>".form_input(["type"=>"number", "name"=>"comision", "min"=>"0", "step"=>"0.01", "value"=>"$categoria->comision"])."</td>";
        echo "</tr>";
        echo "<tr><td colspan=\"2\">".form_submit("updateCategoria", "ACTUALIZAR CATEGORIA")."</td></tr>";
    echo "</table>";
echo form_close();