<?php
    require_once './app/modelos/modelo.php';

    class personaModelo extends Modelo {

        function mostrarPersonas() {
            $query = $this->db->prepare('SELECT * FROM persona JOIN signo ON persona.id_signo = signo.id_signo;');
            $query->execute();
            return $query->fetchAll(PDO::FETCH_OBJ);            
        }

        function seleccionarPersona($id) {
            $query = $this->db->prepare('SELECT * FROM `persona` JOIN signo ON persona.id_signo = signo.id_signo WHERE id_signo = ?');
            $query->execute([$id]);
            return $query->fetchAll(PDO::FETCH_OBJ);
        }

        function obtenerPersonaPorId($id) {
            $query = $this->db->prepare('SELECT * FROM persona JOIN signo ON persona.id_signo = signo.id_signo WHERE persona.id = ?');
            $query->execute([$id]);
            return $query->fetchAll(PDO::FETCH_OBJ);  // Devuelve solo un objeto
        }

        // Método corregido para insertar una persona
        function insertarPersona($nombre, $apellido, $diaNacimiento, $mesNacimiento, $anioNacimiento, $horaNacimiento, $imgPersona, $id_signo) {
            // Eliminamos el parámetro 'id' de la consulta
            $query = $this->db->prepare('INSERT INTO persona (nombre, apellido, diaNacimiento, mesNacimiento, anioNacimiento, horaNacimiento, imgPersona, id_signo) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
            $query->execute([$nombre, $apellido, $diaNacimiento, $mesNacimiento, $anioNacimiento, $horaNacimiento, $imgPersona, $id_signo]);
            
            // Devolvemos el ID de la última inserción (sin necesidad de pasar el 'id')
            return $this->db->lastInsertId();
        }
        
        
        // Método corregido para obtener signo por ID
        function obtenerSignoId($id) {
            $query = $this->db->prepare('SELECT * FROM `signo` WHERE id_signo = ?');
            $query->execute([$id]);
            return $query->fetch(PDO::FETCH_OBJ); 
        }

        // Método para borrar una persona
        function borrarPersona($id) {
            $query = $this->db->prepare('DELETE FROM persona WHERE id = ?');
            $query->execute([$id]);
            return $query->rowCount();
        }

        // Método corregido para actualizar una persona
        function actualizarPersona($id, $nombre, $apellido, $diaNacimiento, $mesNacimiento, $anioNacimiento, $horaNacimiento, $imgPersona, $id_signo) {
            $query = $this->db->prepare('UPDATE persona SET nombre=?, apellido=?, diaNacimiento=?, mesNacimiento=?, anioNacimiento=?, horaNacimiento=?, imgPersona=?, id_signo=? WHERE id=?');
            $query->execute([$nombre, $apellido, $diaNacimiento, $mesNacimiento, $anioNacimiento, $horaNacimiento, $imgPersona, $id_signo, $id]); 
        }
    }
