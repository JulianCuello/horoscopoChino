<?php
require_once './app/modelos/modelo.php';

class UsuarioModelo extends Modelo{

    public function obtenerPorEmail($email) {
        $query = $this->db->prepare('SELECT * FROM usuarios WHERE email = ?');
        $query->execute([$email]);
        return $query->fetch(PDO::FETCH_OBJ);
        
    }
}