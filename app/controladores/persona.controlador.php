<?php
    require_once './app/vistas/persona.vista.php';
    require_once './app/vistas/alerta.vista.php';
    require_once './app/modelos/persona.modelo.php';
    require_once './app/modelos/signo.modelo.php';
    require_once './ayudas/autorizacion.php';

    

    class personaControlador {
        private $modelo;
        private $vista;
        private $alertaVista;
        private $modeloSigno;

        public function __construct() {
        
        $this->modelo = new PersonaModelo();
        $this->vista = new PersonaVista();
        $this->modeloSigno = new SignoModelo();
        $this->alertaVista = new AlertaVista();   
        }

        public function mostrarPersonas(){
            $lista = $this->modelo->mostrarPersonas();
            if ($lista != null) {
                $this->vista->mostrarPersonas($lista, Autorizacion::esAdministrador());
            } else {
                $this->alertaVista->mostrarVacio("la lista se encuetra vacia");
            }
        }
        public function mostrarPersonaPorId($id){
            if (Validacion::verificacionIdRouter($id)){//validacion datos recibidos del router
                $item = $this->modelo->obtenerPersonaPorId($id);
                if ($item != null) {
                    $this->vista->mostrarPersonaPorId($item);
                } else {
                    $this->alertaVista->mostrarVacio("no hay elementos para mostrar");
                }
            } else {
                $this->alertaVista->mostrarError("404-Not-Found");
            }
        }
        
        public function eliminarPersona($id){
            Autorizacion::verificacion(); //verifico permisos y parametros validos
            if (Validacion::verificacionIdRouter($id)) {
                try {
                    $registroEliminado = $this->modelo->borrarPersona($id);
                    if ($registroEliminado > 0) {
                        header('Location: ' . BASE_URL . "lista");
                        exit();
                    } else {
                        $this->alertaVista->mostrarError("error al intentar eliminar");
                    }
                } catch (PDOException $error) {
                    $this->alertaVista->mostrarError("Error en la consulta a la base de datos/$error");
                }
            } else {
                $this->alertaVista->mostrarError("404-Not-Found");
            }
        } 

        public function mostrarFormularioModificado($id){
            Autorizacion::verificacion();//verifico permisos y parametros validos
            if (Validacion::verificacionIdRouter($id)) {
                $item = $this->modelo->obtenerPersonaPorId($id);//consulto los tados actuales
                if ($item != null) {
                    $signo = $this->modeloSigno->obtenerIdSigno();//consulto las marcas disponibles para modificar
                    $this->vista->mostrarModificacionFormulario($signo, $item);
                } else {
                    $this->alertaVista->mostrarError("error al intentar mostrar formulario");
                }
            } else {
                $this->alertaVista->mostrarError("404-Not-Found");
            }
        }

 //enviar datos de modificacion
 public function modificarPersona(){
    Autorizacion::verificacion();
        if ($_POST && Validacion::verificarFormulario($_POST)) {

            $id = htmlspecialchars($_POST['id']);
            $nombre = htmlspecialchars($_POST['nombre']);
            $apellido = htmlspecialchars($_POST['apellido']);
            $diaNacimiento = htmlspecialchars($_POST['diaNacimiento']);
            $mesNacimiento = htmlspecialchars($_POST['mesNacimiento']);
            $anioNacimiento = htmlspecialchars($_POST['anioNacimiento']);
            $horaNacimiento = htmlspecialchars($_POST['horaNacimiento']);
            $imgPersona = htmlspecialchars($_POST['imgPersona']);
            $id_signo = htmlspecialchars($_POST['id_signo']);
            
            $registroModificado = $this->modelo->actualizarPersona($id, $nombre,$apellido,$diaNacimiento,$mesNacimiento,$$anioNacimiento,
            $horaNacimiento, $imgPersona, $id_signo);

            if ($registroModificado < 1) {
                $this->alertaVista->mostrarError("No se pudo actualizar registro");
            } else {
                header('Location: ' . BASE_URL . "lista");
            }
    }
}

public function mostrarFormularioAlta(){
    Autorizacion::verificacion();
    $signo = $this->modeloSigno->obtenerSignos(); //consulta las marcas disponibles
    $this->vista->mostrarFormulario($signo);
}

public function agregarPersona() {
    Autorizacion::verificacion();
    try {
        if ($_POST && Validacion::verificacionFormulario($_POST)) {
            // Obtén y limpia los datos del formulario
            $nombre = htmlspecialchars($_POST['nombre']);
            $apellido = htmlspecialchars($_POST['apellido']);
            $diaDeNacimiento = htmlspecialchars($_POST['diaDeNacimiento']);
            $mesDeNacimiento = htmlspecialchars($_POST['mesDeNacimiento']);
            $anioDeNacimiento = htmlspecialchars($_POST['anioDeNacimiento']);
            $horaDeNacimiento = htmlspecialchars($_POST['horaDeNacimiento']);
            $imgPersona = htmlspecialchars($_POST['imgPersona']);
            $id_signo = htmlspecialchars($_POST['id_signo']);
            

            $id = $this->modelo->insertarPersona($nombre, $apellido, $diaDeNacimiento, $mesDeNacimiento, $anioDeNacimiento, 
            $horaDeNacimiento, $imgPersona, $id_signo);

            if ($id) {
                header('Location: ' . BASE_URL . "lista");
            } else {
                $this->alertaVista->mostrarError("Error al insertar la persona.");
            }
        } else {
            $this->alertaVista->mostrarError("Error: el formulario no pudo ser procesado. Asegúrate de que hayas completado todos los campos.");
        }
    } catch (PDOException $error) {
        $this->alertaVista->mostrarError("Error en la consulta a la base de datos: " . $error->getMessage());
    }
  }
}
