<?php

/**
 * @var array $productos // Array de MProductos
 // (int) id, (string) nombre, (float) precio, (int) stock, (string) categoria 
**/

echo "<table>";
if(count($productos) == 0) {
    echo "<h2>No hay productos</h2>";
}
else {
    echo "<tr><th>ID</th><th>NOMBRE</th><th>PRECIO</th><th>STOCK</th><th>CATEGORIA</th></tr>";
    foreach($productos as $producto) {
        echo "<tr>";
            echo "<td>$producto->id</td>";
            echo "<td>$producto->nombre</td>";
            echo "<td>".$producto->precio."€</td>";
            echo "<td>$producto->stock</td>";
            echo "<td>$producto->categoria</td>";
            echo "<td>".anchor("/productos/borrar/$producto->id", "BORRAR")."</td>";
            echo "<td>".anchor("/productos/actualizar/$producto->id", "ACTUALIZAR")."</td>";
        echo "</tr>";
    }
}
echo "<tr>";
    echo "<td colspan=\"6\">".anchor("/productos/nuevo", "AÑADIR PRODUCTO")."</td>";
echo "<tr>";
echo "</table>";