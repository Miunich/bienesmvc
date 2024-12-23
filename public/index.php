<?php

require_once __DIR__ . '/../includes/app.php';

use MVC\Router;
use Controllers\PropiedadController;

$router = new Router();

$router->get('/public/admin', [PropiedadController::class, 'index']);
$router->get('/public/propiedades/crear', [PropiedadController::class, 'crear']);
$router->get('/public/propiedad/actualizar', [PropiedadController::class, 'actualizar']);


$router->comprobarRutas();