<?php

/**
 * @var array $categorias // Array asociativo
    // id => nombre
**/

echo "<h2>INSERTA NUEVO PRODUCTO</h2>";

echo "<table>";
    echo form_open("/productos/nuevo");
        echo "<tr>";
            echo "<td>".form_label("Categoria")."</td>";
            echo "<td>".form_dropdown("categoria", $categorias)."</td>";
        echo "</tr>";
        echo "<tr>";
            echo "<td>".form_label("Nombre")."</td>";
            echo "<td>".form_input("nombre")."</td>";
        echo "</tr>";
        echo "<tr>";
            echo "<td>".form_label("Precio")."</td>";
            echo "<td>".form_input(["type"=>"number", "name"=>"precio", "min"=>"0", "step"=>"0.01"])."</td>";
        echo "</tr>";
        echo "<tr>";
            echo "<td>".form_label("Stock")."</td>";
            echo "<td>".form_input(["type"=>"number", "name"=>"stock", "min"=>"0", "step"=>"0.01"])."</td>";
        echo "</tr>";
        echo "<tr><td colspan=\"2\">".form_submit("submitProducto", "CREAR PRODUCTO")."</td></tr>";
    echo form_close();
echo "</table>";
