<?php
    require_once './app/modelos/modelo.php';


    class personaModelo extends Modelo{
       
        public function mostrarPersonas(){
            $query = $this->db->prepare('SELECT * FROM persona JOIN signo ON persona.id_signo = marca.id_signo;');
            $query->execute();
            return $query->fetchAll(PDO::FETCH_OBJ);            
        }

        public function seleccionarPersona($id) {
                $query = $this->db->prepare('SELECT * FROM `juguete` JOIN marca ON juguete.id_marca=marca.id_marca WHERE id_marca = ?');
                $query->execute([$id]);
                return $query->fetchAll(PDO::FETCH_OBJ);
            }
       
            public function obtenerPersonaPorId($id) {
                $query = $this->db->prepare('SELECT * FROM juguete JOIN marca ON juguete.id_marca = marca.id_marca WHERE juguete.id_juguete = ?');
                $query->execute([$id]);
                return $query->fetchAll(PDO::FETCH_OBJ);  // Devuelve solo un objeto
            }
            

            function insertarPersona($nombreProducto, $precio, $material, $id_marca, $codigo, $img) {
                $query = $this->db->prepare('INSERT INTO juguete (nombreProducto, precio, material, id_marca, codigo, img) VALUES (?, ?, ?, ?, ?, ?)');
                $query->execute([$nombreProducto, $precio, $material, $id_marca, $codigo, $img]); // Corrección aquí
                return $this->db->lastInsertId();
            }
            /*
            public function obtenerSignoId($id) {
                $query = $this->db->prepare('SELECT * FROM `marca` WHERE id_marca=?');
                $query->execute([$id]);
                return $query->fetch(PDO::FETCH_OBJ); 
            }
        */
        public function borrarPersona($id) {
            $query = $this->db->prepare('DELETE FROM juguete WHERE id_juguete = ?');
            $query->execute([$id]);
            return $query->rowCount();
        }
    
        function actualizarPersona($id_juguete, $nombreProducto, $precio, $material, $codigo, $img){
            $query = $this->db->prepare('UPDATE juguete SET nombreProducto=?, precio=?, material=?, codigo=?, img=? WHERE id_juguete=?');
            $query->execute([$nombreProducto, $precio, $material, $codigo, $img, $id_juguete]); // Asegúrate de que la columna de la base de datos se llame id_juguete
            return $query->rowCount();
        }
        
    }
