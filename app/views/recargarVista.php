<?php 
// app/views/recargarVista.php

//Usamos el CSS compartido de perfil que ya tiene el diseño de la tienda
$cssEspecifico = 'perfil.css'; 
require_once '../app/views/includes/header.php'; 
?>

<div style="text-align: center; padding: 20px;">

    <div class="tienda-creditos tienda-recargar-solitaria">
        <h2 class="titulo-tienda">Recargar Créditos</h2>
        <p class="subtitulo-tienda">Estilo Monedas de TikTok</p>
        
        <?php if ($datosUsuario !== null): ?>
            <div class="monedero-actual">
                <span>SALDO ACTUAL</span>
                <strong><?php echo $datosUsuario['creditos']; ?> 🪙</strong>
            </div>
        <?php endif; ?>
        
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

        <a href="/" class="btn-volver">⬅ Volver al Inicio</a>
    </div>

</div>

<?php 
//Inyectamos el pie de página global
require_once '../app/views/includes/footer.php'; 
?>