<?php
    require_once './app/modelos/modelo.php';


    class personaModelo extends Modelo{
       
        public function mostrarPersonas(){
            $query = $this->db->prepare('SELECT * FROM persona JOIN signo ON persona.id_signo = signo.id_signo;');
            $query->execute();
            return $query->fetchAll(PDO::FETCH_OBJ);            
        }

        public function seleccionarPersona($id) {
                $query = $this->db->prepare('SELECT * FROM `persona` JOIN signo ON persona.id_signo=signo.id_signo WHERE id_signo = ?');
                $query->execute([$id]);
                return $query->fetchAll(PDO::FETCH_OBJ);
            }
       
            public function obtenerPersonaPorId($id) {
                $query = $this->db->prepare('SELECT * FROM persona JOIN signo ON persona.id_signo = signo.id_signo WHERE persona.id = ?');
                $query->execute([$id]);
                return $query->fetchAll(PDO::FETCH_OBJ);  // Devuelve solo un objeto
            }
    
            function insertarPersona($id, $nombre,$apellido,$diaNacimiento,$mesNacimiento,$anioNacimiento,$horaNacimiento, $imgPersona, $id_signo) {
                $query = $this->db->prepare('INSERT INTO persona ($id, $nombre,$apellido,$diaNacimiento,$mesNacimiento,$anioNacimiento,$horaNacimiento, $imgPersona, $id_signo); VALUES (?, ?, ?, ?, ?, ?,?, ?, ?)');
                $query->execute([$id, $nombre,$apellido,$diaNacimiento,$mesNacimiento,$anioNacimiento,$horaNacimiento, $imgPersona, $id_signo]); // Corrección aquí
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
            $query = $this->db->prepare('DELETE FROM persona WHERE id = ?');
            $query->execute([$id]);
            return $query->rowCount();
        }
    
        function actualizarPersona($id, $nombre,$apellido,$diaNacimiento,$mesNacimiento,$anioNacimiento,$horaNacimiento, $imgPersona, $id_signo){
            $query = $this->db->prepare('UPDATE persona SET nombre=?, apellido=?, diaNacimiento=?, mesNacimiento=?, anioNacimiento=?, horaNacimiento=?, $imgPersona,$id_signo=? WHERE id_juguete=?');
            $query->execute([id, $nombre,$apellido,$diaNacimiento,$mesNacimiento,$anioNacimiento,$horaNacimiento, $imgPersona, $id_signo]); // Asegúrate de que la columna de la base de datos se llame id_juguete
            return $query->rowCount();
        }
    }
