<?php

namespace App\Controllers;

use App\Models\MCursos;

class CCursos extends BaseController
{
    protected $model;

    public function __construct() {
        $this->model = new MCursos();
    }

    public function index()
    {
        $datos["cursosbaratos"]=$this->model->cursosBaratos();
        $datos["cuantos"] = $this->model->cursosSinAsistencia();
        $datos["cursoscongente"] = $this->model->cursosNAsistencias(2);
        echo view("vheader");
        echo view("vindex", $datos);
        echo view("vfooter");
    }

    public function todoscursos() {

        $datos["cursos"] = $this->model->cursos();
        echo view("vheader");
        echo view("vcursos", $datos);
        echo view("vfooter");
    }

    public function detalleasistencia($idcurso) {
        $datos["asistencia"] = $this->model->asistenciaCurso($idcurso);
        $datos["cursos"] = $this->model->cursos();
        $datos["idcursosel"] = $idcurso;
        echo view("vheader");
        echo view("vcursos", $datos);
        echo view("vfooter");
    }

    public function newasistente() {
        $datos = [];
        if($this->request->getPost("submitNuevoAsistente")) {
            $asistente["dni"] = $this->request->getPost("dni");
            $asistente["nombre"] = $this->request->getPost("nombre");
            $asistente["telefono"] = $this->request->getPost("telefono");
            $asistente = (object)$asistente;
            if(!$this->model->aniadirAsistente($asistente)) {
                $datos["mensaje"] = "No se ha podido añadir";
            }
            else {
                $datos["mensaje"] = "Asistente añadido";
            }
        }
        echo view("vheader");
        echo view("vformasistencia", $datos);
        echo view("vfooter");
    }
}
