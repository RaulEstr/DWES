<?php

namespace App\Controllers;

use App\Models\MCursos;

class CProgramar extends BaseController
{
    protected $model;

    public function __construct() {
        $this->model = new MCursos();
    }

    public function elegirSede() {
        if($this->request->getPost("submitSede")) {
            $idedificio = $this->request->getPost("idedificio");
            if($idedificio) {
                return redirect()->to(site_url()."/programar/".$idedificio); 
            }
            else {
                $datos["error"] = "Debes elegir un edificio";
            }
        }
        $datos["edificios"]=$this->model->edificios();
        echo view("vheader");
        echo view("programar/velegirsede", $datos);
        echo view("vfooter");
    }

    public function nuevoCurso($idedificio) {
        if($this->request->getPost("submitNuevoCurso"))  {
            echo "AAAAAAAAAAAAAAAAAAAAAA";
        }
        $datos["edificio"] = $this->model->edificio($idedificio);
        $datos["aulas"] = $this->model->aulas($idedificio);
        $datos["temas"] = $this->model->temas();
        echo view("vheader");
        echo view("programar/vnuevocurso", $datos);
        echo view("vfooter");
    }
}
