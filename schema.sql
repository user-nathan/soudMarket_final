-- 1. Creación de la base de datos
CREATE DATABASE IF NOT EXISTS samples_tienda CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE samples_tienda;

-- 2. Tabla de Usuarios (Modelo Recarga/Monedero)
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    rol ENUM('user', 'admin') DEFAULT 'user',
    creditos INT DEFAULT 0,
    plan ENUM('ninguno', 'basico', 'premium') DEFAULT 'ninguno',
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 3. Categorías (Loops, Drums, Vocals...)
CREATE TABLE categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL
);

-- 4. Géneros (Trap, Techno, Hip Hop, etc)
CREATE TABLE generos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL
);

-- 5. Álbumes / Sample Packs (La nueva agrupación)
CREATE TABLE albums (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    portada_url VARCHAR(255) DEFAULT 'default_album.png', 
    descripcion TEXT,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 6. Samples (Relacionado con Categoría, Género y Álbum)
CREATE TABLE samples (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    archivo_url VARCHAR(255) NOT NULL,
    bpm INT,
    tonalidad VARCHAR(10),
    id_categoria INT,
    id_genero INT,
    id_album INT, 
    precio_creditos INT DEFAULT 5,
    fecha_subida TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_categoria) REFERENCES categorias(id) ON DELETE SET NULL,
    FOREIGN KEY (id_genero) REFERENCES generos(id) ON DELETE SET NULL,
    FOREIGN KEY (id_album) REFERENCES albums(id) ON DELETE SET NULL
);

-- 7. Compras (Historial de canjes)
CREATE TABLE compras (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    id_sample INT NOT NULL,
    fecha_compra TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (id_sample) REFERENCES samples(id) ON DELETE CASCADE
);

-- 8. Inserciones iniciales para pruebas
INSERT INTO categorias (nombre) VALUES ('Loops'), ('Drums'), ('Vocals'), ('One-Shots');
INSERT INTO generos (nombre) VALUES ('Trap'), ('Techno'), ('House'), ('Lo-Fi'), ('Drill');

-- Insertamos un álbum de ejemplo para probar la lógica
INSERT INTO albums (nombre, descripcion) VALUES ('Ultimate Trap Pack', 'Los mejores sonidos de trap de 2026');