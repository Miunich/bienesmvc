<?php

namespace Model;

class ActiveRecord{

    //Base de datos
    protected static $db;
    protected static $columnasDB = [];
    protected static $tabla = '';

    //Errores
    protected static $errores = [];

    //Definir la conexión a la base de datos
    public static function setDB($database)
    {
        self::$db = $database;
    }

}