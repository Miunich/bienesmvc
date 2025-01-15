<?php

namespace Controllers;

use MVC\Router;
use Model\Propiedad;

class PaginasController
{
    public static function index(Router $router)
    {
        $inicio = true;
        $propiedades = Propiedad::get(3);
        $router->render('paginas/index', [
            'propiedades' => $propiedades,
            'inicio' => $inicio
        ]);
    }
    public static function nosotros(Router $router)
    {
        $router->render('paginas/nosotros');
    }
   
    public static function propiedades(Router $router)
    {
        $propiedades = Propiedad::all();
        $router->render('paginas/propiedades', [
            'propiedades' => $propiedades
        ]);
    }
    
    public static function propiedad()
    {
        echo 'Desde la página de propiedad';
    }
    public static function blog()
    {
        echo 'Desde la página de blog';
    }
    public static function entrada()
    {
        echo 'Desde la página de entrada';
    }
    public static function contacto()
    {
        echo 'Desde la página de contacto';
    }
}