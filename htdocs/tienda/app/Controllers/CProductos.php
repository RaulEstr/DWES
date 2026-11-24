<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MCategorias;
use App\Models\MProductos;

class CProductos extends BaseController
{
    protected MProductos $prodModel;

    public function __construct() {
        $this->prodModel = new MProductos();
    }

    public function index(){
        $datos["productos"] = $this->prodModel
        ->select("productos.id as prodId, productos.nombre as prodNom, precio, stock, categorias.nombre as categoria")
        ->join("categorias", "categorias.id = productos.categoria")
        ->orderBy("categoria")
        ->findAll();
        return view("v_header").view("productos/v_productos", $datos).view("v_footer");
    }
}
