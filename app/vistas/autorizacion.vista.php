<?php 
//vista de autenticacion
class AutorizacionVista {
    
    public function InicioSesion($error = null) {
        require './templates/autorizacion/inicioSesion.phtml';
    } 
}