<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administración - SoundMarket</title>
    
    <link rel="stylesheet" href="/assets/css/global.css">
    <link rel="stylesheet" href="/assets/css/admin.css">
</head>
<body>

    <header class="admin-header">
        <a href="/admin" class="admin-logo">🛡️ PANEL ADMIN // SoundMarket</a>
        <nav class="admin-nav">
            <span class="sesion-info">Sesión: <?php echo htmlspecialchars($_SESSION['usuario_nombre']); ?></span>
            <a href="/">Ir a la Web Pública</a>
            <a href="/logout" style="color: #fe2c55;">Cerrar Sesión</a>
        </nav>
    </header>

    <div class="admin-container">
        <h1>Bienvenido al Panel de Control</h1>
        <p class="subtitulo">Desde aquí puedes gestionar el catálogo de samples musical y supervisar los movimientos de la plataforma.</p>
        
        <div class="grid-acciones">
            
            <div class="tarjeta-control">
                <h3>🎵 Gestionar Samples</h3>
                <p>Sube nuevos paquetes de sonidos, loops o efectos a la plataforma y asigna sus precios en créditos.</p>
                <a href="/admin/nuevo-sample" class="btn-admin">Subir Nuevo Sample</a>
            </div>

            <div class="tarjeta-control">
                <h3>👥 Gestionar/Crear Albumes</h3>
                <p>Visualiza la lista de productores registrados, edita sus roles o ajusta sus monederos manualmente.</p>
                <a href="/admin/elementos" class="btn-admin btn-secundario">Gestionar Álbumes / Géneros</a>
            </div>

            <div class="tarjeta-control">
                <h3>📈 Ventas e Historial</h3>
                <p>Revisa el registro de transacciones de créditos y qué samples se están descargando más.</p>
                <a href="#" class="btn-admin btn-secundario">Ver Reportes</a>
            </div>
        </div>

        <h2 class="seccion-titulo">📋 Inventario de Samples</h2>
        
        <table class="tabla-admin">
            <tr class="header-tabla">
                <th>Nombre</th>
                <th>BPM</th>
                <th>Tonalidad</th>
                <th>Precio</th>
                <th>Acciones</th>
            </tr>
            
            <?php foreach ($samples as $s): ?>
            <tr class="fila-datos">
                <td><?php echo htmlspecialchars($s['nombre']); ?></td>
                <td><?php echo $s['bpm']; ?></td>
                <td><?php echo htmlspecialchars($s['tonalidad']); ?></td>
                <td class="precio-token"><?php echo $s['precio_creditos']; ?> 🪙</td>
                <td>
                    <a href="/admin/editar-sample?id=<?php echo $s['id']; ?>" class="link-editar">[✏️ Editar]</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>

    </div>

</body>
</html>