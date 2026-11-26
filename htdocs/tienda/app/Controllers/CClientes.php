<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MClientes;
use stdClass;

class CClientes extends BaseController
{
    protected MClientes $clientModel;
    public function __construct() {
        $this->clientModel = new MClientes();
    }

    public function alta() {

        if($this->request->getPost("submit1")) {
            $nuevoCli = new stdClass();
            $nuevoCli->nombre = $this->request->getPost("nombre");
            $nuevoCli->apellido1 = $this->request->getPost("apellido1");
            $nuevoCli->apellido2 = $this->request->getPost("apellido2");
            $nuevoCli->sexo = $this->request->getPost("sexo");
            $nuevoCli->fecha_nac = $this->request->getPost("fecha_nac");
            $this->session->set("nuevocli", $nuevoCli);
            $this->session->set("pasoAlta", 1);
        }

        if($this->request->getPost("submit2")) {
            $nuevoCli = $this->session->get("nuevoCli");
            $nuevoCli->direccion = $this->request->getPost("direccion");
            $nuevoCli->municipio = $this->request->getPost("municipio");
            $nuevoCli->provincia = $this->request->getPost("provincia");
            $nuevoCli->cp = $this->request->getPost("cp");
            $this->session->set("nuevocli", $nuevoCli);
            $this->session->set("pasoAlta", 2);
        }

        switch($this->session->get("pasoAlta")) {
            case null:
                return view("clientes/v_altacliente1");
            case 1:
                return view("clientes/v_altacliente2");
            case 2:
                return view("clientes/v_altacliente3");
            case 3:
        }        
        helper("gustos");
    }
}
