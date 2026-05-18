<?php 
// app/views/loginVista.php

$cssEspecifico = 'login.css'; // <--- ¡Le decimos al header qué CSS se cargue antes de que pinte la página!
require_once '../app/views/includes/header.php'; 
?>

<!-- <link rel="stylesheet" href="/assets/css/login.css"> -->


<div style="text-align: center; padding: 20px;">

    <div class="login-container">
        <h2>Iniciar Sesión</h2>
        
        <?php if (isset($_GET['registro']) && $_GET['registro'] === 'exito'): ?>
            <p class="msg-exito">¡Cuenta creada con éxito! Ya puedes entrar.</p>
        <?php endif; ?>

        <?php if (isset($error)): ?>
            <p class="msg-error"><?php echo $error; ?></p>
        <?php endif; ?>

        <form action="/login" method="POST">
            <input type="text" name="username" placeholder="Usuario" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <button type="submit">Entrar</button>
        </form>
        
        <p class="msg-pie">¿No tienes cuenta? <a href="/registro">Regístrate aquí</a></p>
    </div>

</div>

<?php 
//Inyectamos el cierre estructural de la página
require_once '../app/views/includes/footer.php'; 
?>