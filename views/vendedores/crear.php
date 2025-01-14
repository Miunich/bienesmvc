<main class="contenedor seccion">
    <h1>Ingresar Vendedor(a)</h1>

    <a href="/public/admin" class="boton boton-verde">Volver</a>

    <!-- Mostrar errores si los hay -->
    <?php foreach ($errores as $error): ?>
        <div class="alerta error">
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endforeach; ?>

    <!-- Formulario -->
    <form action="/public/vendedores/crear" class="formulario" method="POST" enctype="multipart/form-data">
        <?php include __DIR__ . '/formulario.php'; ?>
        <input type="submit" value="Registrar Vendedor(a)" class="boton boton-verde">
    </form>
</main>