// public/assets/js/perfil.js

function activarModoEdicion() {
    // Ocultamos los textos planos
    document.getElementById('txt-username').style.display = 'none';
    document.getElementById('txt-email').style.display = 'none';
    document.getElementById('btn-activar-edicion').style.display = 'none';

    // Mostramos las cajas de texto y el botón de guardar
    document.getElementById('input-username').style.display = 'block';
    document.getElementById('input-email').style.display = 'block';
    document.getElementById('btn-guardar').style.display = 'block';
}