<?php

namespace App\Models;

use CodeIgniter\Model;

class MProductos extends Model
{
    protected $table            = 'productos';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ["nombre", "precio", "stock", "categoria"];

    public function prodsConNombreCategoria() {
        return $this->select("productos.id, productos.nombre, precio, stock, categorias.nombre as categoria")
                    ->join("categorias", "categorias.id = productos.categoria")
                    ->orderBy("categoria")
                    ->findAll();
    }

    public function prodsCaros() {
        return $this->where("precio > (select avg(precio) from productos)")
                    ->orderBy("precio", "desc")
                    ->findAll();
    }

    public function prodsEnRango(float $min, float $max) {
        return $this->where("precio >=", $min)
                    ->where("precio <=", $max)
                    ->orderBy("precio", "desc")
                    ->findAll();
    }

    public function prodsSinStock() {
        return $this->where("stock", 0)
                    ->countAllResults();
    }

}