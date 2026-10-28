<?php
    require_once __DIR__."/header.php";

    if(isset($_POST["submit"])) {
        if(!empty($_POST["fanular"])) {
            borrarFunciones($conexion, $_POST["fanular"]);
        }
    }

    echo "<h2>FUNCIONES CON EXCESO DE VENTAS</h2>";
    $funciones = funcionesErrorVentas($conexion);
    
    echo "<form action=\"".self()."\" method=\"post\">";
        echo "<table>";
            echo "<tr><th>ID</th><th>ID CINE</th><th>SALA</th><th>FECHA</th><th>RECAUDACION</th><th>VENDIDOS</th><th>CAPACIDAD</th><th></th></tr>";
            foreach($funciones as $funcion) {
                echo "<tr>";
                    echo "<td>$funcion->idfuncion</td>";
                    echo "<td>$funcion->idcine</td>";
                    echo "<td>$funcion->num_sala</td>";
                    echo "<td>$funcion->fecha_hora</td>";
                    echo "<td>$funcion->recaudacion</td>";
                    echo "<td>$funcion->vendidos</td>";
                    echo "<td>$funcion->capacidad</td>";
                    if(new DateTime(($funcion->fecha_hora)) > new DateTime()) {
                        echo "<td><input type=\"checkbox\" name=\"fanular[]\" value=\"$funcion->idfuncion\"></td>";
                    }
                echo "</tr>";
            }
            echo "<tr><td colspan=\"8\"><input style=\"width: 100%; height: 50px\" type=\"submit\" name=\"submit\" value=\"BORRAR MARCADAS\"></td></tr>";
        echo "</table>";
    echo "</form>";

    require_once __DIR__."/foot.php";
?>