<?php
    require_once "modelo.php";
    $self = htmlentities($_SERVER["PHP_SELF"]);
    $conexion = conexion("restaurante", "root", "");
    if(!$conexion) {
        echo "Error de conexion a restaurante";
        exit();
    }

    $cocineros = cocineros($conexion);
    $idplato = null;
    $msg = "";
    if(isset($_POST["guardar"])) {
        $idplato = $_POST["plato"];
        if($_POST["precio"] < $_POST["precioOG"] / 2) {
            $msg .= "<p>El precio del plato no puede bajas más de un 50%</p>";
        }
        if(!isset($_POST["cocineros"])) {
            $msg .= "<p>Debe haber al menos un cocinero que cocine el plato</p>";
        }
        if(trim($_POST["nombre"]) == "") {
            $msg .= "<p>El nombre del plato no puede estar en blanco</p>";
        }

        if($msg == "") {
            if($_POST["precio"] != $_POST["precioOG"]) {
                actualizarPrecioPlato($conexion, $_POST["precio"], $_POST["plato"]);
                $msg .= "<p>Se ha actualizao el precio del plato (".$_POST["precioOG"]."€ -> ".$_POST["precio"]."€)</p>";
            }
            if($_POST["nombre"] != $_POST["nombreOG"]) {
                actualizarNombrePlato($conexion, $_POST["nombre"], $_POST["plato"]);
                $msg .= "<p>Se ha actualizao el nombre del plato (".$_POST["nombreOG"]." -> ".$_POST["nombre"].")</p>";
            }
            foreach($cocineros as $cocinero) {
                $esta = false;
                foreach($_POST["cocineros"] as $id) {
                    if($id == $cocinero->id) {
                        $esta = true;
                        if(!existeElaboracion($conexion, $idplato, $cocinero->id)) {
                            aniadirElaboracion($conexion, $idplato, $cocinero->id);
                            $msg .= "<p>Se ha añadido ".$cocinero->nombre." como cocinero que elabora el plato</p>";
                        }
                    }
                }
                if(!$esta) {
                    if(existeElaboracion($conexion, $idplato, $cocinero->id))  {
                        eliminarElaboracion($conexion, $idplato, $cocinero->id);
                        $msg .= "<p>Se ha eliminado ".$cocinero->nombre." como cocinero que elabora el plato</p>";
                    }
                }
            }
        }
    }

    if($msg == "") {
        $msg = "<p>No se ha realizado ningun cambio</p>";
    }

    if(isset($_POST["submit"])) {
        if(isset($_POST["plato"])) {
            $idplato = $_POST["plato"];
        }
    }

    if($idplato == null) {
        header("Location: sin_pedidos.php");
        exit();
    }

    $plato = platoPorId($conexion, $idplato)[0];
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php 
        echo "<h2>Modificar plato</h2>";
        echo "<form method=\"post\" action=\"$self\">";
            echo "<table>";
                echo "<input type=\"hidden\" name=\"precioOG\" value=\"".$plato->precio."\">";
                echo "<input type=\"hidden\" name=\"plato\" value=\"".$plato->idplato."\">";
                echo "<input type=\"hidden\" name=\"nombreOG\" value=\"".$plato->nombre."\">";
                echo "<tr><td>Nombre del Plato</td></tr>";
                echo "<tr><td><input type=\"text\" name=\"nombre\" value=\"".$plato->nombre."\"></td></tr>";
                echo "<tr><td>Precio (€)</td></tr>";
                echo "<tr><td><input type=\"number\" name=\"precio\" value=\"".$plato->precio."\"></td></tr>";

                echo "<tr><th>Cocineros que elaboran este plato</th></tr>";
                foreach($cocineros as $cocinero) {
                    echo "<tr><td>";
                    if(cocineroElaboraPlato($conexion, $idplato, $cocinero->id)) {
                        echo "<input checked type=\"checkbox\" name=\"cocineros[]\" value=\"".$cocinero->id."\">".$cocinero->nombre;
                    }
                    else {
                        echo "<input type=\"checkbox\" name=\"cocineros[]\" value=\"".$cocinero->id."\">".$cocinero->nombre;
                    }
                    echo "</td></tr>";
                }
                echo "<tr><td><input type=\"submit\" name=\"guardar\" value=\"Guardar Cambios\"></td></tr>";
                if($msg != "") {
                    echo "<tr><td>$msg</td></tr>";
                }
                echo "<tr><td><a href=\"sin_pedidos.php\">Volver</a></td></tr>";
            echo "</table>";
        echo "</form>";
    ?>
</body>
</html>