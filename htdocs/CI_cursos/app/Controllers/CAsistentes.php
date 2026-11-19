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
        $datos["asistente"] = $this->model->asistente($dni);
        

        echo view("vheader");
        echo view("v_form_asistente");
        echo view("vfooter");
    }
}