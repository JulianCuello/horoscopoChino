<?php

class Autorizacion {

    public static function inicio() {
        if (session_status() != PHP_SESSION_ACTIVE) {//nos evita que se inicien 2 veces las mismas sessiones
            session_start();//funcion estatica que se puede consultar desde cualquier seccion
        }
    }

    public static function inicioSesion($usuario) {
        Autorizacion::inicio();//se ejecuta el metodo para chequear si ya esta iniciada o no
        $_SESSION['USER_ID'] = $usuario->id;//session toma los valores para poder consultar cada vez que se necesite 
        $_SESSION['USER_EMAIL'] = $usuario->email; //dar las autorizaciones
    }

    public static function cerrarSesion() {
        Autorizacion::inicio();//lo mismo para el logout
        session_destroy();
    }

    public static function verificacion() {//verifica que el usuario este logueado para cualquier acceso a secciones que intente
        Autorizacion::inicio();//ingresa si se conceden permisos
        if (!isset($_SESSION['USER_ID'])) {//si no hay usuario significa que hay que redirigirlo a login
            header('Location: ' . BASE_URL . 'inicioSesion');
            die();
        }
    }

    public static function esAdministrador() {//verifica que el usuario este logueado para cualquier acceso a secciones que intente
        Autorizacion::inicio();//ingresar, si se le conceden los permisos.
        if (isset($_SESSION['USER_ID'])) {
            return true;
        }else{
            return false;
        }   
    }
}