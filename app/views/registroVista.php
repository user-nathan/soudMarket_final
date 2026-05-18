<?php 
// app/views/registroVista.php

$cssEspecifico = 'login.css'; // <--- ¡Le decimos al header qué CSS cargar antes de que pinte la página!
require_once '../app/views/includes/header.php';  
?>

<!-- <link rel="stylesheet" href="/assets/css/login.css"> -->

<div style="text-align: center; padding: 20px;">

    <div class="registro-container">
        <h2>Únete a la comunidad</h2>
        
        <?php if (isset($error)): ?>
            <p class="msg-error"><?php echo $error; ?></p>
        <?php endif; ?>

        <form action="/registro" method="POST">
            <input type="text" name="username" placeholder="Usuario" required>
            <input type="email" name="email" placeholder="Correo electrónico" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <button type="submit">Crear cuenta</button>
        </form>
        
        <p class="msg-pie">¿Ya tienes cuenta? <a href="/login">Entra aquí</a></p>
    </div>

</div>

<?php 
// 2. Inyectamos el cierre estructural de la página
require_once '../app/views/includes/footer.php'; 
?>