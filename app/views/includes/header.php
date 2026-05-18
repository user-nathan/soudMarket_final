<?php
// app/views/includes/header.php
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>SoundMarket - Los mejores Samples</title>
    <link rel="stylesheet" href="/assets/css/global.css">
    <?php if (isset($cssEspecifico)): ?>
        <link rel="stylesheet" href="/assets/css/<?php echo $cssEspecifico; ?>">
    <?php endif; ?>
</head>
<body>

    <header class="header">
        <a href="/" class="logo">🎵 SoundMarket</a>
        <nav class="nav-links">
            
            <?php if (isset($_SESSION['usuario_nombre'])): ?>
                <?php 
                    require_once '../app/models/usuario.php';
                    $datosHeader = usuario::obtenerPorId($_SESSION['usuario_id']);
                ?>
                
                <span class="header-creditos">🪙 <?php echo $datosHeader['creditos']; ?> Créditos</span>
                
                <a href="/recargar" class="btn-recargar">Recargar</a>
                <a href="/perfil">Mi Perfil (<?php echo htmlspecialchars($_SESSION['usuario_nombre']); ?>)</a>
                <a href="/logout" style="color: #888;">Cerrar Sesión</a>

            <?php else: ?>
                <a href="/recargar" class="btn-recargar">Recargar</a>
                <a href="/login">Iniciar Sesión</a>
                <a href="/registro" style="color: #00ff88;">Registrarse</a>
            <?php endif; ?>

        </nav>
    </header>

    <main>