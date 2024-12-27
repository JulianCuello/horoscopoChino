<?php

abstract class Modelo {
    protected $db;

    public function __construct() {
        $this->db = new PDO('mysql:host=' . MYSQL_HOST . ';dbname=' . MYSQL_DB . ';charset=utf8', MYSQL_USER, MYSQL_PASS);
        $this->_deploy();
    }

    private function _deploy() {
        $query = $this->db->query('SHOW TABLES'); // Cambié "mostrar tablas" a "SHOW TABLES"
        $tablas = $query->fetchAll(PDO::FETCH_COLUMN);

        if (count($tablas) == 0) {
            // Crear tablas si no existen
            $sql = <<<END
        SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
        START TRANSACTION;
        SET time_zone = "+00:00";

        CREATE TABLE `juguete` (
          `id_juguete` int(45) NOT NULL AUTO_INCREMENT,
          `nombreProducto` varchar(45) NOT NULL,
          `precio` int(45) NOT NULL,
          `material` varchar(45) NOT NULL,
          `id_marca` int(45) NOT NULL,
          `codigo` int(45) NOT NULL,
          PRIMARY KEY (`id_juguete`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

        CREATE TABLE `marca` (
          `id_marca` int(45) NOT NULL AUTO_INCREMENT,
          `origen` varchar(45) NOT NULL,
          `img` varchar(45) NOT NULL,
          PRIMARY KEY (`id_marca`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

        -- Volcado de datos para la tabla `juguete`
        INSERT INTO `juguete` (`nombreProducto`, `precio`, `material`, `id_marca`, `codigo`) VALUES
        ('autos chiquitos', 4500, 'plastico', 1, 24141),
        ('cocina', 10500, 'acero', 2, 95124),
        ('dinosaurios', 7100, 'goma', 3, 451275),
        ('mario', 6000, 'plastico', 4, 68541);

        -- Volcado de datos para la tabla `marca`
        INSERT INTO `marca` (`origen`, `img`) VALUES
        ('china', 'img/autos'),
        ('argentina', 'img/cocina'),
        ('francia', 'img/dinosaurios'),
        ('brasil', 'img/mario');

        COMMIT;
        END;

                    $this->db->exec($sql); // Cambié query a exec para ejecutar múltiples comandos
                }
            }
        }
