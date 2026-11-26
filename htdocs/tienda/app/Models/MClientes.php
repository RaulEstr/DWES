<?php

namespace App\Models;

use CodeIgniter\Model;

class MClientes extends Model
{
    protected $table            = 'clientes';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ["nombre", "apellido1", "apellido2",
                                    "sexo", "fecha_nac", "email",
                                    "direccion", "municipio", "provincia",
                                    "cp", "ranking"];

}
