<?php

require_once __DIR__ . '/../includes/app.php';

use MVC\Router;
use Controllers\PropiedadController;
use Controllers\VendedorController;
use Controllers\PaginasController;


$router = new Router();
//ZONA PRIVADA
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

//ZONA PUBLICA
$router->get('/public/', [PaginasController::class, 'index']);
$router->get('/public/nosotros', [PaginasController::class, 'nosotros']);
$router->get('/public/propiedades', [PaginasController::class, 'propiedades']);
$router->get('/public/propiedad', [PaginasController::class, 'propiedad']);
$router->get('/public/blog', [PaginasController::class, 'blog']);
$router->get('/public/entrada', [PaginasController::class, 'entrada']);
$router->get('/public/contacto', [PaginasController::class, 'contacto']);
$router->post('/public/contacto', [PaginasController::class, 'contacto']);


$router->comprobarRutas();