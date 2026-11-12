<?php

namespace App\Models;

use CodeIgniter\Model;

class MCursos extends Model 
{

    protected $bd;
    public function __construct() {
        $this->bd = db_connect();
    }

    public function cursos() {
        $sql = "select idcurso, precio from cursos";
        $query = $this->bd->query($sql);
        return $query->getResult();
    }

}