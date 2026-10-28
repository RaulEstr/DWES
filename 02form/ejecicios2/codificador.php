<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        table,tr,td {
            border: 1px solid black;
            border-collapse: collapse;
            margin: 5px;
            padding: 5px;
        }
        textarea {
            width: 300px;
        }
        select {
            width: 100px;
        }
    </style>

    <?php 
    
    const TAMANIOS = [2,4,6,8,10];
    const CARPETA = "diccionarios/";
    $textoOriginal = "";
    $tamanioSeleccionado = "";
    $resultado = "";
    $fichSeleccionado = "";

    function leerDir($dir) {
        $fichs = [];
        $fichs = scandir($dir);
        return $fichs;
    }

    function codificarPorBloque($texto, $cant) {
        $i = 0;
        $arrTexto = [];
        while($i < strlen($texto)) {
            $arrTexto[] = substr($texto, $i, $cant);
            $i += $cant;
        }

        for($i = 0; $i < count($arrTexto); $i++) {
            $arrTexto[$i] = strrev($arrTexto[$i]);
        }

        return implode("", $arrTexto);
    }

    function codificarPorDiccionario($texto, $diccionario) {
        $f = fopen($diccionario, "r");
            if($f) {
                $letras = [];
                while (!feof($f)) {
                    $linea = trim(fgets($f));
                    $partes = explode("=", $linea);
                    $letras[$partes[0]] = $partes[1];
                }
                fclose($f);

                $nuevoTexto = "";
                $i = 0;
                while($i < strlen($texto)) {
                    if(array_key_exists($texto[$i], $letras)) {
                        $nuevoTexto .= $letras[$texto[$i]];
                    }
                    else {
                        $nuevoTexto .= $texto[$i];
                    }
                    $i++;
                }
                return $nuevoTexto;
            }
            else {
                return "ERROR: El diccionario no existe";
            }
    }

    if(isset($_POST["codificarBloques"])) {
        $tamanio = $_POST["tamanio"];
        $tamanioSeleccionado = $tamanio;

        $texto = $_POST["frase"];
        if(trim($texto) == "") {
            $resultado = "ERROR: No has introducido ningún texto";
        }
        else {
            $textoOriginal = $texto;
            $textoCodificado = codificarPorBloque($texto, $tamanio);
            $resultado = $textoCodificado;
        }
    }

    if(isset($_POST["codificarDiccionario"])) {
        $texto = $_POST["frase"];
        $hayTexto = true;
        $hayFich = true;

        if(trim($texto) == "") {
            $hayTexto = false;
        }
        if(!isset($_POST["diccionario"]))  {
            $hayFich = false;
        }

        if($hayTexto && $hayFich) {
            $fich = $_POST["diccionario"];
            $fichSeleccionado = $fich;
            $textoOriginal = $texto;
            $resultado = codificarPorDiccionario($texto, $fich);
        }

        if($hayTexto && !$hayFich) {
            $resultado = "ERROR: No has seleccionado ningún diccionario";
            $textoOriginal = $texto;
        }

        if(!$hayTexto && $hayFich) {
            $resultado = "ERROR: No has introducido ningún texto";
            $fich = $_POST["diccionario"];
            $fichSeleccionado = $fich;
        }

        if(!$hayTexto && !$hayFich) {
            $resultado = "ERROR: No has introducido ningún texto ni seleccionado diccionario";
        }
    }

    ?>
</head>
<body>
    <form method="POST">
        <table>
            <tr>
                <td><label>Frase: </label></td>
                <td colspan="2"><textarea name="frase" placeholder="Escribe el texto aquí..."><?php echo $textoOriginal ?></textarea></td>
            </tr>
            <tr>
                <td><label>Tamaño del bloque: </label></td>
                <td>
                    <select name="tamanio">

                    <?php 
                    
                    foreach(TAMANIOS as $tamanio) {
                        if($tamanio == $tamanioSeleccionado) {
                            echo "<option selected=\"selected\" value=\"$tamanio\">$tamanio</option>";
                        }
                        else {
                            echo "<option value=\"$tamanio\">$tamanio</option>";
                        }
                    }
                    
                    ?>

                    </select>
                </td>
                <td><input type="submit" name="codificarBloques" value="Codificar por Bloques."></td>
            </tr>
            <tr>
                <td><label>Fichero Dicionario: </label></td>
                <td>
                    <?php 
                    
                    $dics = leerDir(CARPETA);
                    foreach($dics as $dic) {
                        $tipo = mime_content_type(CARPETA.$dic);
                        if($tipo == "text/plain") {
                            if(CARPETA.$dic == $fichSeleccionado) {                               
                                echo "<input checked=\"checked\" type=\"radio\" name=\"diccionario\" value=\"".CARPETA.$dic."\">$dic";
                            }
                            else {
                                echo "<input type=\"radio\" name=\"diccionario\" value=\"".CARPETA.$dic."\">$dic";
                            }
                           
                            echo "<br>";
                        }
                    }

                    ?>
                </td>
                <td>
                    <input type="submit" name="codificarDiccionario" value="Codificar por Diccionario">
                </td>
            </tr>
            <tr>
                <td><label>Resultado / Estado</label></td>
                <td colspan=2>
                    <input type="text" size=70 name="resultado" placeholder="Esperando acción" value="<?php echo $resultado ?>" disabled>
                </td>
            </tr>
        </table>
    </form>    
</body>
</html>