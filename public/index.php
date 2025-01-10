<?php

require_once __DIR__ . '/../includes/app.php';

use MVC\Router;
use Controllers\PropiedadController;

$router = new Router();
//Propiedades
$router->get('/public/admin', [PropiedadController::class, 'index']);
$router->get('/public/propiedad/crear', [PropiedadController::class, 'crear']);
$router->post('/public/propiedad/crear', [PropiedadController::class, 'crear']);
$router->get('/public/dir', [PropiedadController::class, 'printDir']);
$router->get('/public/propiedades/actualizar', [PropiedadController::class, 'actualizar']);
$router->post('/public/propiedades/actualizar', [PropiedadController::class, 'actualizar']);
$router->post('/public/propiedades/eliminar', [PropiedadController::class, 'eliminar']);

//Vendedores
$router->get('/public/admin', [PropiedadController::class, 'index']);
$router->get('/public/crear', [PropiedadController::class, 'crear']);
$router->post('/public/crear', [PropiedadController::class, 'crear']);

$router->get('/public/actualizar', [PropiedadController::class, 'actualizar']);
$router->post('/public/actualizar', [PropiedadController::class, 'actualizar']);
$router->post('/public/eliminar', [PropiedadController::class, 'eliminar']);


$router->comprobarRutas();