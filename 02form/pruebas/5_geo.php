<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <?php 
    
    const pregs = [
        ["Capital de Italia", "Roma"],
        ["Capital de España", "Madrid"],
        ["Capital de Francia", "Paris"],
        ["Rio más grande de América", "Amazonas"],
        ["Millones de habitantes de Madrid", "5"]
    ];
    
    $respuestasCorrectas = 0;
    $iActual = 0;
    $feedback = "";

    if(isset($_POST["enviar"])) {

        $iActual = $_GET["actual"];
        if($_POST["respuesta"] == pregs[$iActual][1]) {
            $respuestasCorrectas = $_POST["correctas"] + 1;
            $feedback = "La respuesta es correcta";
        }
        else {
            $feedback = "La respuesta es erronea, la correcta era ".pregs[$iActual][1];
        }

        $iActual++;
    }

    ?>

</head>
<body>
    <h1>CONCURSO DE GEOGRAFIA</h1>

    <?php 

    if($feedback != "") {
        echo "<p>$feedback</p>";
    }    
    if($iActual < count(pregs)) {
        echo "<form action=".$_SERVER["PHP_SELF"]."?actual=$iActual method=\"POST\">";
            echo "<input type=\"hidden\" name=\"correctas\" value=\"$respuestasCorrectas\">";
            echo "<table>";
                echo "<tr>";
                    echo "<td><label>".pregs[$iActual][0]."</label></td>";
                echo "</tr>";
                echo "<tr>";
                    echo "<td><input type=\"text\" name=\"respuesta\"></td>";
                echo "</tr>";
                echo "<tr>";
                    echo "<td><input type=\"submit\" name=\"enviar\" value=\"ENVIAR\"></td>";
                echo "</tr>";
            echo "</table>";
        echo "</form>";
    }
    else {
        echo "<p>Has acertado $respuestasCorrectas de ".count(pregs)."</p>";
        echo "<p><a href=\"".$_SERVER["PHP_SELF"]."\">VOLVER A HACER TEST GEOGRAFIA</a></p>";
    }
    
    ?>

    
</body>
</html>