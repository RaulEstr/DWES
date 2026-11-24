<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MCategorias;

class CCategorias extends BaseController
{
    protected MCategorias $categModel;

    public function __construct() {
        $this->categModel = new MCategorias();
    }

    public function index() {
        $datos["categorias"] = $this->categModel->findAll();
        return view("v_header").view("categorias/v_categorias", $datos).view("v_footer");
    }

    public function borrar(int $id) {
        $this->categModel->delete($id);
        return $this->index();
    }

    public function nuevo() {
        if($this->request->is("GET")) {
            $datos["categorias"] = $this->categModel->findAll();
            return view("v_header").view("categorias/v_categorias", $datos).view("categorias/v_newcategoria").view("v_footer");
        }

        if($this->request->is("POST")) {
            if($_POST["nombre"] != "") {
                $this->categModel->insert((object)$_POST);
                return redirect()->to("/categorias");
            }
        }
    }

    public function actualizar(int $id) {
        if($this->request->is("GET")) {
            $datos["categorias"] = $this->categModel->findAll();
            $datos["categoria"] = $this->categModel->find($id);
            return view("v_header").view("categorias/v_categorias", $datos).view("categorias/v_updatecategoria", $datos).view("v_footer");
        }

        if($this->request->is("POST")) {
            if($_POST["nombre"] != "") {
                $this->categModel->update($id, (object) $_POST);
                return redirect()->to("/categorias");
            }
        }
    }
}
