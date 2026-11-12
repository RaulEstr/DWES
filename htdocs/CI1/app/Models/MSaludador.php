<?php

namespace App\Models;

use CodeIgniter\Model;

class MSaludador extends Model 
{

    public function array_saludos($idioma) {
        switch ($idioma) {
            case 'ES':
                return ["Hola", "Buenos días", "Buenas"];
            case "EUS" :
                return ["Kaixo", "Egun on", "Aupa"];
            case "ENG":
                return ["Hi", "Hello", "Good morning"];
            default:
                return ["Ei", "ei"];
        }
    }

}