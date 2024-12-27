<?php

require_once __DIR__ . '/../includes/app.php';

use MVC\Router;
use Controllers\PropiedadController;

$router = new Router();

$router->get('/public/admin', [PropiedadController::class, 'index']);
$router->get('/public/crear', [PropiedadController::class, 'crear']);
$router->post('/public/crear', [PropiedadController::class, 'crear']);
$router->get('/public/actualizar', [PropiedadController::class, 'actualizar']);
$router->post('/public/actualizar', [PropiedadController::class, 'actualizar']);
$router->post('/public/eliminar', [PropiedadController::class, 'eliminar']);


$router->comprobarRutas();