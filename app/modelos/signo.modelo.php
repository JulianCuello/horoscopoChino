<?php
require_once './app/modelos/modelo.php';

class signoModelo extends Modelo {
    
   function obtenerSignos(){
    
        $query = $this->db->prepare('SELECT * FROM `marca`');
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);       
    }
    
        public function obtenerSignoId($id){
            $query = $this->db->prepare('SELECT * FROM `marca` WHERE id_marca=?');
            $query->execute([$id]);
            return $query->fetch(PDO::FETCH_OBJ); 
    }
    function insertarSigno($origen, $caracteristica, $nombreMarca, $imgMarca){
        $query = $this->db->prepare('INSERT INTO marca (origen, caracteristica, nombreMarca, imgMarca) VALUES(?,?,?,?)');
        $query->execute([$origen, $caracteristica, $nombreMarca, $imgMarca]);
        return $this->db->lastInsertId();
    }
    function borrarSigno($id){
        $query = $this->db->prepare('DELETE FROM marca WHERE id_marca = ?');
        $query->execute([$id]);
        return $query->rowCount();
    }
    function modificarSigno($id_marca, $origen, $caracteristica,$nombreMarca, $imgMarca){
        $query = $this->db->prepare('UPDATE marca SET origen=?,caracteristica=?,nombreMarca=?,imgMarca=? WHERE id_marca=?');
        $query->execute([$origen, $caracteristica, $nombreMarca, $imgMarca]);
        return $query->rowCount();
    }
    //consulta para mostrar las categorias disponibles cuando se quiere modificar un producto o categoria
    function obtenerIdSigno(){ 
        $query = $this->db->prepare('SELECT * FROM `marca` WHERE id_marca=?');
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
}

    
