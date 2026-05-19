<?php
// public/index.php

// 1. Cargamos los archivos principales
require_once '/app/core/database.php';
require_once '../app/core/enrutador.php';

//prueba para la ruta de la nube
// 1. Cargamos los archivos principales
//require_once __DIR__ . '/../app/core/database.php';
//require_once __DIR__ . '/../app/core/enrutador.php';

// 2. Iniciamos el enrutador
$enrutador = new Enrutador();


// Cuando el usuario entre a la raíz "/", llamará al método "index" del "homeController"
$enrutador->get('/', 'homeController@index');

// Rutas de Registro (Una muestra el formulario, la otra recibe los datos)
$enrutador->get('/registro', 'autenticacionController@mostrarRegistro');
$enrutador->post('/registro', 'autenticacionController@registrar');

// Rutas de Login
$enrutador->get('/login', 'autenticacionController@mostrarLogin');
$enrutador->post('/login', 'autenticacionController@login');

// Ruta de Cierre de Sesión 
$enrutador->get('/logout', 'autenticacionController@logout');


// Ruta del Perfil
$enrutador->get('/perfil', 'usuarioController@mostrarPerfil');

// para modificar los datos de usuario
$enrutador->post('/perfil/actualizar', 'usuarioController@actualizarPerfil');


// recargar creditos
$enrutador->get('/recargar', 'creditosController@mostrarTienda');

// pago simulado
$enrutador->get('/checkout', 'creditosController@mostrarCheckout');
$enrutador->post('/checkout', 'creditosController@procesarPago');

// Ruta para el administrador
$enrutador->get('/admin', 'adminController@mostrarPanel');

// Rutas para añadir samples
$enrutador->get('/admin/nuevo-sample', 'adminController@mostrarFormularioSample');
$enrutador->post('/admin/nuevo-sample', 'adminController@guardarSample');

// Rutas para editar samples (pasando el ID por la URL)
$enrutador->get('/admin/editar-sample', 'adminController@mostrarEditarSample');
$enrutador->post('/admin/editar-sample', 'adminController@actualizarSample');

// Rutas para Elementos del Catálogo
$enrutador->get('/admin/elementos', 'adminController@mostrarElementos');
$enrutador->post('/admin/nuevo-album', 'adminController@guardarAlbum');
$enrutador->post('/admin/nuevo-genero', 'adminController@guardarGenero');
$enrutador->post('/admin/nueva-categoria', 'adminController@guardarCategoria');

// Ruta para ver el contenido de una librería específica
$enrutador->get('/libreria', 'homeController@mostrarLibreria');

// Ruta para procesar la compra y descargar el sample
$enrutador->get('/libreria/descargar', 'homeController@descargarSample');



//$enrutador->get('/probarmodelo', 'homeController@probarModelo');

// 4. Ponemos a funcionar el enrutador
$enrutador->despachar();