<!-- app/vistas/propiedades/vistaActualizar.php -->
<main class="contenedor seccion">
    <h1>Actualizar Propiedad</h1>

    <!-- Mostrar los errores si los hay -->
    <?php foreach ($errores as $error) : ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php endforeach; ?>

    <!-- Botón para volver a la lista de propiedades -->
    <a href="/admin" class="boton boton-verde">Volver</a>

    <!-- Formulario para actualizar la propiedad -->
    <form action="/public/actualizar?id=<?php echo $propiedad->id; ?>" method="POST" enctype="multipart/form-data">
        <label for="titulo">Título</label>
        <input type="text" id="titulo" name="propiedad[titulo]" value="<?php echo $propiedad->titulo; ?>" required>

        <label for="descripcion">Descripción</label>
        <textarea id="descripcion" name="propiedad[descripcion]" required><?php echo $propiedad->descripcion; ?></textarea>

        <label for="precio">Precio</label>
        <input type="number" id="precio" name="propiedad[precio]" value="<?php echo $propiedad->precio; ?>" required>

        <!-- Aquí puedes agregar otros campos del formulario según sea necesario -->

        <input type="submit" value="Actualizar Propiedad1" class="boton boton-verde">
    </form>
</main>
