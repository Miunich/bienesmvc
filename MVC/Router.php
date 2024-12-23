<?php

namespace MVC;

class Router
{

    public $rutasGET = [];
    public $rutasPOST = [];

    public function get($url, $fn)
    {
        $this->rutasGET[$url] = $fn;
        // debuguear($this->rutasGET);
    }

    public function comprobarRutas()
    {
        $urlActual = $_SERVER['REQUEST_URI'] ?? '/';
        $metodo = $_SERVER['REQUEST_METHOD'];

        // debuguear($urlActual);

        if ($metodo === 'GET') {
            
            $fn = $this->rutasGET[$urlActual] ?? null;
            // debuguear($fun);
        }
        // debuguear($fn);

        if ($fn) {
            // La URL existe y hay una función asociada
            call_user_func($fn, $this);
        } else {
            echo 'Página no encontrada';//test
        }
    }

    //Muestra una vista
    public function render($view, $datos = [])
    {
        
        foreach ($datos as $key => $value) {
            $$key = $value;//variable de variables
        }
        ob_start();//guarda el contenido en un buffer
        include __DIR__ . "/../views/$view.php";
        $contenido = ob_get_clean();//limpia el buffer

        include __DIR__ . "/../views/layout.php";
    }
}
