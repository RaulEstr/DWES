<?php

/**
 * @var object $producto // Objeto MProductos
 // (int) id, (string) nombre, (float) precio, (int) stock, (string) categoria 
**/

echo "<h2>ACTUALIZANDO PRODUCTO</h2>";
echo form_open("");
    echo "<table>";
        echo "<tr>";
            echo "<td>".form_label("Categoria")."</td>";
            echo "<td>".form_dropdown("categoria", $categorias, $producto->categoria)."</td>";
        echo "</tr>";
        echo "<tr>";
            echo "<td>".form_label("Nombre")."</td>";
            echo "<td>".form_input("nombre", $producto->nombre)."</td>";
        echo "</tr>";
        echo "<tr>";
            echo "<td>".form_label("Precio")."</td>";
            echo "<td>".form_input(["type"=>"number", "name"=>"precio", "min"=>"0", "step"=>"0.01", "value"=>"$producto->precio"])."</td>";
        echo "</tr>";
        echo "<tr>";
            echo "<td>".form_label("Stock")."</td>";
            echo "<td>".form_input(["type"=>"number", "name"=>"stock", "min"=>"0", "step"=>"0.01", "value"=>"$producto->stock"])."</td>";
        echo "</tr>";
        echo "<tr><td colspan=\"2\">".form_submit("updateProducto", "ACTUALIZAR PRODUCTO")."</td></tr>";
    echo "</table>";
echo form_close();