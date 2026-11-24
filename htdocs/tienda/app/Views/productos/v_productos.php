<?php

/**
 * @var array $productos // Array de MProductos
 // (int) prodId, (string) prodNom, (float) precio, (int) stock, (string) categoria 
**/

if(count($productos) == 0) {
    echo "<h2>No hay productos</h2>";
}
else {
    echo "<table>";
    echo "<tr><th>ID</th><th>NOMBRE</th><th>PRECIO</th><th>STOCK</th><th>CATEGORIA</th></tr>";
    foreach($productos as $producto) {
        echo "<tr>";
            echo "<td>$producto->prodId</td>";
            echo "<td>$producto->prodNom</td>";
            echo "<td>".$producto->precio."€</td>";
            echo "<td>$producto->stock</td>";
            echo "<td>$producto->categoria</td>";
        echo "</tr>";
    }
    echo "</table>";
}