<?php
require_once './app/vistas/persona.vista.php';

//controlador de manejo de errores que utiliza el router, por default y parametros no definidos $params[1]
class mostrarControlador{

    private $vista;

    public function __construct(){
        $this->vista = new AlertaVista();
    }

    public function demostrarError($error){
        $this->vista->mostrarError($error);
    }
}