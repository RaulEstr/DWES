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

    

}


