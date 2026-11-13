<?php

/**
 * @var array $cursos // Array de objetos: idcurso, dia, tema, categoria, precio
 * @var array $asistencia // id, dni, idcurso, estado, nombre, telefono
 * @var int $idcursosel
**/
echo "<h2>TODOS LOS CURSOS</h2>";
echo "<table>";
echo "<tr><th>ID</th><th>DIA</th><th>CATEGORIA</th><th>TEMA</th><th>PRECIO</th><th>ASISTENCIA</th></tr>";
    foreach($cursos as $curso) {
        echo "<tr>";
            echo "<td>$curso->idcurso</td>";
            echo "<td>$curso->dia</td>";
            echo "<td>$curso->categoria</td>";
            echo "<td>$curso->tema</td>";
            echo "<td>$curso->precio €</td>";
            echo "<td>";
            if(isset($idcursosel) && $idcursosel == $curso->idcurso) {
                if(count($asistencia) == 0) {
                    echo "<p>Sin asistentes</p>";
                }
                else {
                    echo "<table>";
                        echo "<tr><th>DNI</th><th>NOMBRE</th><th>TELEFONO</th></tr>";
                        foreach($asistencia as $asis) {
                            echo "<tr>";
                                echo "<td>$asis->dni</td>";
                                echo "<td>$asis->nombre</td>";
                                echo "<td>$asis->telefono</td>";
                            echo "</tr>";
                        }
                    echo "</table>";
                }   
            }
            else{
                $enlace = site_url()."/detalleasistencia/".$curso->idcurso;
                echo anchor($enlace ,"VER ASISTENTES");
            }     
            echo "</td>";
        echo "</tr>";
    }
echo "</table>";
