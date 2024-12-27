
<?php

require_once 'app/controladores/juguete.controlador.php';

class jugueteVista {

    public function mostrarError($error) {
        echo "<h2> $error</h2>";
    }

    public function mostrarPersonas($persona,$adm) {
        require('./templates/mostrar/juguete.phtml');        
    }
    
    public function mostrarPersonaPorId($lista) {
        require './templates/mostrar/juguetePorId.phtml';   
    }

    public function mostrarModificacionDeUsuario($signo, $item) {
        require './templates/formularios/modificarPersona.phtml';          
    }
    
    public function mostrarFormulario($persona){
        require './templates/formularios/agregar.persona.phtml';
    }
}