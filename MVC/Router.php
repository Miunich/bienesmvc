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

    public function post($url, $fn)
    {
        $this->rutasPOST[$url] = $fn;
        // debuguear($this->rutasGET);
    }

    public function comprobarRutas()
    {
        $urlActual = $_SERVER['REQUEST_URI'] ?? '/';
        $metodo = $_SERVER['REQUEST_METHOD'];

        // debuguear($urlActual);

        if ($metodo === 'GET') {

            $fn = $this->rutasGET[$urlActual] ?? null;
           
        } else{
            $fn = $this->rutasPOST[$urlActual] ?? null;
        }
        

        if ($fn) {
            // La URL existe y hay una función asociada
            call_user_func($fn, $this);
        } else {
            echo 'Página no encontrada'; //test
        }
    }

    //Muestra una vista
    public function render($view, $datos = [])
    {
        foreach ($datos as $key => $value) {
            $$key = $value; // Variables dinámicas
        }

        // Generar contenido dinámico de la vista
        ob_start();
        $viewPath = __DIR__ . "/../views/$view.php";

        if (file_exists($viewPath)) {
            include $viewPath;
        } else {
            echo "Error: La vista '$view' no existe.";
            return;
        }

        $contenido = ob_get_clean();

        // Incluir el layout
        $layoutPath = __DIR__ . "/../views/layout.php";

        if (file_exists($layoutPath)) {
            include $layoutPath;
        } else {
            echo "Error: El layout no existe.";
        }
    }
}
