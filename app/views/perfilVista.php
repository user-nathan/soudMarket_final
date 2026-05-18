<?php 
// app/views/perfilVista.php

//
$cssEspecifico = 'perfil.css'; 
require_once '../app/views/includes/header.php'; 
?>

<div class="wrapper-perfil">

    <div class="perfil-container">
        <div class="avatar">
            <?php echo strtoupper(substr($datosUsuario['username'], 0, 1)); ?>
        </div>
        
        <h2 class="titulo-perfil">Mi Perfil</h2>
        
        <form action="/perfil/actualizar" method="POST">
            
            <div class="dato">
                <span>Nombre de Usuario</span>
                <strong id="txt-username"><?php echo htmlspecialchars($datosUsuario['username']); ?></strong>
                <input type="text" name="username" id="input-username" class="input-perfil" value="<?php echo htmlspecialchars($datosUsuario['username']); ?>" required>
                
                <div>
                    <span class="badge <?php echo $datosUsuario['rol'] === 'admin' ? 'badge-admin' : 'badge-user'; ?>">
                        <?php echo $datosUsuario['rol']; ?>
                    </span>
                </div>
            </div>

            <div class="dato">
                <span>Correo Electrónico</span>
                <strong id="txt-email"><?php echo htmlspecialchars($datosUsuario['email']); ?></strong>
                <input type="email" name="email" id="input-email" class="input-perfil" value="<?php echo htmlspecialchars($datosUsuario['email']); ?>" required>
            </div>

            <div class="dato">
                <span>Mi Monedero</span>
                <strong class="monedero-saldo"><?php echo $datosUsuario['creditos']; ?> 🪙</strong>
            </div>

            <div class="dato">
                <span>Fecha de Registro</span>
                <strong><?php echo date('d/m/Y H:i', strtotime($datosUsuario['fecha_registro'])); ?></strong>
            </div>

            <button type="button" id="btn-activar-edicion" class="btn-editar-perfil" onclick="activarModoEdicion()">✏️ Editar Perfil</button>

            <button type="submit" id="btn-guardar" class="btn-guardar-perfil">💾 Guardar Cambios</button>
        </form>

        <a href="/" class="btn-volver">⬅ Volver al Panel Principal</a>
    </div>

    <div class="tienda-creditos">
        <h2 class="titulo-tienda">Recargar Créditos</h2>
        <p class="subtitulo-tienda">Consigue créditos para canjear por tus samples favoritos</p>
        
        <div class="pack-item">
            <div class="pack-info">
                <strong>50 Créditos 🪙</strong>
                <span>Pack Básico</span>
            </div>
            <?php if (isset($_SESSION['usuario_id'])): ?>
                <a href="/checkout?pack=1" class="btn-comprar">7,00 €</a>
            <?php else: ?>
                <a href="/login" class="btn-comprar">7,00 €</a>
            <?php endif; ?>
        </div>

        <div class="pack-item">
            <div class="pack-info">
                <strong>155 Créditos 🪙</strong>
                <span>Pack Ahorro (+5 gratis)</span>
            </div>
            <?php if (isset($_SESSION['usuario_id'])): ?>
                <a href="/checkout?pack=2" class="btn-comprar">20,00 €</a>
            <?php else: ?>
                <a href="/login" class="btn-comprar">20,00 €</a>
            <?php endif; ?>
        </div>
    </div>

</div>

<script src="/assets/js/perfil.js"></script>
<?php 
//Inyectamos el pie de página global
require_once '../app/views/includes/footer.php'; 
?>