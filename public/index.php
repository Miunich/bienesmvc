<?php

require_once __DIR__ . '/../includes/app.php';

use MVC\Router;
use Controllers\PropiedadController;
use Controllers\VendedorController;


$router = new Router();
//Propiedades
$router->get('/public/admin', [PropiedadController::class, 'index']);
$router->get('/public/propiedad/crear', [PropiedadController::class, 'crear']);
$router->post('/public/propiedad/crear', [PropiedadController::class, 'crear']);
$router->get('/public/dir', [PropiedadController::class, 'printDir']);
$router->get('/public/propiedad/actualizar', [PropiedadController::class, 'actualizar']);
$router->post('/public/propiedad/actualizar', [PropiedadController::class, 'actualizar']);
$router->post('/public/propiedad/eliminar', [PropiedadController::class, 'eliminar']);

//Vendedores
$router->get('/public/vendedores/admin', [VendedorController::class, 'index']);
$router->get('/public/vendedores/crear', [VendedorController::class, 'crear']);
$router->post('/public/vendedores/crear', [VendedorController::class, 'crear']);

$router->get('/public/vendedores/actualizar', [VendedorController::class, 'actualizar']);
$router->post('/public/vendedores/actualizar', [VendedorController::class, 'actualizar']);
$router->post('/public/vendedores/eliminar', [VendedorController::class, 'eliminar']);


$router->comprobarRutas();