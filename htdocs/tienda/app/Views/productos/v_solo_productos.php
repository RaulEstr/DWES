<?php

/**
 * @var array $productos // Array de objetos MProductos
 // (int) id, (string) nombre, (float) precio, (int) stock, (string) categoria 
**/

echo "<table>";
if(count($productos) == 0) {
    echo "<h2>No hay productos</h2>";
}
else {
    echo "<tr><th>ID</th><th>NOMBRE</th><th>PRECIO</th><th>STOCK</th></tr>";
    foreach($productos as $producto) {
        echo "<tr>";
            echo "<td>$producto->id</td>";
            echo "<td>$producto->nombre</td>";
            echo "<td>".$producto->precio."€</td>";
            echo "<td>$producto->stock</td>";
        echo "</tr>";
    }
}
echo "</table>";