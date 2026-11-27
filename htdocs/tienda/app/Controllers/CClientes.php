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

            if(!$this->request->getPost("sexo")) {
                return redirect()->back()->with("errorsexo", "Debes elegir un sexo")->withInput();
            }

            $nuevoCli->sexo = $this->request->getPost("sexo");
            $nuevoCli->fecha_nac = $this->request->getPost("fecha_nac");
            $this->session->set("nuevoCli", $nuevoCli);
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

        if($this->request->getPost("submit3")) {
            helper("gustos");
            $posts = $this->request->getPost();
            unset($posts['submit3']);
            $puntuacion = 0;
            foreach($posts as $gusto=>$valor) {
                $puntuacion += $valor * (gustos[$gusto]/100);
            }
            $nuevoCli = $this->session->get("nuevoCli");
            $nuevoCli->ranking = $puntuacion;
            $this->clientModel->insert($nuevoCli);
            $this->session->setFlashdata("finalaltacliente", "Cliente $nuevoCli->nombre registrado");
            $this->session->remove("nuevoCli");
            $this->session->remove("pasoAlta");
        }

        switch($this->session->get("pasoAlta")) {
            case null:
                return view("clientes/v_altacliente1");
            case 1:
                return view("clientes/v_altacliente2");
            case 2:
                return view("clientes/v_altacliente3");
        }        
        helper("gustos");
    }
}
