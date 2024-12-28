<?php
//la utilizan todos los controllers para renderizar todos los mensajes o erorres.
class AlertaVista{

    public function mostrarError($error){
        require './templates/alertas/error.phtml';
    }

    public function mostrarVacio($text){
        require './templates/alertas/vacio.phtml';
    }
}