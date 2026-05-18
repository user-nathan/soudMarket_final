<?php
// app/controllers/homeController.php

class homeController {
    
    public function index() {
        // Aseguramos el estado de la sesión para comprobar si el usuario está dentro
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // 1. Conectamos a la base de datos
        $db = Database::connect();

        // 2. Recogemos los 4 parámetros GET de la barra de filtros
        $categoria = $_GET['categoria'] ?? '';
        $genero    = $_GET['genero'] ?? '';
        $bpm       = $_GET['bpm'] ?? '';
        $tono      = $_GET['tono'] ?? '';

        // ¿El usuario está usando el buscador o la URL está limpia?
        $busquedaActiva = !empty($categoria) || !empty($genero) || !empty($bpm) || !empty($tono);

        // Inicializamos los arrays vacíos
        $albums = [];
        $samples = [];

        if (!$busquedaActiva) {
            // ========================================================
            // ESTADO A: SIN FILTROS -> CARGAMOS TODAS LAS LIBRERÍAS
            // ========================================================
            $sqlAlbums = "SELECT id, nombre, descripcion, portada_url FROM albums ORDER BY id DESC";
            $stmtAlbums = $db->prepare($sqlAlbums);
            $stmtAlbums->execute();
            $albums = $stmtAlbums->fetchAll(PDO::FETCH_ASSOC);

        } else {
            // ========================================================
            // ESTADO B: CON FILTROS -> BUSCAMOS SAMPLES INDIVIDUALES
            // ========================================================
            $sql = "SELECT s.id, s.nombre AS sample_nombre, s.archivo_url, s.bpm, s.tonalidad, s.precio_creditos, s.id_album,
                           a.nombre AS album_nombre
                    FROM samples s
                    LEFT JOIN albums a ON s.id_album = a.id
                    LEFT JOIN categorias c ON s.id_categoria = c.id
                    LEFT JOIN generos g ON s.id_genero = g.id
                    WHERE 1=1";
                    
            $params = [];

            // Filtro por Nombre de la Categoría
            if (!empty($categoria)) {
                $sql .= " AND c.nombre = :categoria";
                $params['categoria'] = $categoria;
            }

            // Filtro por Nombre del Género
            if (!empty($genero)) {
                $sql .= " AND g.nombre = :genero";
                $params['genero'] = $genero;
            }

            // Filtro por BPM 
            if (!empty($bpm)) {
                $sql .= " AND s.bpm = :bpm";
                $params['bpm'] = (int)$bpm;
            }

            // Filtro por Tonalidad
            if (!empty($tono)) {
                $sql .= " AND s.tonalidad LIKE :tono";
                $params['tono'] = '%' . $tono . '%';
            }

            $sql .= " ORDER BY s.id DESC";

            $stmt = $db->prepare($sql);
            $stmt->execute($params);
            $samples = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        // 9. Llamamos a la vista pasándole el control de lo que se va a renderizar
        require_once '../app/views/homeVista.php';
    }


    public function mostrarLibreria() {
        if (session_status() === PHP_SESSION_NONE) { session_start(); }

        // 1. Capturamos el ID del pack que viene por la URL
        $id_album = $_GET['id'] ?? 0;

        if ($id_album == 0) {
            header("Location: /"); exit;
        }

        $db = Database::connect();

        // 2. Buscamos los datos del Álbum/Pack
        $stmtAlbum = $db->prepare("SELECT nombre, descripcion, portada_url FROM albums WHERE id = :id");
        $stmtAlbum->execute(['id' => $id_album]);
        $album = $stmtAlbum->fetch(PDO::FETCH_ASSOC);

        if (!$album) {
            header("Location: /"); exit; 
        }

        // 3. Usamos 'id_album' 
        $stmtSamples = $db->prepare("SELECT id, nombre, archivo_url, bpm, tonalidad, precio_creditos FROM samples WHERE id_album = :id_album ORDER BY id DESC");
        $stmtSamples->execute(['id_album' => $id_album]);
        $samples = $stmtSamples->fetchAll(PDO::FETCH_ASSOC);

        // 4. Cargamos la vista
        require_once '../app/views/libreriaVista.php';
    }

    public function descargarSample() {
        if (session_status() === PHP_SESSION_NONE) { session_start(); }

        // 1. Si no está logueado, no puede descargar
        if (!isset($_SESSION['usuario_id'])) {
            die("Debes iniciar sesión para descargar samples.");
        }

        $id_usuario = $_SESSION['usuario_id'];
        $id_sample = $_GET['id'] ?? 0;

        $db = Database::connect();

        // 2. Obtener los datos del sample y su precio
        $stmtSample = $db->prepare("SELECT nombre, archivo_url, precio_creditos FROM samples WHERE id = :id");
        $stmtSample->execute(['id' => $id_sample]);
        $sample = $stmtSample->fetch(PDO::FETCH_ASSOC);

        if (!$sample) { die("El sample solicitado no existe."); }

        // 3. Obtener los créditos actuales del usuario
        $stmtUser = $db->prepare("SELECT creditos FROM usuarios WHERE id = :id");
        $stmtUser->execute(['id' => $id_usuario]);
        $usuario = $stmtUser->fetch(PDO::FETCH_ASSOC);

        // 4. ¿Tiene suficientes créditos?
        if ($usuario['creditos'] < $sample['precio_creditos']) {
            die("No tienes suficientes créditos en tu monedero para este sample.");
        }

        // 5. TRANSACCIÓN EN LA BASE DE DATOS
        $db->beginTransaction();
        try {
            // Restar los créditos al usuario
            $nuevos_creditos = $usuario['creditos'] - $sample['precio_creditos'];
            $stmtRestar = $db->prepare("UPDATE usuarios SET creditos = :creditos WHERE id = :id");
            $stmtRestar->execute(['creditos' => $nuevos_creditos, 'id' => $id_usuario]);

            // Guardar en el historial de compras
            $stmtCompra = $db->prepare("INSERT INTO compras (id_usuario, id_sample) VALUES (:id_usuario, :id_sample)");
            $stmtCompra->execute(['id_usuario' => $id_usuario, 'id_sample' => $id_sample]);

            // Si todo va bien, guardamos los cambios en MySQL
            $db->commit();
        } catch (Exception $e) {
            $db->rollBack();
            die("Error al procesar la transacción.");
        }

        // 6. FORZAR DESCARGA DEL ARCHIVO REAL
        $rutaFisicaArchivo = $_SERVER['DOCUMENT_ROOT'] . '/' . $sample['archivo_url'];

        if (file_exists($rutaFisicaArchivo)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($rutaFisicaArchivo) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($rutaFisicaArchivo));
            
            flush(); 
            readfile($rutaFisicaArchivo);
            exit;
        } else {
            die("El archivo físico de audio no se encuentra en el servidor.");
        }
    }
}