<?php

namespace Model;

class propiedad{
    // Base de datos
    protected static $db;
    protected static $columnasDB = ['id', 'titulo', 'precio', 'imagen', 'descripcion', 'habitaciones', 'wc', 'estacionamiento', 'creado', 'vendedor_id'];

    //Errores
    // protected static $errores = [];
    public $errores = [];

    public $id;
    public $titulo;
    public $precio;
    public $imagen;
    public $descripcion;
    public $habitaciones;
    public $wc;
    public $estacionamiento;
    public $creado;
    public $vendedor_id;

    //Definir la conexion a la base de datos
    public static function setDB($database){
        self::$db = $database;
    }

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->titulo = $args['titulo'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->habitaciones = $args['habitaciones'] ?? '';
        $this->wc = $args['wc'] ?? '';
        $this->estacionamiento = $args['estacionamiento'] ?? '';
        $this->creado = date('Y/m/d');
        $this->vendedor_id = $args['vendedor_id'] ?? '';
    }
    public function guardar(){

        //Sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        echo "Guardando en la base de datos";

        //Insertar en la base de datos
        $query = "INSERT INTO propiedades ( ";
        $query .= join(', ', array_keys($atributos));
        $query .=") VALUES (' ";
        $query .= join("', '", array_values($atributos));
        $query .= " ')";


        $resultado = self::$db->query($query);

        return $resultado;

        // debuguear($resultado);
    }
    public function actualizar() {
        // Sanitizar los datos
        $atributos = $this->sanitizarAtributos();
        
        echo "Actualizado en la base de datos";
        // Crear la consulta SQL para actualizar
        $valores = [];
        foreach ($atributos as $key => $value) {
            $valores[] = "$key = '$value'";
        }
    
        $query = "UPDATE propiedades SET ";
        $query .= join(', ', $valores);
        $query .= " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";
    
        

        // Ejecutar la consulta
        $resultado = self::$db->query($query);
    
        return $resultado;
    }

    public function eliminar() {
        // Verificar que el ID esté definido
        // if (!isset($this->id)) {
        //     throw new Exception("El ID de la propiedad es obligatorio para eliminar.");
        // }
    
        // Crear la consulta SQL para eliminar el registro
        $query = "DELETE FROM propiedades WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";
        
        // Ejecutar la consulta
        $resultado = self::$db->query($query);
        
        // Retornar el resultado de la operación
        return $resultado;
    }
    
    
    //Identificar y unir los atributos de la base de datos
    public function atributos(){
        $atributos = [];
        foreach(self::$columnasDB as $columna){
            if($columna === 'id') continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }

    public function sanitizarAtributos(){
        $atributos = $this->atributos();
        $sanitizado = [];

        foreach($atributos as $key => $value){
            $sanitizado[$key] = self::$db->escape_string($value);
        }
        return $sanitizado;
    }
    
    
    //Validacion
    public function getErrores() {
        return $this->errores;  // Accedemos a la propiedad de instancia
    }

    public function validar(){
        if(!$this->titulo){
            $this->errores[] = "Debes añadir un titulo";
        }
        if(!$this->precio){
            $this->errores[] = "Debes añadir un precio";
        }
        // if(!$this->descripcion){
        //     $this->errores[] = "Debes añadir una descripcion";
        // }
        if(!$this->habitaciones){
            $this->errores[] = "Debes añadir un numero de habitaciones";
        }
        if(!$this->wc){
            $this->errores[] = "Debes añadir un numero de baños";
        }
        if(!$this->estacionamiento){
            $this->errores[] = "Debes añadir un numero de estacionamientos";
        }
        if(!$this->vendedor_id){
            $this->errores[] = "Debes añadir un vendedor";
        }
        // if(!$this->imagen){
        //     self::$errores[] = "Debes añadir una imagen";
        // }
        return $this->errores;
    }

    public function setImagen($imagen){
        if($imagen){
            $this->imagen = $imagen;
        }
    }

    public static function all(){
        $query = "SELECT * FROM propiedades";
        
        $resultado = self::consultarSQL($query);

        return $resultado;
        
    }

    public static function consultarSQL($query){
        //Consultar la base de datos
        $resultado = self::$db->query($query);

        //Iterar los resultados
        $array = [];
        while($registro = $resultado->fetch_assoc()){
            $array[] = self::crearObjeto($registro);

        }
    
        //Liberar la memoria
        $resultado->free();

        //Retornar los resultados
        return $array;


    }

    protected static function crearObjeto($registro){                
        $objeto = new self;


        foreach($registro as $key => $value){
            if(property_exists($objeto, $key)){
                $objeto->$key = $value;
            }
        }

        return $objeto;
    }
    //Sincroniza el objeto en memoria con los cambios realizados por el usuario
    // public function sincronizar ($args = []){
    //     foreach($args as $key => $value){
    //         if(property_exists($this, $key) && !is_null($value)){
    //             $this->$key = $value;
    //         }
    //     }
    // }
    public function sincronizar($args = [])
    {
        foreach ($args as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }
    //find
    public static function find($id){
        $query = "SELECT * FROM propiedades WHERE id = $id";
        $resultado = self::consultarSQL($query);

        return array_shift($resultado);
    }
    //obtiene determinado numero de propiedades
    public static function get($cantidad){
        $query = "SELECT * FROM propiedades LIMIT $cantidad";

        $resultado = self::consultarSQL($query);

        return $resultado;
    }

}