<?php

namespace Controllers;

use MVC\Router;
use Model\Vendedor;

class VendedorController
{
    public static function index(Router $router)
    {
        $router->render('vendedores/crear', []);
    }
    public static function crear(Router $router)
    {
        $errores = Vendedor::getErrores();
        $vendedor = new Vendedor();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // Crear una nueva instancia con los datos del formulario
            $vendedor = new Vendedor($_POST['vendedor']);

            // Validar que no haya campos vacíos
            $errores = $vendedor->validar();

            if (empty($errores)) {
                // Guardar en la base de datos
                $resultado = $vendedor->guardar();

                if ($resultado) {
                    // Redirigir al usuario tras guardar
                    header('Location: /public/admin?resultado=6');
                    exit;
                }
            }
        }
        $router->render('vendedores/crear', [
            'errores' => $errores,
            'vendedor' => $vendedor
        ]);
    }
    public static function actualizar(Router $router)
    {
        $errores = Vendedor::getErrores();
        $id = validarORedireccionar('/admin');
        //Obtener datos del vendedor a actualizar
        $vendedor = Vendedor::find($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //Asignar los atributos
            $args = $_POST['vendedor'];
            $vendedor->sincronizar($args);
            //Validar
            $errores = $vendedor->validar();
            if (empty($errores)) {
                $resultado = $vendedor->actualizar();
                if ($resultado) {
                    header('Location: /public/admin?resultado=5');
                }
            }
        }


        $router->render('vendedores/actualizar', [
            'vendedor' => $vendedor,
            'errores' => $errores
        ]);
    }
    public static function eliminar()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'] ?? null;
        $id = filter_var($id, FILTER_VALIDATE_INT);

        if ($id) {
            $tipo = $_POST['tipo'] ?? null;

            if (validarTipoContenido($tipo)) {
                $vendedor = Vendedor::find($id);

                if ($vendedor) {
                    // var_dump($vendedor); // Depurar el objeto vendedor
                    $resultado = $vendedor->eliminar();
                    exit; // Detener para inspección
                } else {
                    echo "Vendedor no encontrado.";
                }
            } else {
                echo "Tipo de contenido no válido.";
            }
        } else {
            echo "ID no válido.";
        }
    }
}



}
