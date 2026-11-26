<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MCategorias;
use App\Models\MProductos;

class CProductos extends BaseController
{
    protected MProductos $prodModel;
    protected MCategorias $categModel;

    public function __construct() {
        $this->prodModel = new MProductos();
        $this->categModel = new MCategorias();
    }

    public function index(){
        $datos["productos"] = $this->prodModel
        ->select("productos.id, productos.nombre, precio, stock, categorias.nombre as categoria")
        ->join("categorias", "categorias.id = productos.categoria")
        ->orderBy("categoria")
        ->findAll();
        return view("v_header").view("productos/v_productos", $datos).view("v_footer");
    }

    public function borrar(int $id) {
        $this->prodModel->delete($id);
        return $this->index();
    }

    public function nuevo() {
        if($this->request->is("GET")) {
            $datos1["productos"] = $this->prodModel->prodsConNombreCategoria(); 

            $categorias = $this->categModel->findAll();
            $datos2["categorias"] = [];
            foreach($categorias as $categoria) {
                $datos2["categorias"][$categoria->id] = $categoria->nombre;
            }

            return view("v_header").view("productos/v_productos", $datos1).view("productos/v_newproducto", $datos2).view("v_footer");
        }

        if($this->request->is("POST")) {
            if($_POST["nombre"] != "") {
                $this->prodModel->insert((object)$_POST);
                return redirect()->to("/productos");
            }
        }
        
    }

    public function actualizar(int $id) {
        if($this->request->is("GET")) {
            $datos1["productos"] = $this->prodModel->prodsConNombreCategoria(); 
            $datos2["producto"] = $this->prodModel->find($id);
            $categorias = $this->categModel->findAll();
            $datos2["categorias"] = [];
            foreach($categorias as $categoria) {
                $datos2["categorias"][$categoria->id] = $categoria->nombre;
            }
            return view("v_header").view("productos/v_productos", $datos1).view("productos/v_updateproducto", $datos2).view("v_footer");
        }

        if($this->request->is("POST")) {
            if($_POST["nombre"] != "") {
                $this->prodModel->update($id, (object) $_POST);
                return redirect()->to("/productos");
            }
        }
    }

    public function caros() {
        $datos["productos"] = $this->prodModel->prodsCaros();
        return view("v_header").view("productos/v_solo_productos", $datos).view("v_footer");
    }

    public function entre(float $min, float $max) {
        $datos["productos"] = $this->prodModel->prodsEnRango($min, $max);
        return view("v_header").view("productos/v_solo_productos", $datos).view("v_footer");
    }

    public function completos() {
        $datos["productos"] = $this->prodModel->prodsConNombreCategoria();
        return view("v_header").view("productos/v_solo_productos", $datos).view("v_footer");
    }

    public function cuantos_sin_stock() {
        echo "Productos sin stock: ".$this->prodModel->prodsSinStock();
    }
}
