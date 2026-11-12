<?php

namespace App\Controllers;

use App\Models\MSaludador;
use APP\Models\MCursos;
use App\Models\MCursos as ModelsMCursos;
use DateTime;

class CSaludador extends BaseController
{
    public function index(): string
    {
        return "<b>Hola</b>";
    }

    public function despedir($cont=3, $frase="agur")
    {
        while($cont > 0) {
            echo "<p>$frase</p>";
            $cont--;
        }
    }

    public function cargar_vistas() {
        // echo view("vheader");
        // echo view("vcontent");
        // echo view("vfooter");
        return view("vheader").view("vcontent").view("vfooter");
    }

    private function dia_de_suerte() {
        $dia = date_format(new DateTime(), "d");
        $mes = date_format(new DateTime(), "m");

        if($dia%2 == 0 || ($dia==29 && $mes==2)) {
            return true;
        }
        return false;
    }

    public function saludar_segun_dia() {
        if($this->dia_de_suerte()) {
            echo "<p>Tendrá suerte</p>";
        }
        else {
            echo "<p>Estará maldito</p>";
        }
    }

    public function saludar_segun_idioma($idioma) {
        $modelo = new MSaludador();
        $saludos = $modelo->array_saludos($idioma);

        $datos["saludos"] = $saludos;
        $datos["hoy"] = date_format(new DateTime(), "d-M-y");
        echo view("vheader");
        echo view("vsaludos", $datos);
        echo view("vfooter");
    }

    public function publi() {
        $modelo = new MCursos();
        $datos["cursos"] = $modelo->cursos();
        echo view("vheader");
        echo view("vcursos", $datos);
        echo view("vfooter");
    }
}
