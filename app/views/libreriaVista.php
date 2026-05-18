<?php 
// app/views/libreriaVista.php

// Inyectamos la cabecera común
require_once '../app/views/includes/header.php'; 
?>

<link rel="stylesheet" href="/assets/css/libreria.css">

<div class="seccion-libreria">

    <a href="/" class="btn-volver">⬅ Volver al Buscador</a>
    
    <div class="cabecera-pack">
        <img src="/storage/portadas/<?php echo !empty($album['portada_url']) ? $album['portada_url'] : 'default_album.png'; ?>" 
             alt="Portada de <?php echo htmlspecialchars($album['nombre']); ?>" 
             class="portada-pack">
        
        <div class="info-pack">
            <h1>💽 <?php echo htmlspecialchars($album['nombre']); ?></h1>
            <p><?php echo htmlspecialchars($album['descripcion'] ?? 'Explora los sonidos exclusivos de esta librería.'); ?></p>
        </div>
    </div>

    <div class="lista-samples">
        <?php if (empty($samples)): ?>
            <p class="lista-samples-vacia">Esta librería aún no contiene archivos de audio.</p>
        <?php else: ?>
            
            <?php foreach ($samples as $sample): ?>
                <div class="sample-item">
                    
                    <div class="info-audio">
                        <strong><?php echo htmlspecialchars($sample['nombre']); ?></strong>
                        <span>BPM: <?php echo $sample['bpm'] ?? 'N/A'; ?></span>
                        <span>Tonalidad: <?php echo htmlspecialchars($sample['tonalidad'] ?? 'N/A'); ?></span>
                    </div>

                    <div class="controles-audio">
                        <audio controls src="/<?php echo htmlspecialchars($sample['archivo_url']); ?>"></audio>

                        <a href="/libreria/descargar?id=<?php echo $sample['id']; ?>" class="btn-comprar-sample">
                            🛒 Obtener (<?php echo $sample['precio_creditos']; ?> 🪙)
                        </a>
                    </div>

                </div>
            <?php endforeach; ?>

        <?php endif; ?>
    </div>

</div>

<?php 
// Inyectamos el pie de página común
require_once '../app/views/includes/footer.php'; 
?>