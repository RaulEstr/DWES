<?php 
        //2
        function arrTotales($arr){
            $totales = [];
            foreach($arr as $modulo => $horas) {
                $totales[$modulo] = array_sum($horas);
            }
            return $totales;
        }

        //3
        function limpiar($arr) {
            foreach($arr as $modulo => $horas) {
                foreach($horas as $index => $hora) {
                    if($hora <= 0) {
                        unset($arr[$modulo][$index]);
                    }
                }
            }
            return $arr;
        }
    ?>