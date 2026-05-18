<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Sample - SoundMarket</title>
    
    <link rel="stylesheet" href="/assets/css/global.css">
    <link rel="stylesheet" href="/assets/css/admin.css">
</head>
<body>

    <div class="wrapper-formulario">
        <div class="form-container">
            <h2>✏️ Editar Sample #<?php echo $sample['id']; ?></h2>
            
            <form action="/admin/editar-sample" method="POST">
                <input type="hidden" name="id" value="<?php echo $sample['id']; ?>">

                <label>Nombre del Sample</label>
                <input type="text" name="nombre" value="<?php echo htmlspecialchars($sample['nombre']); ?>" required>

                <label>Ruta del Archivo (.wav)</label>
                <input type="text" name="archivo_url" value="<?php echo htmlspecialchars($sample['archivo_url']); ?>" required>

                <div class="fila-doble">
                    <div>
                        <label>BPM</label>
                        <input type="number" name="bpm" value="<?php echo $sample['bpm']; ?>" required>
                    </div>
                    <div>
                        <label>Tonalidad</label>
                        <input type="text" name="tonalidad" value="<?php echo htmlspecialchars($sample['tonalidad']); ?>" required>
                    </div>
                </div>

                <label>Precio (Créditos)</label>
                <input type="number" name="precio_creditos" value="<?php echo $sample['precio_creditos']; ?>" required>

                <button type="submit" class="btn-guardar">💾 Guardar Cambios</button>
            </form>

            <a href="/admin" class="volver">⬅ Cancelar y Volver</a>
        </div>
    </div>

</body>
</html>