<?php 
    session_start();
    if(!isset($_SESSION["cliente"])) {
        header("Location: login.php");
        exit();
    }

    require_once "modelo.php";
    $conexion = conexion("restaurante", "root", "");
    if(!$conexion) {
        echo "Error de conexion a restaurante";
        exit();
    }

    $self = htmlentities($_SERVER["PHP_SELF"]);
    $cli = $_SESSION["cliente"];
    $arrPlatos = platos($conexion);

    if(isset($_GET["cerrar"])) {
        session_destroy();
        header("Location: login.php");
        exit();
    }

    $msg = "";
    if(isset($_GET["guardar"])) {
        foreach($_SESSION["pedido"] as $idplato => $cantidad) {
            $resultado = guardarPedido($conexion, $cli->dni, $idplato, $cantidad);
            $nombre = "";
            foreach($arrPlatos as $plato) {
                if($plato->idplato == $idplato) {
                    $nombre = $plato->nombre;
                    break;
                }
            }

            if($resultado) {
                if($cantidad == 1) {
                    $msg .= "<p>$cantidad unidad de $nombre pedida</p>";
                }
                else {
                    $msg .= "<p>$cantidad unidades de $nombre pedidas</p>";
                }   
            }
            else {
                if($cantidad == 1) {
                    $msg .= "<p>No se ha podido pedir $cantidad unidad de $nombre</p>";
                }
                else {
                    $msg .= "<p>No se han podido pedir $cantidad unidades de $nombre</p>";
                } 
            }
        }
        unset($_SESSION["pedido"]);
    }

    if(!isset($_SESSION["pedido"])) {
        $_SESSION["pedido"] = [];
    }

    if(isset($_GET["pedir"])) {
        $idplato = $_GET["plato"];
        $cant = 0;
        if(isset($_SESSION["pedido"][$idplato])) {
            $cant += $_SESSION["pedido"][$idplato];
        }
        $cant++;
        $_SESSION["pedido"][$idplato] = $cant;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        * {
            text-align: center;
        }
        table {
            display: inline-block;
        }
        tr, td, th {
            margin: 10px;
            padding: 5px;
        }
        i {
            font-size: 0.8em;
        }
        a {
            color: #014bd4;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <?php 
        
        echo "<h2>Inicidado sesión como: ".$cli->dni."</h2>";
        echo "<h3>Hola ".$cli->nombre."</h3>";
        if(!empty($cli->imagen)) {
            $img = $cli->imagen;
            echo "<img height=\"100\" width=\"100\" src='data:image/jpeg;base64,".base64_encode($img)."'>";
        }
        else {
            echo "<p>Sin imagen de perfil</p>";
        }

        echo "<p><a href=\"$self?cerrar\">CERRAR SESIÓN</a></p>";

        echo "<table>";
            $hayPedido = false;
            foreach ($arrPlatos as $plato) {
                echo "<tr>";
                    echo "<td>".$plato->nombre."</td>";
                    echo "<td>".number_format($plato->precio, 2)."€</td>";
                    echo "<td>".$plato->fecha."</td>";
                    if(!empty($plato->imagen)) {
                        echo "<td><img height=\"25\" width=\"25\" src=\"./imgs/".$plato->imagen."\"></td>";
                    }
                    else {
                        echo "<td><i>(Imagen no disponible)</i></td>";
                    }
                    echo "<td><a href=\"$self?pedir&plato=".$plato->idplato."\">PEDIR 1</a></td>";
                    if(isset($_SESSION["pedido"][$plato->idplato])){
                        echo "<td>".$_SESSION["pedido"][$plato->idplato]." en tu cesta</td>";
                        $hayPedido = true;
                    }
                echo "</tr>";
            }
            if($hayPedido) {
                echo "<tr><th colspan=\"6\"><a href=\"$self?guardar\">[GUARDAR PEDIDO]</a></th></tr>";
            }
            if($msg != "") {
                echo "<tr><th colspan=\"6\">$msg</th></tr>";
            }
        echo "</table>";
    ?>
</body>
</html>