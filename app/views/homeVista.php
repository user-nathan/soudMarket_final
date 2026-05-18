<?php 
// app/views/homeVista.php

// Inyectamos la cabecera global el menú y los estilos
require_once '../app/views/includes/header.php'; 

// REVISIÓN DE FILTROS: Evaluamos si el usuario ha enviado alguna búsqueda
$busquedaActiva = !empty($_GET['categoria']) || !empty($_GET['genero']) || !empty($_GET['bpm']) || !empty($_GET['tono']);
?>

<link rel="stylesheet" href="/assets/css/home.css">

<div class="contenedor-principal">

    <form action="/" method="GET" class="form-filtros">
        
        <div class="filtro-grupo">
            <label>📁 Categoría</label>
            <select name="categoria">
                <option value="">Todas</option>
                <option value="Loops" <?php echo (($_GET['categoria'] ?? '') === 'Loops') ? 'selected' : ''; ?>>Loops</option>
                <option value="Drums" <?php echo (($_GET['categoria'] ?? '') === 'Drums') ? 'selected' : ''; ?>>Drums</option>
                <option value="Vocals" <?php echo (($_GET['categoria'] ?? '') === 'Vocals') ? 'selected' : ''; ?>>Vocals</option>
                <option value="One-Shots" <?php echo (($_GET['categoria'] ?? '') === 'One-Shots') ? 'selected' : ''; ?>>One-Shots</option>
            </select>
        </div>

        <div class="filtro-grupo">
            <label>🎵 Género</label>
            <select name="genero">
                <option value="">Todos</option>
                <option value="Trap" <?php echo (($_GET['genero'] ?? '') === 'Trap') ? 'selected' : ''; ?>>Trap</option>
                <option value="Techno" <?php echo (($_GET['genero'] ?? '') === 'Techno') ? 'selected' : ''; ?>>Techno</option>
                <option value="House" <?php echo (($_GET['genero'] ?? '') === 'House') ? 'selected' : ''; ?>>House</option>
                <option value="Lo-Fi" <?php echo (($_GET['genero'] ?? '') === 'Lo-Fi') ? 'selected' : ''; ?>>Lo-Fi</option>
                <option value="Drill" <?php echo (($_GET['genero'] ?? '') === 'Drill') ? 'selected' : ''; ?>>Drill</option>
            </select>
        </div>

        <div class="filtro-grupo-corto">
            <label>⚡ BPM</label>
            <input type="number" name="bpm" value="<?php echo htmlspecialchars($_GET['bpm'] ?? ''); ?>" placeholder="Ej: 140">
        </div>

        <div class="filtro-grupo-corto">
            <label>🎹 Tono</label>
            <input type="text" name="tono" value="<?php echo htmlspecialchars($_GET['tono'] ?? ''); ?>" placeholder="Ej: C, Am">
        </div>

        <div class="contenedor-botones-filtro">
            <button type="submit" class="btn-filtrar">🔍 Filtrar</button>
            <button type="button" onclick="limpiarYEnviar()" class="btn-limpiar">
                🔄 Limpiar Filtros
            </button>
        </div>

    </form>

    <?php if (!$busquedaActiva): ?>
        <h2 class="titulo-seccion">🔥 Librerías Disponibles</h2>
        <!-- <p class="subtitulo-seccion">Explora los packs completos </p> -->

        <div class="grid-librerias">
            <?php if (empty($albums)): ?>
                <p class="texto-vacio-grid">No hay librerías cargadas en el catálogo.</p>
            <?php else: ?>
                <?php foreach ($albums as $album): ?>
                    <div class="tarjeta-pack">
                        <div class="portada-contenedor">
                            <img src="/storage/portadas/<?php echo !empty($album['portada_url']) ? $album['portada_url'] : 'default_album.png'; ?>" 
                                 alt="Portada" class="portada-img">
                        </div>
                        <div class="tarjeta-cuerpo">
                            <h3><?php echo htmlspecialchars($album['nombre']); ?></h3>
                            <p><?php echo htmlspecialchars($album['descripcion'] ?? 'Sin descripción.'); ?></p>
                            <a href="/libreria?id=<?php echo $album['id']; ?>" class="btn-ver-pack">
                                👁 Ver Pack
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

    <?php else: ?>
        <h2 class="titulo-seccion">🔍 Resultados de la Búsqueda</h2>
        <p class="subtitulo-seccion">Muestras de audio individuales que coinciden con tus filtros</p>

        <div>
            <?php if (empty($samples)): ?>
                <p class="resultado-vacio-caja">
                    Ningún sample individual coincide con los filtros seleccionados.
                </p>
            <?php else: ?>
                <?php foreach ($samples as $item): ?>
                    <div class="sample-row">
                        <div class="sample-info-bloque">
                            <span class="sample-titulo">
                                <?php echo htmlspecialchars($item['sample_nombre']); ?>
                            </span>
                            <div class="sample-meta">
                                <?php if (!empty($item['id_album'])): ?>
                                    <a href="/libreria?id=<?php echo $item['id_album']; ?>" class="link-pack">
                                        💽 Pack: <?php echo htmlspecialchars($item['album_nombre']); ?>
                                    </a>
                                <?php endif; ?>
                                <span class="badge-audio">BPM: <?php echo $item['bpm'] ?? 'N/A'; ?></span>
                                <span class="badge-audio">Tono: <?php echo htmlspecialchars($item['tonalidad'] ?? 'N/A'); ?></span>
                            </div>
                        </div>
                        <div class="player-container">
                            <audio controls src="/<?php echo htmlspecialchars($item['archivo_url']); ?>"></audio>
                            <a href="/libreria/descargar?id=<?php echo $item['id']; ?>" class="btn-canjear">
                                🛒 Canjear (<?php echo $item['precio_creditos']; ?> 🪙)
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    <?php endif; ?>

</div>

<script src="/assets/js/home.js"></script>

<?php 
// Inyectamos el cierre estructural de la página
require_once '../app/views/includes/footer.php'; 
?>