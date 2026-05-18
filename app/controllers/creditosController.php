<?php
// app/controllers/creditosController.php

require_once '../app/models/usuario.php';

class creditosController {
    
    public function mostrarTienda() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $datosUsuario = null;

        // Si está logueado, buscamos sus datos para imprmir su saldo real
        if (isset($_SESSION['usuario_id'])) {
            $datosUsuario = usuario::obtenerPorId($_SESSION['usuario_id']);
        }

        // Cargamos la vista siempre, esté o no logueado
        require_once '../app/views/recargarVista.php';
    }

    // 2. Muestra el formulario de la tarjeta (GET)
    public function mostrarCheckout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['usuario_id'])) {
            header("Location: /login");
            exit;
        }

        // Detectamos qué pack seleccionó en la URL
        $packElegido = $_GET['pack'] ?? '1';
        
        if ($packElegido === '2') {
            $nombrePack = "155 Créditos 🪙 (Pack Ahorro)";
            $precioPack = "20,00 €";
        } else {
            $nombrePack = "50 Créditos 🪙 (Pack Básico)";
            $precioPack = "7,00 €";
        }

        require_once '../app/views/checkoutVista.php';
    }

    // 3. Procesa la transacción e incrementa los créditos reales (POST)
    public function procesarPago() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['usuario_id'])) {
            header("Location: /login");
            exit;
        }

        $packTipo = $_POST['pack_tipo'] ?? '1';
        
        // Asignamos los créditos correspondientes según el pack procesado
        $creditosAsumar = ($packTipo === '2') ? 155 : 50;

        // EJECUTAMOS EL CAMBIO REAL EN LA BASE DE DATOS
        usuario::sumarCreditos($_SESSION['usuario_id'], $creditosAsumar);

        // Redirigimos al usuario a su perfil para que vea su nuevo saldo cargado
        header("Location: /perfil");
        exit;
    }


}