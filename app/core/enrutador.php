<?php
// app/core/enrutador.php

// se encarga de registrar las rutas (las páginas de la web) y despachar la peticion al controlador correcto


class Enrutador {
    protected $rutas = [];

    public function get($url, $controladorYMetodo) {
        $this->rutas['GET'][$url] = $controladorYMetodo;
    }

    public function post($url, $controladorYMetodo) {
        $this->rutas['POST'][$url] = $controladorYMetodo;
    }

    public function despachar() {
        $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $metodo = $_SERVER['REQUEST_METHOD'];

        if (isset($this->rutas[$metodo][$url])) {
            list($controlador, $metodoAccion) = explode('@', $this->rutas[$metodo][$url]);

            // Busca el archivo respetando las mayúsculas
            if (file_exists("../app/controllers/$controlador.php")) {
                require_once "../app/controllers/$controlador.php";
                $instanciaControlador = new $controlador();
                $instanciaControlador->$metodoAccion();
            } else {
                http_response_code(500);
                echo "Error Interno: El archivo '../app/controllers/$controlador.php' no existe.";
            }
        } else {
            http_response_code(404);
            echo "<h1>404 - Página no encontrada</h1>";
        }
    }
}