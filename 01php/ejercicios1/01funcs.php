<?php

    // 5
    function numerosRandom($n, $limite1, $limite2) {
        $arrAleatorios = [];
        for($i=1; $i<=$n; $i++) {
            $arrAleatorios[] = rand($limite1, $limite2);
        }
        return $arrAleatorios;
    }

    // 6

    function cifrar($texto) {
        $cifrado = [
            "A" => "20", "H" => "9R", "M" => "abcd"
        ];
        
        $textoCifradro = "";
        for($i=0; $i<strlen($texto); $i++) {
            if(key_exists($texto[$i], $cifrado)) {
                $textoCifradro .= $cifrado[$texto[$i]];
            } 
            else {
                $textoCifradro .= $texto[$i];
            }
        }
        return $textoCifradro;
    }

?>