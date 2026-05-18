<?php
// app/controllers/autenticacionController.php

// 
require_once '../app/models/usuario.php';

class autenticacionController
{

    // 1. Muestra el formulario (GET)
    public function mostrarRegistro()
    {
        require_once '../app/views/registroVista.php';
    }

    // 2. Procesa los datos del formulario (POST)
    public function registrar()
    {
        // Recogemos y limpiamos los datos 
        $username = trim($_POST['username'] ?? '');
        $email    = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        // Ciframos la contraseña 
        $password_hash = password_hash($password, PASSWORD_BCRYPT);

        try {
            // Verificamos si el usuario o email ya existen
            if (usuario::existe($email, $username)) {
                $error = "El usuario o el email ya están registrados.";
                // 
                require_once '../app/views/registroVista.php';
            } else {
                // 
                $creado = usuario::crear($username, $email, $password_hash);

                if ($creado) {
                    // Redirigimos de forma limpia al login 
                    header("Location: /login?registro=exito");
                    exit;
                } else {
                    $error = "Hubo un error al crear la cuenta. Inténtalo más tarde.";
                    require_once '../app/views/registroVista.php';
                }
            }
        } catch (PDOException $e) {
            // para capturar los errores
            $error = "Error técnico: " . $e->getMessage();
            require_once '../app/views/registroVista.php';
        }
    }

    // 3. Muestra el formulario de Login (GET)
    public function mostrarLogin()
    {
        require_once '../app/views/loginVista.php';
    }

    // 4. Procesa el inicio de sesión (POST)
    public function login()
    {
        // Recogemos los datos 
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        // Necesitamos buscar al usuario en la base de datos para validar su contraseña
        $db = Database::connect();
        $stmt = $db->prepare("SELECT * FROM usuarios WHERE username = :username");
        $stmt->execute(['username' => $username]);
        $usuario = $stmt->fetch();

        // Si el usuario existe y la contraseña coincide con el hash cifrado...
        if ($usuario && password_verify($password, $usuario['password'])) {
            // Iniciamos la sesión de PHP de forma segura
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            // Guardamos los datos que se necesita en la sesión
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nombre'] = $usuario['username'];
            $_SESSION['usuario_rol'] = $usuario['rol'];

            // Separación "inteligente" de caminos:
            if ($usuario['rol'] === 'admin') {
                header("Location: /admin"); // Si es admin, va a su zona de control
            } else {
                header("Location: /");      // Si es usuario estándar, va al inicio
            }
            exit;
        } else {
            // Si falla, creamos el mensaje de error para la vista
            $error = "El usuario o la contraseña son incorrectos.";
            require_once '../app/views/loginVista.php';
        }
    }

    // 5. Cierra la sesión del usuario (GET)
    public function logout()
    {
        // Nos aseguramos de que la sesión esté iniciada para poder borrarla
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Vaciamos todas las variables de la sesión
        $_SESSION = array();

        // Destruimos la cookie de sesión en el navegador si existe
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        // Destruimos la sesión 
        session_destroy();

        // Redirigimos al login
        header("Location: /");
        exit;
    }
}
