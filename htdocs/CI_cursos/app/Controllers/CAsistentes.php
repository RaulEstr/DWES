<?php

namespace App\Controllers;

use App\Models\MCursos;

class CAsistentes extends BaseController
{
    protected $model;

    public function __construct() {
        $this->model = new MCursos();
    }

    public function login() {
        if($this->request->getPost("submitLogin")) {
            $password = $this->request->getPost("password");
            $login = $this->request->getPost("login");

            if($login == "admin" && $password == "admin") {
                return redirect()->to(site_url()."/Gestion/asistentes");
            }

            $asistente = $this->model->asistente($login);
            if($password != "damocles" || $asistente == null) {
                echo view("vheader");
                echo view("asistentes/v_login");
                echo view("vError", ["error" => "Usuario o contraseña incorrectos"]);
                echo view("vfooter");
                return;
            }
            else {
                return redirect()->to(site_url()."/Asistente/".$asistente->dni);
            }
        }

        echo view("vheader");
        echo view("asistentes/v_login");
        echo view("vfooter");
    }

    public function datosAsistente($dni) {
        if($this->request->getPost("submitActualizar")) {
            $dni = $this->request->getPost("dni");
            $nombre = $this->request->getPost("nombre");
            $telefono = $this->request->getPost("telefono");
            $cursos = $this->request->getPost("cursos");
            
            $this->model->actualizarAsistente($dni, $nombre, $telefono);
        }

        $datos["asistente"] = $this->model->asistente($dni);
        $datos["cursos"] = $this->model->cursosDeAsistente($dni);
        echo view("vheader");
        echo view("asistentes/v_form_asistente", $datos);
        echo view("vfooter");
    }

    public function gestion() {
        $asistentes = $this->model->asistentes();
        echo view("vheader");
        foreach($asistentes as $asistente) {
            $datos["asistente"] = $this->model->asistente($asistente->dni);
            $datos["cursos"] = $this->model->cursosDeAsistente($asistente->dni);
            echo view("asistentes/v_form_asistente", $datos);
            echo "<hr>";
        }
        echo view("vfooter");
    }
}