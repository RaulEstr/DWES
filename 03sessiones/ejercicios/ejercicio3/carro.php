<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        table, th, tr, td{
            margin: 5px;
            padding: 5px;
        }  
        input[type="submit"] {
            margin: 5px;
        }
    </style>
    <?php 
        session_start();
        const PRODUCTOS = ["Producto1" => 25.5, "Producto2" => 10.5, "Producto3" => 10, "Producto4" => 30, "Producto5" => 100];
        const CANTIDADES = [0,1,2,3,4,5,6,7,8,9];
        $self = $_SERVER["PHP_SELF"];

        if(isset($_POST["vaciar"])) {
            unset($_SESSION["cantidades"]);
        }

        if(isset($_GET["reset"])) {
            unset($_SESSION["cantidades"]);
        }

        if(!isset($_SESSION["cantidades"])) {
            foreach(PRODUCTOS as $producto => $precio) {
                $_SESSION["cantidades"][$producto] = 0;
            }
        }

        // Forma con el name del select en forma de cantidad+$producto
        // if(isset($_POST["aniadir"])) {
        //     foreach(PRODUCTOS as $producto => $precio) {
        //         $_SESSION["cantidades"][$producto] += $_POST["cantidad$producto"];
        //     }
        // }

        // Forma con el name del select en forma de array[]
        if(isset($_POST["aniadir"])) {
            $i = 0;
            foreach(PRODUCTOS as $producto => $precio) {
                $_SESSION["cantidades"][$producto] += $_POST["cantidad"][$i];
                $i++;
            }
        }

        $finalizar = false;
        $hayCantidad = false;
        if(isset($_POST["finalizar"])) {
            $finalizar = true;
            foreach($_SESSION["cantidades"] as $producto => $cantidad) {
                if($cantidad > 0) {
                    $hayCantidad = true;
                }
            }
        }
    ?>
</head>
<body>
    <?php
        echo "<form action=\"$self\" method=\"post\">";
            echo "<table>";
                echo "<tr><th>PRODUCTO</th><th>PRECIO</th><th>AÑADE CANTIDAD</th><th>PEDIDO ACTUAL</th></tr>";
                foreach(PRODUCTOS as $producto => $precio) {
                    echo "<tr>";
                        echo "<td>$producto</td>";
                        echo "<td>$precio €</td>";
                        echo "<td>";
                            // echo "<select name=\"cantidad".$producto."\">";
                            echo "<select name=\"cantidad[]\">";
                            foreach(CANTIDADES as $cantidad) {
                                echo "<option value=\"$cantidad\">$cantidad</option>";
                            }
                            echo "</select>";
                        echo "</td>";
                        echo "<td>".$_SESSION["cantidades"][$producto]." uds pedidas</td>";
                    echo "</tr>";
                }
                echo "<tr>";
                    echo "<td style=\"text-align: center\" colspan=\"4\">";
                        echo "<input type=\"submit\" name=\"aniadir\" value=\"Añadir Unidades\">";
                        echo "<input type=\"submit\" name=\"finalizar\" value=\"Formalizar compra\">";
                        echo "<input type=\"submit\" name=\"vaciar\" value=\"Vaciar carro\">";
                    echo "</td>";
                echo "</tr>";
            echo "</table>";
        echo "</form>";
        if($finalizar) {
            if($hayCantidad) {
                echo "<p>Has finalizado tu compra</p>";
                echo "<ul>";
                $total = 0;
                foreach($_SESSION["cantidades"] as $producto => $cantidad) {
                    $total += $cantidad * PRODUCTOS[$producto];
                    if($cantidad > 0) {
                        echo "<li>$producto: $cantidad x ".PRODUCTOS[$producto]." €</li>";
                    }
                }
                echo "</ul>";
                echo "<hr>";
                echo "<h2>TOTAL: $total €</h2>";
                echo "<p><a href=\"$self?reset\">Nueva compra</a></p>";
            }
            else {
                echo "<p>No hay unidades añadidas</p>";
            }
        }
    ?>
</body>
</html>