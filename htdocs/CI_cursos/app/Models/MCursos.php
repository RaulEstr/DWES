<?php

namespace App\Models;
use CodeIgniter\Model;

class MCursos extends Model {
    protected $bd;

    public function __construct() {
        $this->bd = db_connect();
    }

    public function cursos() {
        $sql = "select idcurso, dia, tema, categoria, precio from cursos, temas where cursos.idtema = temas.idtema";
        $rs = $this->bd->query($sql);
        return $rs->getResultObject();
    }

    public function cursosBaratos() {
        $sql = "select idcurso, dia, tema, categoria, precio from cursos, temas where precio < (select avg(precio) from cursos) and cursos.idtema = temas.idtema";
        $rs = $this->bd->query($sql);
        return $rs->getResultObject();
    }

    public function cursosSinAsistencia() {
        $sql = "select count(*) as cuantos from cursos where idcurso not in (select distinct idcurso from asistencias)";
        $rs = $this->bd->query($sql);
        return $rs->getRowArray()["cuantos"];
    }

    public function cursosNAsistencias($min) {
        $sql = "SELECT idcurso, idedificio, num_aula, dia, asistentes from cursos where idcurso in (select idcurso from asistencias group by idcurso having count(*) > $min)";
        $rs = $this->bd->query($sql);
        return $rs->getResultArray();
    }

    public function asistenciaCurso($idCurso) {
        $sql = "SELECT asistencias.id, asistencias.dni, asistencias.idcurso, asistencias.estado, asistentes.nombre, asistentes.telefono 
        from asistencias, asistentes 
        where asistencias.dni = asistentes.dni 
        and asistencias.idcurso = $idCurso";
        $rs = $this->bd->query($sql);
        return $rs->getResultObject();
    }

    public function aniadirAsistente($asistente) {
        $sql = "SELECT dni from asistentes where dni = \"$asistente->dni\"";
        $rs = $this->bd->query($sql);
        if($rs->getNumRows() != 0) {
            return false;
        }

        $sql = "INSERT into asistentes(dni, nombre, telefono) values ('$asistente->dni', '$asistente->nombre', '$asistente->telefono')";
        return $this->bd->query($sql);
    }

    public function edificios() {
        $sql = "SELECT idedificio, nombre from edificios order by nombre";
        $rs = $this->bd->query($sql);
        return $rs->getResultObject();
    }

    public function aulas($edificio) {
        $sql = "SELECT idedificio, numero, capacidad from aulas where idedificio = '$edificio' order by numero";
        $rs = $this->bd->query($sql);
        return $rs->getResultObject();
    }

    public function temas() {
        $sql = "SELECT idtema, tema, categoria from temas order by categoria, tema";
        $rs = $this->bd->query($sql);
        return $rs->getResultObject();
    }

    public function edificio($idedificio) {
        $sql = "SELECT idedificio, nombre from edificios where idedificio = '$idedificio'";
        $rs = $this->bd->query($sql);
        return $rs->getRowObject();
    }
}