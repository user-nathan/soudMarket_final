<?php
// app/core/Database.php

class Database {
    private static $connection = null;

    public static function connect() {
        // si ya existe la conexión, no la duplica
        if (self::$connection === null) {
            
            // CONFIGURACIÓN DE CONEXIÓN
            $host    = 'localhost';
            $db      = 'samples_tienda'; // Tu base de datos
            $user    = 'root';        // Tu usuario de MySQL
            $pass    = 'jonathan'; // <-- Pon aquí tu contraseña real
            $charset = 'utf8mb4';

            // configuración de PDO
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, 
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       
                PDO::ATTR_EMULATE_PREPARES   => false,                  
            ];

            $dsn = "mysql:host=$host;dbname=$db;charset=$charset";

            try {
                // Creamos la conexión y la guardamos 
                self::$connection = new PDO($dsn, $user, $pass, $options);
            } catch (\PDOException $e) {
                // manejo de errores 
                die("Error de conexión a la base de datos: " . $e->getMessage());
            }
        }

        // Devolvemos la conexión limpia
        return self::$connection;
    }
}