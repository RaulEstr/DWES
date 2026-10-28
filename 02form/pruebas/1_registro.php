<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <?php 
    
    function registrarEnFichero($nombre, $sexo, $ciclo, $condiciones) {
        $f = fopen("registros/alumnos.txt", "a");

        $linea = 
        $nombre
        .", "
        .(($sexo=="H")?"Hombre":"Mujer")
        .", "
        .$ciclo
        .", condiciones: "
        .implode(", ", $condiciones);

        fputs($f, $linea."\n");
        fclose($f);
    }

    $esp = ["Dislexia", "TDAH", "Diabetes", "Mal de ojo", "Ninguna"];

    $errorNombre = "";
    $errorSexo = "";
    $errorCond = "";

    $nombre = "";

    $sexoH = "";
    $sexoM = "";

    $cicloDW = "";
    $cicloDM = "";
    $cicloAF = "";

    $condicionesSeleccionadas = [];

    $correcto = true;
    if (isset($_POST["submit"])) {
        if(empty($_POST["nombre"])) {
            $errorNombre = "* Tienes que introducir un nombre";
            $corredo = false;
        }
        else{
            $nombre = $_POST["nombre"];
        }

        if(!isset($_POST["sexo"])) {
            $errorSexo = "* Tienes que seleccionar un sexo";
            $correcto = false;
        }
        else {
            if($_POST["sexo"] == "M") {
                $sexoM = "checked";
                $sexoH = "";
            }
            else{
                $sexoM = "";
                $sexoH = "checked";
            }
        }

        $cicloDW = ($_POST["ciclo"] == "DW") ? "selected":"";
        $cicloDM = ($_POST["ciclo"] == "DM") ? "selected":"";
        $cicloAF = ($_POST["ciclo"] == "AF") ? "selected":"";      

        if(!isset($_POST["cond"])) {
            $errorCond = "* Teienes que seleccionar al menos una condición";
            $correcto = false;
        }
        else {
            $condicionesSeleccionadas = $_POST["cond"];
        }

        if($correcto) {
            registrarEnFichero($_POST["nombre"], $_POST["sexo"], $_POST["ciclo"], $_POST["cond"]);
        }
    }

    

    ?>

</head>
<body>
    <form method='POST' action='registro.php'>
        <table>
            <tr>
                <td><label>Nombre</label></td>
                <td><input type="text" name="nombre" value="<?php echo $nombre ?>"></td>
                <td class="error"><?php echo $errorNombre ?></td>
            </tr>
            <tr>
                <td><label>Sexo</label></td>
                <td>
                    <input type="radio" name="sexo" value="H" <?php echo $sexoH ?>>Hombre
                    <input type="radio" name="sexo" value="M" <?php echo $sexoM ?>>Mujer
                </td>
                <td class="error"><?php echo $errorSexo ?></td>
            </tr>
            <tr>
                <td><label>Ciclo</label></td>
                <td>
                    <select name="ciclo">
                        <option value="DW" <?php echo $cicloDW ?>>Desarrollo de Aplicaciones Web</option>
                        <option value="DM" <?php echo $cicloDM ?>>Desarrollo de Aplicaciones Multiplataforma</option>
                        <option value="AF" <?php echo $cicloAF ?>>Administración y Finanzas</option>
                    </select>
                </td>
                
            </tr>
            <tr>
                <td><label>Condiciones</label></td>
                
                <td>
                    <?php 
                    
                    foreach($esp as $cond) {
                        $checkeado = "";
                        if(in_array($cond, $condicionesSeleccionadas)) {
                            $checkeado = "checked";
                        }
                        echo "<input type=\"checkbox\" name=\"cond[]\" value=\"$cond\" $checkeado>"; 
                        echo $cond;
                    }
                    
                    ?>
                </td>
                <td class="error"><?php echo $errorCond ?></td>
            </tr>
            <tr>
                <td><input type="submit" name="submit" value="Registrar"></td>
            </tr>
        </table>
    </form>
</body>
<style>
    .error{
        color:red;
    }
</style>
</html>