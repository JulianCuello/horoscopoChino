<?php
require_once './app/modelos/modelo.php';

class signoModelo extends Modelo {
    
   function obtenerSignos(){
    
        $query = $this->db->prepare('SELECT * FROM `signo`');
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);       
    }
    
        public function obtenerSignoId($id){
            $query = $this->db->prepare('SELECT * FROM `signo` WHERE id_signo=?');
            $query->execute([$id]);
            return $query->fetch(PDO::FETCH_OBJ); 
    }
    function insertarSigno($id_signo, $elemento, $caracteristicasGenerales, $predicciones, $imgHoroscopo,$animal){
        $query = $this->db->prepare('INSERT INTO signo ($id_signo, $elemento, $caracteristicasGenerales, $predicciones, $imgHoroscopo, $animal) VALUES(?,?,?,?,?,?)');
        $query->execute([$id_signo, $elemento, $caracteristicasGenerales, $predicciones, $imgHoroscopo, $animal]);
        return $this->db->lastInsertId();
    }
    function borrarSigno($id){
        $query = $this->db->prepare('DELETE FROM signo WHERE id_signo = ?');
        $query->execute([$id]);
        return $query->rowCount();
    }
    function modificarSigno($id_signo, $elemento, $caracteristicasGenerales, $predicciones, $imgHoroscopo, $animal){
        $query = $this->db->prepare('UPDATE signo SET id_signo=?,elemento=?,caracteristicasGenerales=?,predicciones=?, imgHoroscopo=?, animal=? WHERE id_signo=?');
        $query->execute([$origen, $caracteristica, $nombreMarca, $imgMarca]);
        return $query->rowCount();
    }
    //consulta para mostrar las categorias disponibles cuando se quiere modificar un producto o categoria
    function obtenerIdSigno(){ 
        $query = $this->db->prepare('SELECT * FROM `signo` WHERE id_signo=?');
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
}

    
