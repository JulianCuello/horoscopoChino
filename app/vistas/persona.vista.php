
<?php

require_once 'app/controladores/persona.controlador.php';

class personaVista {

    public function mostrarError($error) {
        echo "<h2> $error</h2>";
    }

    public function mostrarPersonas($persona,$adm) {
        require('./templates/mostrar/persona.phtml');        
    }
    
    public function mostrarPersonaPorId($lista) {
        require './templates/mostrar/personaPorId.phtml';   
    }

    public function mostrarModificacionDeUsuario($signo, $item) {
        require './templates/formularios/modificarPersona.phtml';          
    }
    
    public function mostrarFormulario($persona){
        require './templates/formularios/agregar.persona.phtml';
    }
}