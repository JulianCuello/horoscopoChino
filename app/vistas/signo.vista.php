<?php
   
class marcaVista{

    public function demostrarsignos($signo,$adm){
        require './templates/mostrar/signo.phtml';
    }

    public function mostrarSignosId($signo){
        require './templates/mostrar/signoPorId.phtml';
    }
    
    public function mostrarFormularioSignoModificacion($signo){
        require './templates/formularios/modificar.signo.phtml';
    }
    
    public function mostrarFormularioMarca($signo = null) {
        require './templates/formularios/agregar.signo.phtml';
    }
 }