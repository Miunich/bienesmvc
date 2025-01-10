<?php

namespace Controllers;

use MVC\Router;
use Model\Propiedad;
use Model\vendedor;
use Intervention\Image\ImageManager as Image;
use Intervention\Image\Drivers\GD\Driver;


class PropiedadController
{
    public static function index(Router $router)
    {
        $propiedades = Propiedad::all();
        $resultado = null;
        $router->render('propiedades/admin', [
            'propiedades' => $propiedades,
            'resultado' => $resultado
        ]);
    }

    public static function crear(Router $router)
    {
        $propiedad = new Propiedad();
        $vendedores = vendedor::all();
        $errores = $propiedad->validar();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Crear instancia de Propiedad con los datos enviados
            $propiedad = new Propiedad($_POST);

            // Validar los datos de la propiedad
            $errores = $propiedad->validar();


            // Verificar que el archivo de imagen fue enviado correctamente
            // $imagen=$_FILES['imagen'];
            // debuguear($imagen);

            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
                // Validar el tipo de archivo (solo imágenes)
                $tipoArchivo = $_FILES['imagen']['type'];
                if (strpos($tipoArchivo, 'image') === false) {
                    $errores[] = 'El archivo no es una imagen válida.';
                }

                // Validar el tamaño máximo de la imagen (por ejemplo, 2MB)
                $tamanoMaximo = 8 * 1024 * 1024; // 8MB
                if ($_FILES['imagen']['size'] > $tamanoMaximo) {
                    $errores[] = 'El archivo es demasiado grande. El tamaño máximo permitido es 2MB.';
                }

                // Si no hay errores, procesar la imagen
                if (empty($errores)) {
                    // Generar un nombre único para la imagen
                    $nombreImagen = uniqid() . ".jpg";



                    // Crear la carpeta si no existe
                    if (!is_dir(CARPETA_IMAGENES)) {
                        mkdir(CARPETA_IMAGENES, 0755, true);
                    }

                    // Procesar y redimensionar la imagen
                    $manager = new Image(Driver::class);
                    $imagen = $manager->read($_FILES['imagen']['tmp_name'])->cover(800, 600);

                    // Guardar la imagen en la carpeta definida
                    $imagen->save(CARPETA_IMAGENES . $nombreImagen);

                    // Asignar el nombre de la imagen a la propiedad
                    $propiedad->setImagen($nombreImagen);
                }
            } else {
                $errores[] = 'La imagen es obligatoria o hubo un error al subirla.';
            }

            // Si no hay errores, guardar la propiedad
            if (empty($errores)) {
                $resultado = $propiedad->guardar();
                if ($resultado) {
                    header('Location: /public/admin?resultado=1');
                    exit;
                }
            }
        }

        // Renderizar la vista con errores y datos
        $router->render('propiedades/crear', [
            'propiedad' => $propiedad,
            'vendedores' => $vendedores,
            'errores' => $errores
        ]);
    }



    public static function actualizar(Router $router)
    {
        // var_dump($_SERVER['REQUEST_METHOD']); // Tipo de solicitud (esperado: 'POST')
        // var_dump($_SERVER['REQUEST_URI']);   // URI de la solicitud
        // var_dump($_POST);                    // Datos enviados (esperado: datos del formulario)
        // exit;

        $id = validarORedireccionar('/admin');
        $propiedad = Propiedad::find($id);

        // $errores = Propiedad::getErrores();
        $errores = $propiedad->getErrores(); // Cambiado de 'Propiedad::getErrores()' a '$propiedad->getErrores()'

        // debuguear($propiedad);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // var_dump($_POST); // Inspecciona los datos enviados
            $args = $_POST['propiedad'] ?? []; // Usa un arreglo vacío si no está definido
            $propiedad->sincronizar($args);
            $errores = $propiedad->validar();
            //imagen actualizada
            // Verificar si se ha subido una nueva imagen
            if (isset($_FILES['propiedad']['tmp_name']['imagen']) && $_FILES['propiedad']['error']['imagen'] === UPLOAD_ERR_OK) {
                // Validar el tipo de archivo (solo imágenes)
                $tipoArchivo = $_FILES['propiedad']['type']['imagen'];
                if (strpos($tipoArchivo, 'image') === false) {
                    $errores[] = 'El archivo no es una imagen válida.';
                }

                // Validar el tamaño máximo de la imagen (por ejemplo, 8MB)
                $tamanoMaximo = 8 * 1024 * 1024; // 8MB
                if ($_FILES['propiedad']['size']['imagen'] > $tamanoMaximo) {
                    $errores[] = 'El archivo es demasiado grande. El tamaño máximo permitido es 8MB.';
                }

                // Si no hay errores, procesar la nueva imagen
                if (empty($errores)) {
                    // Generar un nombre único para la imagen
                    $nombreImagen = uniqid() . ".jpg";

                    // Crear la carpeta si no existe
                    if (!is_dir(CARPETA_IMAGENES)) {
                        mkdir(CARPETA_IMAGENES, 0755, true);
                    }

                    // Procesar y redimensionar la imagen
                    $manager = new Image(Driver::class);
                    $imagen = $manager->read($_FILES['propiedad']['tmp_name']['imagen'])->cover(800, 600);

                    // Guardar la imagen en la carpeta definida
                    $imagen->save(CARPETA_IMAGENES . $nombreImagen);

                    // Eliminar la imagen anterior, si existe
                    if ($propiedad->imagen && file_exists(CARPETA_IMAGENES . $propiedad->imagen)) {
                        unlink(CARPETA_IMAGENES . $propiedad->imagen);
                    }

                    // Asignar el nombre de la nueva imagen a la propiedad
                    $propiedad->setImagen($nombreImagen);
                }
            }

            // Si no se sube una nueva imagen, mantener la imagen actual
            if (empty($_FILES['propiedad']['tmp_name']['imagen']) && $propiedad->imagen) {
                $propiedad->setImagen($propiedad->imagen);
            }
            //imagen actualizada


            if (empty($errores)) {
                $resultado = $propiedad->actualizar(); // Usar el método actualizar
                if ($resultado) {
                    header('Location: /public/admin?resultado=2');
                    exit;
                }
            }
        }

        $router->render('propiedades/actualizar', [
            'propiedad' => $propiedad,
            'errores' => $errores
        ]);
    }

    public static function eliminar(Router $router) {
        // var_dump($_SERVER['REQUEST_METHOD']);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validar id
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);
    
            if ($id) {
                $propiedad = Propiedad::find($id);
                if ($propiedad) {
                    $tipo = $_POST['tipo'];
                    if (validarTipoContenido($tipo)) {
                        $resultado = $propiedad->eliminar();
    
                        if ($resultado) {
                            header('Location: /public/admin?resultado=3');
                            exit;
                        } else {
                            echo "Error al eliminar la propiedad.";
                        }
                    }
                } else {
                    echo "Propiedad no encontrada.";
                }
            } else {
                echo "ID inválido.";
            }
        }
        $router->render('propiedades/eliminar', [
            'propiedad' => $propiedad
        ]);
    }
    

    public static function printDir()
    {
        // define('CARPETA_IMAGENES', __DIR__ . '/../public/imagenes');
        echo CARPETA_IMAGENES;
    }
}
