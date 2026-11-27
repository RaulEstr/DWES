<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MClientes;
use App\Models\MTarjetas;
use CodeIgniter\HTTP\ResponseInterface;
use stdClass;

class CTarjetas extends BaseController
{

    protected MTarjetas $tarjModel;
    protected MClientes $cliModel;
    public function __construct() {
        $this->tarjModel = new MTarjetas();
        $this->cliModel = new MClientes();
    }

    public function tarjeta($cliente) {
        if($this->request->getPost("aniadirTarjeta")) {
            if(session()->get("tarjetas") == null) {
                session()->set("tarjetas", []);
            }
            $tarjetas = session()->get("tarjetas");
            $tarjeta = new stdClass();
            $tarjeta->numero = $this->request->getPost("numero");
            $tarjeta->cvc = $this->request->getPost("cvc");
            $tarjeta->fecha_caducidad = $this->request->getPost("fecha_caducidad");
            $tarjeta->cliente = $cliente;
            $tarjetas[] = $tarjeta;
            session()->set("tarjetas", $tarjetas);
        }

        $datos["cliente"] = $this->cliModel->find($cliente);
        $datos["tarjetas"] = $this->tarjModel->where("cliente", $cliente)->findAll();

        return view("tarjetas/v_tarjetas", $datos);
    }

    public function grabar($cliente) {
        $tarjetas = session()->get("tarjetas");
        foreach($tarjetas as $tarjeta){
            $this->tarjModel->insert($tarjeta);
        }
        session()->setFlashdata("cantTarjetas", count(session()->get("tarjetas")));
        session()->remove("tarjetas");
        return redirect()->to("/tarjetas/$cliente");
    }

    public function reset($cliente) {
        session()->remove("tarjetas");
        return redirect()->to("/tarjetas/$cliente");
    }
}
