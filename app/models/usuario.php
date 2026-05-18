<?php
// app/models/Usuario.php

class Usuario {
    
    // 1. Verificar si el correo o el nombre de usuario ya existen en la base de datos
    public static function existe($email, $username) {
        // Nos conectamos usando tu clase Database con PDO
        $db = Database::connect();
        
        // Preparamos la consulta con parámetros nombrados (muy seguro contra Inyección SQL)
        $stmt = $db->prepare("SELECT id FROM usuarios WHERE email = :email OR username = :username");
        
        // Ejecutamos pasando los datos reales
        $stmt->execute([
            'email'    => $email,
            'username' => $username
        ]);
        
        // rowCount() nos dice cuántas filas encontró. Si es mayor a 0, es que ya existe.
        return $stmt->rowCount() > 0;
    }

    // 2. Insertar el nuevo usuario en la base de datos
    public static function crear($username, $email, $passwordCifrada) {
        $db = Database::connect();
        
        $stmt = $db->prepare("INSERT INTO usuarios (username, email, password) VALUES (:username, :email, :password)");
        
        $resultado = $stmt->execute([
            'username' => $username,
            'email'    => $email,
            'password' => $passwordCifrada
        ]);
        
        // Devuelve true si se insertó correctamente, o false si hubo un problema
        return $resultado;
    }

    // 3. Obtener todos los datos de un usuario usando su ID 
    public static function obtenerPorId($id) {
        $db = Database::connect();
        
        // Usamos los nombres exactos de tus columnas
        $stmt = $db->prepare("SELECT id, username, email, rol, creditos, plan, fecha_registro FROM usuarios WHERE id = :id");
        $stmt->execute(['id' => $id]);
        
        return $stmt->fetch();
    }

    // 4. Sumar créditos al monedero de un usuario tras una compra exitosa
    public static function sumarCreditos($idUsuario, $cantidadAñadir) {
        $db = Database::connect();
        
        // Sumamos los créditos nuevos a los que ya tiene acumulados en la BD
        $stmt = $db->prepare("UPDATE usuarios SET creditos = creditos + :cantidad WHERE id = :id");
        return $stmt->execute([
            'cantidad' => $cantidadAñadir,
            'id' => $idUsuario
        ]);
    }



}