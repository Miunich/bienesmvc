<?php

namespace Model;

class vendedor
{
    // Base de datos
    protected static $db;
    protected static $columnasDB = ['vendedor_id', 'nombre', 'apellido'];

    //Errores
    protected static $errores = [];

    public $vendedor_id;
    public $nombre;
    public $apellido;

    //Definir la conexión a la base de datos
    public static function setDB($database)
    {
        self::$db = $database;
    }

    public function __construct($args = [])
    {
        $this->vendedor_id = $args['vendedor_id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
    }

    public function guardar()
    {
        // Verificar si la conexión a la base de datos está configurada
        if (!self::$db) {
            die("La conexión a la base de datos no está configurada.");
        }

        // Sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        // Insertar en la base de datos
        $query = "INSERT INTO vendedores ( ";
        $query .= join(', ', array_keys($atributos));
        $query .= " ) VALUES ('";
        $query .= join("', '", array_values($atributos));
        $query .= "')";

        $resultado = self::$db->query($query);

        return $resultado;
    }

    public function atributos()
    {
        $atributos = [];
        foreach (self::$columnasDB as $columna) {
            if ($columna === 'vendedor_id') continue; // Excluir ID para inserciones
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }

    public function sanitizarAtributos()
    {
        $atributos = $this->atributos();
        $sanitizado = [];

        foreach ($atributos as $key => $value) {
            $sanitizado[$key] = self::$db->escape_string($value);
        }
        return $sanitizado;
    }

    public static function getErrores()
    {
        return self::$errores;
    }

    public function validar()
    {
        if (!$this->nombre) {
            self::$errores[] = "Debes añadir un Nombre";
        }
        if (!$this->apellido) {
            self::$errores[] = "Debes añadir un Apellido";
        }
        return self::$errores;
    }

    public static function all()
    {
        $query = "SELECT * FROM vendedores";

        $resultado = self::consultarSQL($query);

        return $resultado;
    }

    public static function consultarSQL($query)
    {
        $resultado = self::$db->query($query);

        $array = [];
        while ($registro = $resultado->fetch_assoc()) {
            $array[] = self::crearObjeto($registro);
        }

        $resultado->free();

        return $array;
    }

    protected static function crearObjeto($registro)
    {
        $objeto = new self;

        foreach ($registro as $key => $value) {
            if (property_exists($objeto, $key)) {
                $objeto->$key = $value;
            }
        }

        return $objeto;
    }

    public function sincronizar($args = [])
    {
        foreach ($args as $key => $value) {
            if (property_exists($this, $key) && !is_null($value)) {
                $this->$key = $value;
            }
        }
    }
    //find
    public static function find($vendedor_id)
    {
        $query = "SELECT * FROM vendedores WHERE vendedor_id = $vendedor_id";
        $resultado = self::consultarSQL($query);

        return array_shift($resultado);
    }
    public function actualizar()
    {
        // Sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        // Crear la consulta SQL para actualizar
        $valores = [];
        foreach ($atributos as $key => $value) {
            $valores[] = "$key = '$value'";
        }

        $query = "UPDATE vendedores SET ";
        $query .= join(', ', $valores);
        $query .= " WHERE vendedor_id = " . self::$db->escape_string($this->vendedor_id) . " LIMIT 1";

        // Ejecutar la consulta
        $resultado = self::$db->query($query);

        return $resultado;
    }


    public function eliminar()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Tomar el ID directamente desde el parámetro $id pasado en el controlador
        $id = $_POST['id'] ?? null;
        $id = filter_var($id, FILTER_VALIDATE_INT);

        if ($id) {
            // Crear la consulta para eliminar
            $query = "DELETE FROM vendedores WHERE vendedor_id = " . self::$db->escape_string($id) . " LIMIT 1";

            // Ejecutar la consulta
            $resultado = self::$db->query($query);

            if ($resultado) {
                // Redirigir después de eliminar
                header('Location: /public/admin?resultado=4');
                exit;
            } else {
                echo "Error al eliminar el vendedor.";
            }
        } else {
            echo "ID no válido.";
        }
    }
}

}
