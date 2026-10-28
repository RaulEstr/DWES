<?php

function cuantosFavorita($personas, $pelicula) {
    $contador = 0;

    foreach($personas as $persona=>$peliculas) {
        if(in_array($pelicula, $personas[$persona])) {
            $contador++;
        }  
    }

    return $contador;
}

function peliculasAleatoria($personas) {
    foreach($personas as $persona=>$peliculas) {
        if(count($peliculas) > 1) {
            $rand1 = random_int(0, count($peliculas) - 1);
            $rand2 = random_int(0, count($peliculas) - 1);
            while($rand1 == $rand2) {
                $rand1 = random_int(0, count($peliculas) - 1);
                $rand2 = random_int(0, count($peliculas) - 1);
            }
            echo "<p>$persona tiene entre sus peliculas favoritas: ".$peliculas[$rand1]." y ".$peliculas[$rand2]."</p>";
        }
    }
}

?>