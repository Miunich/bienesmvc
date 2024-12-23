<?php

require 'funciones.php';
require 'config/database.php';
require_once __DIR__ . '/../vendor/autoload.php';

// Conectar a la base de datos
$db = conectarDB();


use Model\propiedad;

Propiedad::setDB($db);

