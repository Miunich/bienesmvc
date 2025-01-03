<?php

// require_once '../../includes/app.php';

use Model\Propiedad;
use Model\vendedor;
use Intervention\Image\ImageManager as Image;
use Intervention\Image\Drivers\GD\Driver;

$db = conectarDB();

// Conectar a la base de datos

if (!$db) {
    die("Error: No se pudo conectar a la base de datos.");
}


$queryVendedores = "SELECT vendedor_id, nombre, apellido FROM vendedores";
$resultadoVendedores = mysqli_query($db, $queryVendedores);
$propiedad = new Propiedad($_POST);
if (!$resultadoVendedores) {
    die("Error en la consulta de vendedores: " . mysqli_error($db));
}

//Ejecutar el codigo despues de que el usuario envie el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $vendedor_id = $_POST['vendedor_id'] ?? '';
    $errores = $propiedad->validar();
    //Revisar que el arreglo de errores este vacio
    if (empty($errores)) {
        $manager = new Image(Driver::class);
    }
}
?>

<fieldset>
    <legend>Información General</legend>

    <label for="titulo">Titulo:</label>
    <input type="text" id="titulo" name="propiedad[titulo]"  placeholder="Titulo Propiedad" value="<?php echo s($propiedad->titulo); ?>">

    <label for="precio">Precio:</label>
    <input type="number" id="precio" name="propiedad[precio]" placeholder="Precio Propiedad" value="<?php echo s($propiedad->precio); ?>">

    <label for="imagen">Imagen:</label>
    <input type="file" id="imagen" accept="image/jpeg, image/png, image/jpg" name="propiedad[imagen]">

    <label for="descripcion">Descripción:</label>
    <textarea id="descripcion" name="propiedad[descripcion]"><?php echo s($propiedad->descripcion); ?></textarea>

</fieldset>

<fieldset>

    <legend>Información Propiedad</legend>

    <label for="habitaciones">Habitaciones:</label>
    <input type="number" id="habitaciones" name="propiedad[habitaciones]" placeholder="Ej. 3" min="1" max="9" value="<?php echo s($propiedad->habitaciones); ?>">
    <label for="wc">Baños:</label>
    <input type="number" id="wc" name="wc" placeholder="Ej. 2" min="1" max="3" value="<?php echo s($propiedad->wc); ?>">

    <label for="estacionamiento">Estacionamiento:</label>
    <input type="number" id="estacionamiento" name="propiedad[estacionamiento]" placeholder="Ej. 2" min="1" max="3" value="<?php echo s($propiedad->estacionamiento); ?>">

</fieldset>

<fieldset>
    <legend>Vendedor</legend>
    <select name="propiedad[vendedor_id]" id="vendedor">
        <option value="">-- Seleccione --</option>
        <?php while ($vendedor = mysqli_fetch_assoc($resultadoVendedores)) : ?>
            <option value="<?php echo $vendedor['vendedor_id']; ?>" <?php echo (isset($vendedor_id) && $vendedor_id == $vendedor['vendedor_id']) ? 'selected' : ''; ?>>
                <?php echo htmlspecialchars($vendedor['nombre'] . " " . $vendedor['apellido']); ?>
            </option>
        <?php endwhile; ?>
    </select>
</fieldset>