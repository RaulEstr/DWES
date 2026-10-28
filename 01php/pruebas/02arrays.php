<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php 
        $ciudades=["Vitoria", "Pamplona", "Bilbao"];
        $capitales=array();
        $capitales[]="Madrid";
        $capitales[]="Lisboa";
        $capitales[1]="Londres"; //Elimina Lisboa
        echo "<p>Cantidad ciudades: ".count($ciudades)."</p>";
        echo "<p>Cantidad capitales: ".count($capitales)."</p>";

        print_r($capitales);

        // if (in_array("Londres", $capitales)) echo "<p>Si está</p>";
        // else echo "<p>No está</p>";

        echo in_array("Londres", $capitales) ? "<p>Si está</p>" : "<p>No está</p>";
       
        if (in_array("Londres", $capitales)) echo "<p>Está en el índice: ".array_search("Londres", $capitales)."</p>";

        echo "<br>";
        echo "<br>";
        echo "<br>";

        $dias = ["Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo"];
        $temps = [30,21,20,23,23,20,18];
        $i = 0;
        echo "<h2>Temperaturas de esta semana</h2>";
        echo "<ul>";
            foreach ($temps as $temp) {
                echo "<li>".$dias[$i]." ".$temp."º</li>";
                $i++;
            }
        echo "</ul>";

        var_dump($temps);
        sort($temps);
        echo "<br>";
        var_dump($temps);

        $media= (int)(array_sum($temps)/count($temps));
        echo "<p>Temperatura media: ".$media."º</p>";

        echo "<br>";
        echo "<br>";
        echo "<hr>";

        echo "<h2>Arrays asociativos</h2>";
        $arrpoblacion=["Gasteiz" => 270000, "Bilbao" => 800000, "Madrid" => 4000000];
        $arrpoblacion["Paris"] = 9000000;
        $arrpoblacion["Pamplona"] = 180000;
        var_dump($arrpoblacion);

        echo "<table>";
            echo "<tr><th>CIUDAD</th><th>POBLACIÓN</th></tr>";
            foreach ($arrpoblacion as $ciudad => $habitantes) {
                echo "<tr><td>$ciudad</td><td>$habitantes</td></tr>";
            }
        echo "</table>";

        // $x = 5;
        // echo isset($x) ? "<p>Existe</p>" : "<p>No existe</p>";
        // unset($x);
        // echo isset($x) ? "<p>Existe</p>" : "<p>No existe</p>";

        echo in_array(180000, $arrpoblacion) ? "<p>Está en los valores</p>" : "<p>No está en los valores</p>";

        echo array_key_exists("Pamplona", $arrpoblacion) ? "<p>Está en las claves</p>" : "<p>No está en las claves</p>";

        var_dump($arrpoblacion);
        unset($arrpoblacion["Pamplona"]);
        unset($arrpoblacion["Gasteiz"]);
        echo "<br>";
        var_dump($arrpoblacion);
        echo "<hr>";


        $nums= [1,2,3,4,5,6,7];
        $tamanio= count($nums);
        echo "<p>$tamanio</p>";
        foreach($nums as $ind=>$num) {
            echo $num."&nbsp; ";
        }
        echo "<br>";
        unset($nums[1]);
        unset($nums[count($nums) - 1]);
        $tamanio= count($nums);
        echo "<p>$tamanio</p>";
        foreach($nums as $ind=>$num) {
            echo $num."&nbsp; ";
        }
    ?>
</body>
</html>