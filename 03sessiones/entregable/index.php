<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <?php 
    
        session_start();

        $self = $_SERVER["PHP_SELF"];

        const ZONAS = [
            "Bodega delantera (150kg)" => 150, 
            "Bodega trasera (100kg)" => 100,
            "Compartimento central (80kg)" => 80,
            "Compartimento auxiliar (50kg)" => 50
        ];

        if(!isset($_SESSION["pesoTotal"])) {
            $_SESSION["pesoTotal"] = 0;
        }

        $error = "";
        if(isset($_POST["submit"])) {  
            if(isset($_POST["zona"])) {
                $_SESSION["pesoTotal"] = 0;
                foreach($_POST["zona"] as $peso) {
                    $_SESSION["pesoTotal"] += $peso;
                }
                header("location: maletas.php");
                exit();
            }
            else {
                $error = "Tienes que seleccionar al menos un compartimento";
            }
        }
    
    ?>
</head>
<body>
    <?php 
    echo "<form action=\"$self\" method=\"post\">";
        foreach(ZONAS as $zona => $peso) {
            echo "<input type=\"checkbox\" name=\"zona[]\" value=\"$peso\">$zona";
            echo "<br>";
        }

        echo "<input type=\"submit\" name=\"submit\" value=\"CONFIGURAR MALETERO\">";
        if($error != "") {
            echo "<p>$error</p>";
        }
    echo "</form>";
    ?>
</body>
</html>