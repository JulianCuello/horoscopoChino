<?php
require_once './config.php';
require_once './app/controladores/persona.controlador.php';
require_once './app/controladores/signo.controlador.php';
require_once './app/controladores/autorizacion.controlador.php';
require_once './app/controladores/mostrar.controlador.php';

define('BASE_URL', '//'.$_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . dirname($_SERVER['PHP_SELF']).'/');

//                                              TABLA DE RUTEO
/*
  tabla ruteo                controller                                          descripc                                    
| lista                  -> |ListaControlador |mostrarJuguetes()       |lista productos (juguetes)            |
| listaId/:id            -> |ListaControlador |mostrarListaPorId(id)   |lista producto por id                 |
| eliminarJuguete/:id    -> |ListaControlador    |eliminarJugete(id)          |elimina registro de juguete    |
| modificarJugeteFormulario/:id-> |ListaControlador   |mostrarFormularioModificacion(id)      |redirige a formulario de modificacion |
| modificarJuguete          -> |ListaControlador   |mostrarModificacion()    |envia formulario con modificacion     |
| agregarJugueteFormulario  -> |ListaControlador    |mostrarFormularioAlta() |redirige a formulario alta producto   |
| agregarJuguete()                -> |ListaControlador    |agregarJuguete()  |envia formulario y crea nuevo producto|
|---------------------------|------------------|------------------------|--------------------------------------|
| marca                     -> |marcacontrolador|mostrarMarcas()            |lista marcas                      |
| marcaId/:id               -> |marcacontrolador|mostrarMarcaPorId()          |lista marca por id                |
| elminarMarca/:id     -> |marcacontrolador|elminiarMarca()                 |elimina registro de marca         |
| modificarMarcaFormulario/:id -> |marcacontrolador|FormularioMarcaModificacion()|redirige a formulario de modificacion |
| modificarMarca         -> |marcacontrolador|mostrarMarcaModificacion()    |envia formulario con modificacion     |
| agregarMarcaFormulario  -> |marcacontrolador|mostrarFormularioMarca()   |redirige a formulario alta marca  |
| agregarMarca            -> |marcacontrolador|agregarMarca()                |envia formulario ,crea nueva marca|
|---------------------------|------------------|------------------------|--------------------------------------|
| inicioSesion                  -> |AutorizacionControlador    |inicioSesion()             |                                      |
| cerrarSesion                 -> |AutorizacionControlador    |cerrarSesion()            |                                      |
*/


if (!empty($_GET["action"])){
    $action = $_GET["action"];
} else {
    $action = "lista";
}

$params = explode("/",$action);

//instancio una sola vez
$personaControlador = new PersonaControlador();
$signoControlador = new SignoControlador();
$autorizacionControlador = new AutorizacionControlador();
$mostrarControlador = new MostrarControlador();

switch ($params[0]) {

    case 'lista':
        $personaControlador->mostrarPersonas();
        break;
    case 'personaId':
        if(isset($params[1]))
        $personaControlador->mostrarPersonaPorId($params[1]);
        else $listaControlador->mostrarPersonas();
        break;
    case 'eliminarJuguete':
        if(isset($params[1]))
        $personaControlador->eliminarPersona($params[1]);
        else $mostrarControlador->mostrarError("404-Not-Found");
        break;
    case 'modificarFormularioPersona':
        if(isset($params[1]))
        $personaControlador->mostrarModificacion($params[1]);
        else $mostrarControlador->mostrarError("404-Not-Found");
        break;
        case 'modificarPersona':
            if(isset($params[1]))
            $jugueteControlador->modificarPersona($params[1]);
            else $mostrarControlador->mostrarError("esta entrando con error");
            break;
    case 'agregarPersonaFormulario':
        $personaControlador->mostrarFormularioAlta();
        break;
    case 'agregarPersona':
        $personaControlador->agregarPersona();
        break;
        
    case 'signo':
        $signoControlador->mostrarSignos();
        break;
    case 'signoId':
        if(isset($params[1]))
        $signoControlador->mostrarSignoId($params[1]);
        else $signoControlador->mostrarSignos();
        break;
    case 'eliminarSigno':
        if(isset($params[1]))
        $signoControlador->eliminarSigno($params[1]);
        else $mostrarControlador->mostrarError("404-Not-Found");
        break;
        case 'agregarSignoFormulario':
            $signoControlador->formularioSigno();
            break;
    case 'modificarSigno':
        $signoControlador->mostrarSignoModificado();
        break;
    case 'agregarSigno':
        $signoControlador->agregarSigno();
        break;
    case 'inicioSesion':
        $autorizacionControlador->mostrarInicioSesion();
        break;
    case 'cierreSesion':
        $autorizacionControlador->cerrarSesion();
        break;
    case 'autorizacion':
        $autorizacionControlador->autorizacion();
        break;
    default:
        $mostrarControlador->demostrarError("404-Not-Found");
        break;
}
    

