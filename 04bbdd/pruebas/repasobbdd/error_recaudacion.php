<?php
    require_once __DIR__."/header.php";

    if(isset($_POST["submit"])) {
        grabarIncidencia($conexion, $_POST["idfuncion"], $_POST["exceso"], $_POST["gestor"]);
    }

    echo "<h2>FUNCIONES CON RECAUDACION ERRONEA</h2>";
    $funciones = funcionesErrorRecaudacion($conexion);
    echo "<table>";
        echo "<tr><th>ID</th><th>ID CINE</th><th>SALA</th><th>ID PELI</th><th>RECAUDACION</th><th>PRECIO ENTRADA</th><th>VENDIDOS</th><th>RECAUDACION ESPERADA</th><th>EXCESO</th><th>GESTOR</th><th></th></tr>";
        foreach($funciones as $funcion) {
            echo "<form action=\"".self()."\" method=\"post\">";
                $exceso = $funcion -> recaudacion - ($funcion -> precio_entrada * $funcion -> vendidos);
                echo "<input type=\"hidden\" name=\"idfuncion\" value=\"$funcion->idfuncion\">";
                echo "<tr>";
                    echo "<td>$funcion->idfuncion</td>";
                    echo "<td>$funcion->idcine</td>";
                    echo "<td>$funcion->num_sala</td>";
                    echo "<td>$funcion->idpelicula</td>";
                    echo "<td>$funcion->recaudacion €</td>";
                    echo "<td>$funcion->precio_entrada €</td>";
                    echo "<td>$funcion->vendidos</td>";
                    echo "<td>".($funcion->precio_entrada * $funcion->vendidos)."</td>";
                    echo "<td><input size=\"5\" type=\"text\" name=\"exceso\" value=\"$exceso\" readonly></td>";
                    echo "<td><input size=\"8\" type=\"text\" name=\"gestor\" required></td>";
                    echo "<td><input style=\"height: 50px\" type=\"submit\" name=\"submit\" value=\"GRABAR INDICENCIA\"></td>"; 
                echo "</tr>";
            echo "</form>";
        }
    echo "</table>";
    require_once __DIR__."/foot.php";
?>