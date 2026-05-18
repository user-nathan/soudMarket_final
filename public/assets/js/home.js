
function limpiarYEnviar() {
    const formulario = document.querySelector('.form-filtros');
    formulario.querySelector('select[name="categoria"]').selectedIndex = 0;
    formulario.querySelector('select[name="genero"]').selectedIndex = 0;
    formulario.querySelector('input[name="bpm"]').value = '';
    formulario.querySelector('input[name="tono"]').value = '';
    // Al redirigir a '/' se borran los filtros del $_GET y la vista vuelve a mostrar automáticamente las librerías
    window.location.href = '/';
}
