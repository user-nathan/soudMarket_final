<?php
// app/controllers/adminController.php

class adminController {
    
    public function mostrarPanel() {
        if (session_status() === PHP_SESSION_NONE) { session_start(); }

        if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'admin') {
            header("Location: /"); exit;
        }

        // Traemos todos los samples de la base de datos para listarlos
        $db = Database::connect();
        $stmt = $db->query("SELECT id, nombre, bpm, tonalidad, precio_creditos FROM samples");
        $samples = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Pasamos la variable $samples a la vista
        require_once '../app/views/adminVista.php';
    }


    // 1. Muestra el formulario para crear un sample
    public function mostrarFormularioSample() {
        if (session_status() === PHP_SESSION_NONE) { session_start(); }
        
        // Seguridad: Si no es admin, fuera
        if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'admin') {
            header("Location: /");
            exit;
        }

        require_once '../app/views/crearSampleVista.php';
    }

    public function guardarSample() {
        if (session_status() === PHP_SESSION_NONE) { session_start(); }
        if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'admin') {
            header("Location: /");
            exit;
        }

        // Recogemos todo lo enviado desde el formulario dinámico
        $nombre = $_POST['nombre'] ?? '';
        $archivo_url = $_POST['archivo_url'] ?? '';
        $bpm = $_POST['bpm'] ?? 120;
        $tonalidad = $_POST['tonalidad'] ?? 'C Min';
        $id_categoria = $_POST['id_categoria'] ?? 1;
        $id_genero = $_POST['id_genero'] ?? 1;
        $id_album = $_POST['id_album'] ?? 1;
        $precio = $_POST['precio_creditos'] ?? 5;

        // Inserción 
        $db = Database::connect();
        $stmt = $db->prepare("INSERT INTO samples (nombre, archivo_url, bpm, tonalidad, id_categoria, id_genero, id_album, precio_creditos) 
                              VALUES (:nombre, :archivo_url, :bpm, :tonalidad, :id_categoria, :id_genero, :id_album, :precio)");
        
        $stmt->execute([
            'nombre' => $nombre,
            'archivo_url' => $archivo_url,
            'bpm' => $bpm,
            'tonalidad' => $tonalidad,
            'id_categoria' => $id_categoria,
            'id_genero' => $id_genero,
            'id_album' => $id_album,
            'precio' => $precio
        ]);

        header("Location: /admin");
        exit;
    }

    // Muestra el formulario con los datos viejos ya rellenos
    public function mostrarEditarSample() {
        if (session_status() === PHP_SESSION_NONE) { session_start(); }
        if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'admin') { header("Location: /"); exit; }

        $id = $_GET['id'] ?? 0;
        $db = Database::connect();
        $stmt = $db->prepare("SELECT * FROM samples WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $sample = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$sample) { header("Location: /admin"); exit; }

        require_once '../app/views/editarSampleVista.php';
    }

    // Guarda los cambios usando la sentencia UPDATE
    public function actualizarSample() {
        if (session_status() === PHP_SESSION_NONE) { session_start(); }
        if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'admin') { header("Location: /"); exit; }

        $id = $_POST['id'] ?? 0;
        $nombre = $_POST['nombre'] ?? '';
        $archivo_url = $_POST['archivo_url'] ?? '';
        $bpm = $_POST['bpm'] ?? 120;
        $tonalidad = $_POST['tonalidad'] ?? 'C Min';
        $precio = $_POST['precio_creditos'] ?? 5;

        $db = Database::connect();
        $stmt = $db->prepare("UPDATE samples SET nombre = :nombre, archivo_url = :archivo_url, bpm = :bpm, tonalidad = :tonalidad, precio_creditos = :precio WHERE id = :id");
        
        $stmt->execute([
            'nombre' => $nombre,
            'archivo_url' => $archivo_url,
            'bpm' => $bpm,
            'tonalidad' => $tonalidad,
            'precio' => $precio,
            'id' => $id
        ]);

        header("Location: /admin");
        exit;
    }

    // Muestra la pantalla con los 3 formularios
    public function mostrarElementos() {
        if (session_status() === PHP_SESSION_NONE) { session_start(); }
        if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'admin') { header("Location: /"); exit; }
        
        require_once '../app/views/elementosVista.php';
    }

    // Guarda un nuevo álbum/pack
    public function guardarAlbum() {
        if (session_status() === PHP_SESSION_NONE) { session_start(); }
        if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'admin') { header("Location: /"); exit; }

        $nombre = $_POST['nombre'] ?? '';
        $descripcion = $_POST['descripcion'] ?? '';

        $db = Database::connect();
        $stmt = $db->prepare("INSERT INTO albums (nombre, descripcion) VALUES (:nombre, :descripcion)");
        $stmt->execute(['nombre' => $nombre, 'descripcion' => $descripcion]);

        header("Location: /admin/elementos"); exit;
    }

    // Guarda un nuevo género
    public function guardarGenero() {
        if (session_status() === PHP_SESSION_NONE) { session_start(); }
        if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'admin') { header("Location: /"); exit; }

        $nombre = $_POST['nombre'] ?? '';

        $db = Database::connect();
        $stmt = $db->prepare("INSERT INTO generos (nombre) VALUES (:nombre)");
        $stmt->execute(['nombre' => $nombre]);

        header("Location: /admin/elementos"); exit;
    }

    // Guarda una nueva categoría
    public function guardarCategoria() {
        if (session_status() === PHP_SESSION_NONE) { session_start(); }
        if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'admin') { header("Location: /"); exit; }

        $nombre = $_POST['nombre'] ?? '';

        $db = Database::connect();
        $stmt = $db->prepare("INSERT INTO categorias (nombre) VALUES (:nombre)");
        $stmt->execute(['nombre' => $nombre]);

        header("Location: /admin/elementos"); exit;
    }


}