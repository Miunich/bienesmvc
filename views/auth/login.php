<main class="contenedor seccion contenido-centrado">
    <h1>Iniciar Sesión</h1>

    <?php foreach ($errores as $error): ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php endforeach; ?>




    <form method="POST" class="formulario" action="/public/login">
        <fieldset>
            <legend>Email y Password</legend>

            <label for="correo">Correo:</label>
            <input type="email" name="email" id="correo" placeholder="Tu Correo" >

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" placeholder="Tu Password" >


        </fieldset>

        <input type="submit" value="Iniciar Sesión" class="boton boton-verde">
    </form>
</main>