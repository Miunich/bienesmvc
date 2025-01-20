<?php

namespace Controllers;

use MVC\Router;
use Model\Propiedad;
use PHPMailer\PHPMailer\PHPMailer;

class PaginasController
{
    public static function index(Router $router)
    {
        $inicio = true;
        $propiedades = Propiedad::get(3);
        $router->render('paginas/index', [
            'propiedades' => $propiedades,
            'inicio' => $inicio
        ]);
    }
    public static function nosotros(Router $router)
    {
        $router->render('paginas/nosotros');
    }
   
    public static function propiedades(Router $router)
    {
        $propiedades = Propiedad::all();
        $router->render('paginas/propiedades', [
            'propiedades'=>$propiedades
        ]);
    }
    
    public static function propiedad(Router $router)
    {
        $id = validarORedireccionar('/public/propiedades');
        //buscar la propiedad por su id
        $propiedad = Propiedad::find($id);
        $router->render('paginas/propiedad', [
            'propiedad' => $propiedad
        ]);
    }
    
    public static function blog(Router $router)
    {
        $router->render('paginas/blog');
    }
    
    public static function entrada(Router $router)
    {
        $router->render('paginas/entrada');
    }
    
    public static function contacto(Router $router)
    {
        $mensaje = null;

        if($_SERVER['REQUEST_METHOD'] === 'POST'){


            $respuestas = $_POST['contacto'];
            // debuguear($respuestas);
            // debuguear($_POST);

            // Crear una instancia de PHPMailer
            $mail = new PHPMailer();

            // Configurar SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Username = '99eac0e49a5c5f';
            $mail->Password = '290a64e919d9e7';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 2525;

            // Configurar el contenido del email
            $mail->setFrom('admin@bienesraices.com');
            $mail->addAddress('admin@bienesraices.com', 'Bienes Raices');
            $mail->Subject = 'Tienes un nuevo mensaje';

            // Habilitar HTML
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';

            // Definir el contenido
            $contenido = '<html>';
            $contenido .= '<p>Tienes un nuevo mensaje</p>';
            $contenido .= '<p>Nombre: ' . $respuestas['nombre'] . '</p>';
            

            //Enviar de forma condicional algunos campos de email o teléfono
            if($respuestas['contacto'] === 'telefono'){

            }else{
                //Es email, entonces agregamos el campo de email
                $contenido .=
                $contenido .= '<p>Correo: ' . $respuestas['email'] . '</p>';
            }

            $contenido .= '<p>Teléfono: ' . $respuestas['telefono'] . '</p>';
            $contenido .= '<p>Mensaje: ' . $respuestas['mensaje'] . '</p>';
            $contenido .= '<p>Vende o Compra: ' . $respuestas['tipo'] . '</p>';
            $contenido .= '<p>Precio o Presupuesto: $' . $respuestas['precio'] . '</p>';
            $contenido .= '<p>Contactar por: ' . $respuestas['contacto'] . '</p>';
            $contenido .= '<p>Fecha de contacto: ' . $respuestas['fecha'] . '</p>';
            $contenido .= '<p>Hora de contacto: ' . $respuestas['hora'] . '</p>';
            $contenido .= '</html>';

            $mail->Body = $contenido;
            // Enviar el email
            if($mail->send()){
                $mensaje = "Mensaje enviado correctamente";
            } else {
                $mensaje = "No se pudo enviar el mensaje";
            }
        }
        $router->render('paginas/contacto',[
            'mensaje' => $mensaje

        ]);
    }
    
}