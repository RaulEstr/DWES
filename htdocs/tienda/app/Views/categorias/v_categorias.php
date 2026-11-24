<?php

/**
 * @var array $categorias // Array de objetos MCategorias
    // id (int), nombre (string), comision (float) 
**/

if(count($categorias) == 0) {
    echo "<h2>NO HAY CATEGORIAS</h2>";
}
else {
    echo "<table>";
        echo "<tr><th>ID</th><th>NOMBRE</th><th>COMISIÓN</th><th></th></tr>";
        foreach($categorias as $categoria) {
            echo "<tr>";
                echo "<td>$categoria->id</td>";
                echo "<td>$categoria->nombre</td>";
                echo "<td>$categoria->comision%</td>";
                echo "<td>".anchor("/categorias/borrar/$categoria->id", "BORRAR")."</td>";
                echo "<td>".anchor("/categorias/actualizar/$categoria->id", "ACTUALIZAR")."</td>";
            echo "</tr>";
        }
    echo "</table>";
}

echo "<h3>".anchor("/categorias/nuevo", "AÑADIR CATEGORIA")."</h3>";