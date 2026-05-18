<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Subir Nuevo Sample </title>
    
    <link rel="stylesheet" href="/assets/css/global.css">
    <link rel="stylesheet" href="/assets/css/admin.css">
</head>
<body>

    <div class="wrapper-formulario">
        <div class="form-container">
            <h2>🎵 Añadir nuevo sonido</h2>
            
            <form action="/admin/nuevo-sample" method="POST">
                <label>Nombre del Sample</label>
                <input type="text" name="nombre" placeholder="Ej. TAINY_81_vocal_loop..." required>

                <label>Ruta del Archivo (.wav)</label>
                <input type="text" name="archivo_url" placeholder="storage/samples/mi_vocal.wav" required>

                <div class="fila-doble">
                    <div>
                        <label>Categoría</label>
                        <select name="id_categoria">
                            <option value="1">Loops (ID 1)</option>
                            <option value="2">Drums (ID 2)</option>
                            <option value="3">Vocals (ID 3)</option>
                            <option value="4">One-Shots (ID 4)</option>
                        </select>
                    </div>
                    <div>
                        <label>Género</label>
                        <select name="id_genero">
                            <option value="1">Trap (ID 1)</option>
                            <option value="2">Techno (ID 2)</option>
                            <option value="3">House (ID 3)</option>
                            <option value="4">Lo-Fi (ID 4)</option>
                            <option value="5">Drill (ID 5)</option>
                        </select>
                    </div>
                </div>

                <div class="fila-doble">
                    <div>
                        <label>BPM</label>
                        <input type="number" name="bpm" placeholder="81" required>
                    </div>
                    <div>
                        <label>Tonalidad</label>
                        <input type="text" name="tonalidad" placeholder="Ej. Am" required>
                    </div>
                </div>

                <div class="fila-doble">
                    <div>
                        <label>Álbum / Pack</label>
                        <select name="id_album">
                            <option value="1">Ultimate Trap Pack (ID 1)</option>
                            <option value="2">TAINY_samplePack (ID 2)</option>
                        </select>
                    </div>
                    <div>
                        <label>Precio (Créditos)</label>
                        <input type="number" name="precio_creditos" value="5" min="1" required>
                    </div>
                </div>

                <button type="submit" class="btn-guardar">🚀 Publicar en el Catálogo</button>
            </form>

            <a href="/admin" class="volver">⬅ Cancelar y Volver al Panel</a>
        </div>
    </div>

</body>
</html>