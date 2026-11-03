<?php
    require_once __DIR__."/header.php";
    $self = htmlentities($_SERVER["PHP_SELF"]);

    $msg = "";
    if(isset($_POST["enviar"])) {
        if(trim($_POST["nombre"]) == "") {
            $msg .= "<p>El item tiene que tener nombre</p>";
        }

        if(trim($_POST["descripcion"]) == "") {
            $msg .= "<p>El item tiene que tener descripcion</p>";
        }

        if($_POST["precio"] == "") {
            $msg .= "<p>El precio no puede estar vacio</p>";
        }

        if($msg == "") {
            $anio = $_POST["anio"];
            $mes = $_POST["mes"];
            $dia = $_POST["dia"];
            $hora = $_POST["hora"];
            $min = $_POST["minuto"];
            $itemId = aniadirItem($conexion, $_POST["categoria"], $_SESSION["logedUserId"], $_POST["nombre"], $_POST["precio"], $_POST["descripcion"], "$anio-$mes-$dia $hora:$min");
            if($itemId != 0) {
                header("Location: editaritem.php?itemid=$itemId");
                exit();
            }
            else {
                $msg .= "<p>No se ha podido añadir el item</p>";
            }
        }


    }

    $categorias = categorias($conexion);

    if($msg != "") {
        echo $msg;
    }
    echo "<form method=\"post\" action\"$self\">";
        echo "<table>";
            echo "<tr>";
                echo "<td>Categoría</td>";
                echo "<td><select name=\"categoria\">";
                    foreach($categorias as $categoria) {
                        echo "<option value=\"".$categoria["id"]."\">".$categoria["categoria"]."</option>";
                    }
                echo "</select></td>";
            echo "</tr>";
            echo "<tr>";
                echo "<td>Nombre</td>";
                echo "<td><input type=\"text\" name=\"nombre\"></td>";
            echo "</tr>";
            echo "<tr>";
                echo "<td>Descripción</td>";
                echo "<td><textarea name=\"descripcion\" cols=\"30\" rows=\"10\"></textarea></td>";
            echo "</tr>";
            echo "<tr>";
                echo "<td>Fecha de fin para pujas</td>";
                echo "<td>";
                    echo "<table>";
                        echo "<tr>";
                            echo "<td>Día</td><td>Mes</td><td>Año</td><td>Hora</td><td>Minutos</td>";
                        echo "</tr>";
                        echo "<tr>";
                            $ahora = new DateTime();
                            $dia = $ahora->format("d") + 20;
                            $mes = $ahora->format("m");
                            $anio = $ahora->format("Y");
                            $hora = $ahora->format("H");
                            $min = $ahora->format("i");
                            if($dia > 31) {
                                $dia = $dia - 31;
                                $mes = $mes + 1;
                                if($mes > 12) {
                                    $mes = $mes - 12;
                                    $anio = $anio + 1;
                                }
                            }
                            
                            echo "<td><select name=\"dia\">";
                                for($i = 1; $i <= 31; $i++) {
                                    if($i == $dia) {
                                        echo "<option selected value=\"$i\">$i</option>";
                                    }
                                    else {
                                        echo "<option value=\"$i\">$i</option>";
                                    }         
                                }
                            echo "</select></td>";
                            echo "<td><select name=\"mes\">";
                                for($i = 1; $i <= 12; $i++) {
                                    if($i == $mes) {
                                        echo "<option selected value=\"$i\">$i</option>";
                                    }
                                    else {
                                        echo "<option value=\"$i\">$i</option>";
                                    } 
                                }
                            echo "</select></td>";
                            echo "<td><select name=\"anio\">";
                                for($i = $anio; $i <= $anio + 5; $i++) {
                                    if($i == $mes) {
                                        echo "<option selected value=\"$i\">$i</option>";
                                    }
                                    else {
                                        echo "<option value=\"$i\">$i</option>";
                                    }                                   
                                }
                            echo "</select></td>";
                            echo "<td><select name=\"hora\">";
                                for($i = 0; $i <= 23; $i++) {
                                    if($i == $hora) {
                                        echo "<option selected value=\"$i\">$i</option>";
                                    }
                                    else {
                                        echo "<option value=\"$i\">$i</option>";
                                    }                                  
                                }
                            echo "</select></td>";
                            echo "<td><select name=\"minuto\">";                                
                                for($i = 0; $i <= 59; $i++) {
                                    if($i == $min) {
                                        echo "<option selected value=\"$i\">$i</option>";                                    
                                    }
                                    else {
                                        echo "<option value=\"$i\">$i</option>";
                                    }                                    
                                }
                            echo "</select></td>";
                        echo "</tr>";
                    echo "</table>";
                echo "</td>";
            echo "</tr>";
            echo "<tr>";
                echo "<td>Precio</td>";
                echo "<td><input type=\"number\" name=\"precio\">€</td>";
            echo "</tr>";
            echo "<tr>";
                echo "<td colspan=\"2\"><input style=\"width:100%\" type=\"submit\" name=\"enviar\" value=\"Enviar!\"></td>";
            echo "</tr>";
        echo "</table>";
    echo "</form>";

    require_once __DIR__."/foot.php";
?>