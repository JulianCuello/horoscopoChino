<?php
require_once './app/vistas/signo.vista.php';
require_once './app/vistas/alerta.vista.php';
require_once './app/modelos/signo.modelo.php';
require_once './ayudas/validacion.php';
require_once './ayudas/autorizacion.php';

// Controller de categorias
class signoControlador {
    private $modelo;
    private $modeloPersona;
    private $vista;
    private $alertaVista;

    public function __construct() {
        // Se instancian los dos modelos para no delegar mal, y que cada modelo acceda a su tabla correspondiente.
        $this->modelo = new signoModelo();
        $this->modeloPersona = new personaModelo();
        $this->vista = new signoVista();
        $this->alertaVista = new AlertaVista();
    }

    // Lista marcas completa
    public function mostrarSignos() {
        $signo = $this->modelo->obtenerSignos();
        if ($signo == null) {
            $this->alertaVista->mostrarVacio("No hay elementos para mostrar");
        } else {
            $this->vista->demostrarSignos($signo, Autorizacion::esAdministrador());
        }
    }

    // Lista filtrada
    public function mostrarSignoId($id) {
        if (Validacion::verificacionIdRouter($id)) {
            $signo = $this->modelo->obtenerSignoId($id);
            if ($signo != null) {
                $this->vista->mostrarSignoId($signo); // Verifica que este método exista
            } else {
                $this->alertaVista->mostrarVacio("El signo seleccionado no contiene personas asociadas");
            }
        } else {
            $this->alertaVista->mostrarError("404 - Not Found");
        }
    }

    // Eliminar signo
    public function eliminarSigno($id) {
        Autorizacion::verificacion(); // Verifico permisos y parámetros válidos
        if (Validacion::verificacionIdRouter($id)) {
            try {
                $signoEliminado = $this->modelo->borrarSigno($id);
                if ($signoEliminado > 0) {
                    header('Location: ' . BASE_URL . "signo");
                } else {
                    $this->alertaVista->mostrarError("Error al intentar eliminar");
                }
            } catch (PDOException $e) {
                $this->alertaVista->mostrarError("La marca que intenta eliminar tiene asociados un conjunto de items. Para eliminarla correctamente, deberá eliminar los registros de los items asociados.");
            }
        } else {
            $this->alertaVista->mostrarError("404 - Not Found");
        }
    }

    // Mostrar formulario modificación
    public function mostrarFormularioSigno($id = null) {
        Autorizacion::verificacion(); // Verifico permisos y parámetros válidos

        // Si el $id es proporcionado, busco el signo para editarlo, si no, creo un nuevo formulario
        if ($id !== null && Validacion::verificacionIdRouter($id)) {
            $signo = $this->modelo->obtenerSignoId($id); // Consulto los datos actuales
            if ($signo == null) {
                $this->alertaVista->mostrarError("Error al intentar mostrar formulario");
                return;
            }
        } else {
            // Si no se pasa ID, se muestra el formulario para agregar un nuevo signo
            $signo = null;
        }
        $this->vista->mostrarFormularioSigno($signo);
    }

    // Enviar datos de modificación
    public function mostrarSignoModificado() {
        Autorizacion::verificacion();
        try {
            // Verifico permisos, parámetros válidos y posible acceso sin previo acceso al formulario de modificación.
            if ($_POST && Validacion::verificacionFormulario($_POST)) {
                $id_signo = htmlspecialchars($_POST['id_signo']);
                $elemento = htmlspecialchars($_POST['elemento']);
                $caracteristicasGenerales = htmlspecialchars($_POST['caracteristicasGenerales']);
                $predicciones = htmlspecialchars($_POST['predicciones']);
                $imgHoroscopo = htmlspecialchars($_POST['imgHoroscopo']);

                $signoModificado = $this->modelo->modificacionSigno($id_signo, $elemento, $caracteristicasGenerales, $predicciones, $imgHoroscopo);
                if ($signoModificado > 0) {
                    header('Location: ' . BASE_URL . "signo");
                } else {
                    $this->alertaVista->mostrarError("No se pudo actualizar el signo");
                }
            }
        } catch (PDOException $error) {
            $this->alertaVista->mostrarError("Error en la consulta a la base de datos: $error");
        }
    }

    // Agregar signo
    public function agregarSigno() {
        Autorizacion::verificacion();
        try {
            if ($_POST && Validacion::verificacionFormulario($_POST)) {
                $id_signo = htmlspecialchars($_POST['id_signo']);
                $elemento = htmlspecialchars($_POST['elemento']);
                $caracteristicasGenerales = htmlspecialchars($_POST['caracteristicasGenerales']);
                $predicciones = htmlspecialchars($_POST['predicciones']);
                $imgHoroscopo = htmlspecialchars($_POST['imgHoroscopo']);

                $id = $this->modelo->insertarSigno($id_signo, $elemento, $caracteristicasGenerales, $predicciones, $imgHoroscopo);

                if ($id) {
                    header('Location: ' . BASE_URL . "signo");
                } else {
                    $this->alertaVista->mostrarError("Error al insertar el signo");
                }
            } else {
                $this->alertaVista->mostrarError("Error: El formulario no pudo ser procesado. Asegúrate de que hayas completado todos los campos.");
            }
        } catch (PDOException $error) {
            $this->alertaVista->mostrarError("Error en la consulta a la base de datos: $error");
        }
    }
}
?>
