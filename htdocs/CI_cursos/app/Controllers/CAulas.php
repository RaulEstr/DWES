<?php

namespace App\Controllers;

use App\Models\MCursos;

class CAulas extends BaseController
{
    protected $model;

    public function __construct() {
        $this->model = new MCursos();
    }

    public function detallesEdificio($idEdificio) {
        $datos["edificio"] = $this->model->edificio($idEdificio);
        $datos["aulas"] = $this->model->aulas($idEdificio);
        echo view("vheader");
        echo view("aulas/vAulasEdificio", $datos);
        echo view("vfooter");
    }

    public function cursosAulas($idEdificio, $numero) {
        if($this->request->getPost("submitCambio")) {
            $tema = $this->request->getPost("tema");
            $dia = $this->request->getPost("dia");
            $asistentes = $this->request->getPost("asistentes");
            $precio = $this->request->getPost("precio");

            $idcurso = $this->request->getPost("idcurso");
            $idtema = $this->request->getPost("idtema");
            if(!empty($tema) && !empty($dia) && !empty($asistentes) && !empty($precio)) {
                $this->model->actualizarTema($idtema, $tema);
                $this->model->actualizarCurso($idcurso, $dia, $asistentes, $precio);
            }
            else {
                $datos2["error"] = "No puede haber datos vacios";
            }
        }

        $datos1["edificio"] = $this->model->edificio($idEdificio);
        $datos1["aulas"] = $this->model->aulas($idEdificio);

        $datos2["cursos"] = $this->model->cursosDeAula($idEdificio, $numero);

        echo view("vheader");
        echo view("aulas/vAulasEdificio", $datos1);
        echo view("aulas/VCursosAula", $datos2);
        echo view("vfooter");
    }
}