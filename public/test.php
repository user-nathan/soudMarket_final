<?php
// test.php
require_once 'app/core/database.php';
require_once 'app/models/usuario.php';

try {
    // Probamos si el modelo puede buscar en la tabla "usuarios"
    // Buscaremos un correo falso para ver si la consulta corre sin errores
    $comprobacion = Usuario::existe('correo_prueba_falso@test.com', 'usuario_falso');
    
    echo "<h1>¡Paso 4 Completado con éxito!</h1>";
    echo "<p>El Modelo 'Usuario' se comunica con la base de datos PDO de forma excelente.</p>";
    
} catch (PDOException $e) {
    echo "<h1>Error en el Modelo o la Base de Datos:</h1>";
    echo "<p>" . $e->getMessage() . "</p>";
}