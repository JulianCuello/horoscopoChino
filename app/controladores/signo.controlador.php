<?php
require_once './app/vistas/signo.vista.php';
require_once './app/vistas/alerta.vista.php';
require_once './app/modelos/signo.modelo.php';
require_once './ayudas/validacion.php';
require_once './ayudas/autorizacion.php';

//controller de categorias
class signoControlador{
    private $modelo;
    private $modeloPersona;
    private $vista;
    private $alertaVista;

    public function __construct(){
        //se instancian los dos modelos para no delegar mal, y que cada modelo acceda a su tabla correspondiente.
        $this->modelo = new signoModelo();
        $this->modeloPersona = new personaModelo();
        $this->vista = new signoVista();
        $this->alertaVista = new AlertaVista();
    }

    //lista marcas completa
    public function mostrarSignos(){
        $signo = $this->modelo->obtenerSignos();
        if ($signo == null) {
            $this->alertaVista->mostrarVacio("no hay elementos para mostrar");
        } else {
            $this->vista->demostrarSignos($signo, Autorizacion::esAdministrador());
        }
    }
    //lista filtrada
    public function mostrarSignoId($id) {
        if (Validacion::verificacionIdRouter($id)) {
            $signo = $this->modeloJuguete->obtenerSignoId($id);
            if ($signo != null) {
                $this->vista->mostrarSignoId($signo); // Verifica que este método exista
            } else {
                $this->alertaVista->mostrarVacio("el signo seleccionado no contiene personas asociadas asociados");
            }
        } else {
            $this->alertaVista->mostrarError("404-Not-Found");
        }
    }
    
    //eliminar juguete
    public function eliminarSigno($id)
    {
        Autorizacion::verificacion(); //verifico permisos y parametros validos
        if (Validacion::verificacionIdRouter($id)) {
            try {
                $signoEliminado = $this->modelo->borrarSigno($id);
                if ($signoEliminado > 0) {
                    header('Location: ' . BASE_URL . "signo");
                } else {
                    $this->alertaVista->mostrarError("error al intentar eliminar");
                }
            } catch (PDOException) {
                $this->alertaVista->mostrarError("la marca que intenta eliminar, tiene asociado un conjunto de items.
                                            Para poder eliminar correctamente,
                                            debera eliminar los registros de los items asociados/
                                            ");
            }
        } else {
            $this->alertaVista->mostrarError("404-Not-Found");
        }
    }

    //mostrar formulario modificacion
    public function mostrarformularioSigno($id = null) {
        Autorizacion::verificacion(); //verifico permisos y parametros válidos
    
        // Si el $id es proporcionado, busco la marca para editarla, si no, creo un nuevo formulario
        if ($id !== null && Validacion::verificacionIdRouter($id)) {
            $signo = $this->modelo->obtenerSignoId($id); //consulto los datos actuales
            if ($signo == null) {
                $this->alertaVista->mostrarError("Error al intentar mostrar formulario");
                return;
            }
        } else {
            // Si no se pasa ID, se muestra el formulario para agregar una nueva marca
            $signo = null;
        }
        $this->vista->mostrarFormularioSigno($signo);
    }

    //enviar datos de modificacion 
    function mostrarSignoModificado(){
        Autorizacion::verificacion();
        try {//verifico permisos, parametros validos y posible acceso sin previo acceso al form modificacion.
            if ($_POST && Validacion::verificacionFormulario($_POST)) {

                $id_signo =htmlspecialchars($_POST['id_signo']);
                $elemento =htmlspecialchars($_POST['elemetno']);
                $caracteristicasGenerales =htmlspecialchars($_POST['caracteristicaGenerales']);
                $predicciones =htmlspecialchars($_POST['predicciones']);
                $imgHoroscopo =htmlspecialchars($_POST['imgHoroscopo']);

                
                $signoModificado = $this->modelo->modificacionSigno($id_signo, $elemetno, $caracteristicasGenerales, $predicciones, $imgHoroscopo);
                if ($marcaModificada > 0) {
                    header('Location: ' . BASE_URL . "marca");
                } else {
                    $this->alertaVista->mostrarError("No se pudo actualizar marca");
                }
            } 
        } catch (PDOException $error) {
            $this->alertaVista->mostrarError("Error en la consulta a la base de datos/$error");
        }
    }
   function agregarSigno(){
        Autorizacion::verificacion();
        try {//verifico permisos, parametros validos y posible acceso sin datos al form de alta.
            if ($_POST && Validacion::verificacionFormulario($_POST)) {

                $id_signo =htmlspecialchars($_POST['id_signo']);
                $elemento =htmlspecialchars($_POST['elemetno']);
                $caracteristicasGenerales =htmlspecialchars($_POST['caracteristicaGenerales']);
                $predicciones =htmlspecialchars($_POST['predicciones']);
                $imgHoroscopo =htmlspecialchars($_POST['imgHoroscopo']);
               
                $id = $this->modelo->insertarMarca($id_signo, $elemetno, $caracteristicasGenerales, $predicciones, $imgHoroscopo);
                
                if ($id) {
                    header('Location: ' . BASE_URL . "marca");
                } else {
                    $this->alertaVista->mostrarError("Error al insertar la marca");
                }
            } else {
                $this->alertaVista->mostrarError("Error-El formulario no pudo ser procesado,
                                             asegurate de que hayas completado todos los campos");
            }
        } catch (PDOException $error) {
            $this->alertaVista->mostrarError("Error en la consulta a la base de datos/$error");
        }
    }
 }

