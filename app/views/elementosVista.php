<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestionar Estructura - SoundMarket</title>
    <style>
        body { font-family: sans-serif; background: #121212; color: #fff; padding: 40px; margin: 0; }
        .btn-volver { color: #fe2c55; text-decoration: none; font-weight: bold; display: inline-block; margin-bottom: 20px; }
        h1 { color: #fff; margin-bottom: 30px; }
        .grid-formularios { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px; }
        .caja-form { background: #1e1e1e; border: 1px solid #333; padding: 25px; border-radius: 8px; }
        .caja-form h3 { margin-top: 0; color: #fe2c55; border-bottom: 1px solid #333; padding-bottom: 10px; }
        label { display: block; font-size: 12px; color: #aaa; margin: 15px 0 5px 0; text-transform: uppercase; }
        input, textarea { display: block; width: 100%; padding: 10px; box-sizing: border-box; background: #333; color: #fff; border: 1px solid #555; border-radius: 4px; }
        .btn-crear { background: #00ff88; color: #000; border: none; padding: 10px; width: 100%; font-weight: bold; margin-top: 20px; cursor: pointer; border-radius: 4px; transition: 0.2s; }
        .btn-crear:hover { background: #00cc6e; }
    </style>
</head>
<body>

    <a href="/admin" class="btn-volver">⬅ Volver al Panel de Control</a>
    <h1>Organización del Catálogo Musical</h1>

    <div class="grid-formularios">

        <div class="caja-form">
            <h3>💽 Crear Álbum / Sample Pack</h3>
            <form action="/admin/nuevo-album" method="POST">
                <label>Nombre del Pack</label>
                <input type="text" name="nombre" placeholder="Ej. TAINY_samplePack" required>

                <label>Descripción</label>
                <textarea name="descripcion" rows="3" placeholder="Breve descripción de los sonidos..."></textarea>

                <button type="submit" class="btn-crear">Crear Pack</button>
            </form>
        </div>

        <div class="caja-form">
            <h3>🎸 Crear Género Musical</h3>
            <form action="/admin/nuevo-genero" method="POST">
                <label>Nombre del Género</label>
                <input type="text" name="nombre" placeholder="Ej. Reggaeton, Synthwave..." required>

                <button type="submit" class="btn-crear">Crear Género</button>
            </form>
        </div>

        <div class="caja-form">
            <h3>📁 Crear Categoría de Audio</h3>
            <form action="/admin/nueva-categoria" method="POST">
                <label>Nombre de la Categoría</label>
                <input type="text" name="nombre" placeholder="Ej. Melodies, Basslines..." required>

                <button type="submit" class="btn-crear">Crear Categoría</button>
            </form>
        </div>

    </div>

</body>
</html>