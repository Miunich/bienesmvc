<main class="contenedor seccion">
    <h1>Administrador de Bienes Raíces</h1>
    <?php
    // Capturar el valor de 'resultado' desde la URL
    $resultado = $_GET['resultado'] ?? null;

    if ($resultado) {
        if ($resultado == '1'): ?>
            <p class="alerta exito">Anuncio creado correctamente</p>
        <?php elseif ($resultado == '2'): ?>
            <p class="alerta exito">Anuncio actualizado correctamente</p>
        <?php elseif ($resultado == '3'): ?>
            <p class="alerta error">Anuncio borrado correctamente</p>
        <?php elseif ($resultado == '4'): ?>
            <p class="alerta error">Vendedor borrado correctamente</p>
        <?php elseif ($resultado == '5'): ?>
            <p class="alerta exito">Vendedor actualizado correctamente</p>
        <?php elseif ($resultado == '6'): ?>
            <p class="alerta exito">Vendedor creado correctamente</p>
    <?php endif;
    }
    ?>


    <a href="/public/propiedad/crear" class="boton boton-verde"> Nueva Propiedad</a>
    <a href="/public/vendedores/crear" class="boton boton-amarillo"> Nuevo(a) vendedor</a>

    <h2>Propiedades</h2>
    <table class="propiedades">
        <thead>
            <tr>
                <th>ID</th>
                <th>Titulo</th>
                <th>Imagen</th>
                <th>Precio</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody><!--Mostrar los resultados-->
            <!-- recorrer los resultados -->
            <?php foreach ($propiedades as $propiedad): ?>
                <tr>
                    <td><?php echo $propiedad->id; ?></td>
                    <td><?php echo $propiedad->titulo; ?></td>
                    <td> <img src="/public/imagenes/<?php echo $propiedad->imagen; ?>" alt="" class="imagen-tabla"></td>
                    <td>$ <?php echo $propiedad->precio; ?></td>
                    <td>
                        <form action="/public/propiedad/eliminar" method="POST" class="w-100">
                            <input type="hidden" name="id" value="<?= $propiedad->id; ?>">
                            <input type="hidden" name="tipo" value="propiedad">
                            <input type="submit" class="boton-rojo-block" value="Eliminar">
                        </form>
                        <a href="/public/propiedad/actualizar?id=<?php echo htmlspecialchars($propiedad->id); ?>" class="boton-amarillo-block">Actualizar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        </table>
        <!-- test de vendedores -->
        <h2>Vendedores</h2>

        <table class="propiedades">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody><!--Mostrar los resultados-->
                <?php foreach ($vendedores as $vendedor): ?>
                    <tr>
                        <td><?php echo $vendedor->vendedor_id; ?></td>
                        <!-- quiero mostrar el nombre y apellido del vendedor de una sola vez
                  -->
                        <td><?php echo $vendedor->nombre . " " . $vendedor->apellido; ?></td>

                        <td> <!-- Acciones -->
                            <form action="" method="POST" class="w-100">
                                <input type="hidden" name="id" value="<?= $vendedor->vendedor_id; ?>">
                                <input type="hidden" name="tipo" value="vendedor">
                                <input type="submit" class="boton-rojo-block" value="Eliminar">
                            </form>
                            <a href="vendedores/actualizar.php?id=<?php echo $vendedor->vendedor_id; ?>" class="boton-amarillo-block">Actualizar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>

            <!-- test de vendedores -->
        </table>
</main>