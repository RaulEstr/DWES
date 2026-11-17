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
            $num_aula = $this->request->getPost("num_aula");
            $idtema = $this->request->getPost("idtema");
            $dia = $this->request->getPost("dia");
            $precio = $this->request->getPost("precio");
            if(!empty($num_aula) && !empty($idtema) && !empty($dia) && !empty($precio)) {
                $newCurso = (object)["idedificio" => $idedificio, "num_aula"=>$num_aula, "dia"=>$dia, "idtema"=>$idtema, "precio"=>$precio];
                $idNuevoCurso = $this->model->insertarCurso($newCurso);
                if($idNuevoCurso) {
                    $datos["curso"] = $this->model->curso($idNuevoCurso);
                    echo view("vheader");
                    echo view("programar/vvercurso", $datos);
                    echo view("vfooter");
                    return;
                }
                else {
                    $datos["error"] = "Error al al crear curso";
                }
            }
            else {
                $datos["error"] = "Faltan datos";
                $datos["num_aula"] = $num_aula;
                $datos["dia"] = $dia;
                $datos["precio"] = $precio;
                $datos["idtema"] = $idtema;
            }
        }
        $datos["edificio"] = $this->model->edificio($idedificio);
        $datos["aulas"] = $this->model->aulas($idedificio);
        $datos["temas"] = $this->model->temas();
        echo view("vheader");
        echo view("programar/vnuevocurso", $datos);
        echo view("vfooter");
    }

    
}
