<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php 
        function factorial($num){
            $f=1;
            for($c=1; $c<=$num; $c++) {
                $f *= $c;
            }
            return $f;
        }
    ?>
</head>
<body>
    <p>Primera prueba</p>
    <br>
    <?php 
        $x=5;
        echo "<p>El cuadrado de $x es ".($x*$x)."</p>"; 
        echo "<p>La raiz de $x es ".sqrt($x)."</p>";
        
        $nota=9;
        if($nota >= 9) echo "Sobresaliente";
        elseif($nota >= 7) echo "Notable";
        elseif($nota >= 5) echo "Suficiente";
        else echo "Suspenso";
        
        echo "<p>Factorial de $x = ".factorial($x)."</p>";

        echo "<table>";
            echo "<tr><td colspan='2'>FACTORIALES</td></tr>";
            for($m=1;$m<=10;$m++) {
                echo "<tr>";
                    echo "<td>".$m."</td>";
                    echo "<td>".factorial($m)."</td>";
                echo "</tr>";
            }
        echo "</table>";
    ?>
</body>
</html>