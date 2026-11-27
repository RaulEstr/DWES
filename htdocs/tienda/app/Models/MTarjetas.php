<?php

namespace App\Models;

use CodeIgniter\Model;

class MTarjetas extends Model
{
    protected $table            = 'tarjetas';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ["numero", "cvc", "fecha_caducidad", "cliente"];
}
