<?php
    require_once "modelo.php";
    $conexion = conexion("restaurante", "root", "");
    if(!$conexion) {
        echo "Error de conexion a restaurante";
        exit();
    }

    $self = htmlentities($_SERVER["PHP_SELF"]);

    $platosMasPedidos = platosMasPedidos($conexion);

    $id = null;
    $pedidosDePlato = null;
    if(isset($_GET["id"])) {
        $id = $_GET["id"];   
        $pedidosDePlato = pedidosDePlato($conexion, $id);    
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
        a {
            color: #014bd4;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <?php 
    
        echo "<table>";
            echo "<tr><th>NOMBRE</th><th>PRECIO</th><th>PEDIDOS TOTALES</th><th>CANTIDAD TOTAL DE UNIDADES</th></tr>";
            foreach($platosMasPedidos as $plato) {
                echo "<tr>";
                    echo "<td>".$plato->nombre."</td>";
                    echo "<td>".number_format($plato->precio,2)."€</td>";
                    echo "<td><a href=\"$self?id=".$plato->idplato."\">".$plato->cantPedidos." pedidos</a></td>";
                    if(is_null($plato->unidadesTotales)) {
                        $plato->unidadesTotales = 0;
                    }
                    echo "<td>".$plato->unidadesTotales." unidades</td>";

                    if($plato->idplato == $id) {
                        echo "<tr>";
                            echo "<td></td><td></td>";

                            if($pedidosDePlato == null) {
                                echo "<td><b>NO HAY PEDIDOS</b></td>";
                            }
                            else{
                                echo "<td><table>";
                                echo "<tr><th>CLIENTE</th><th>FECHA</th><th>UNIDADES</th></tr>";
                                foreach($pedidosDePlato as $pedido) {
                                    echo "<tr>";
                                        echo "<td>".$pedido->nombre."</td>";
                                        echo "<td>".$pedido->fecha."</td>";
                                        echo "<td>".$pedido->unidades."</td>";
                                    echo "</tr>";
                                }
                                echo "</table></td>";
                            }
                            
                        echo "</tr>";
                    }
                echo "</tr>";
            }
        echo "</table>";

    ?>
</body>
</html>