<?php

if (!isset($_SESSION)) {
    session_start();
}

$auth = $_SESSION['login'] ?? null;

if(!isset($inicio)){
    $inicio = false;
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienes Raíces</title>
    <link rel="stylesheet" href="../../public/build/css/app.css">
    <!-- quiero agregar el js de app.js para que funcione el menu -->
    <script src="src/js/app.js"></script>

</head>

<body>


    <header class="header <?php echo isset($inicio) && $inicio ? 'inicio' : ''; ?>">

        <div class="contenedor contenido-header">
            <div class="barra">
                <a href="/public/">
                    <img src="../../public/build/img/logo.svg" alt="logo">
                </a>
                <div class="mobile-menu">
                    <img src="/build/img/barras.svg" alt="icono menu responsive">
                </div>
                <div class="derecha">
                    <img src="../../public/build/img/dark-mode.svg" alt="dark-mode" class="dark-mode-boton">
                    <nav class="navegacion">
                        <a href="/public/nosotros">Nosotros</a>
                        <a href="/public/propiedades">Anuncios</a>
                        <a href="/public/blog">Blog</a>
                        <a href="/public/contacto">Contacto</a>
                        <?php if ($auth) : ?>
                            <a href="/public/logout">Cerrar Sesión</a>
                        <?php endif; ?>
                    </nav>
                </div>
            </div><!--fin barra-->
            <?php if (isset($inicio) && $inicio) : ?>
                <h1>Venta de Casas y Departamentos Exclusivos de Lujo</h1>
            <?php endif; ?>

        </div>
    </header>
    <!-- </body> -->
    <?php echo $contenido; ?>

    <footer class="footer seccion">
        <div class="contenedor contenedor-footer">
            <nav class="navegacion">
                <a href="nosotros">Nosotros</a>
                <a href="anuncios.php">Anuncios</a>
                <a href="blog.php">Blog</a>
                <a href="contacto.php">Contacto</a>
            </nav>
        </div>

        <p class="copyright"> Todos los derechos reservados 2025 &copy;</p>
    </footer>
    <script src="../public/build/js/bundle.min.js"></script>
</body>

</html>