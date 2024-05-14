<?php
// Validar que sea un ID valido
$id = $_GET['id'];
$id = filter_var($id, FILTER_VALIDATE_INT);

if (!$id) {
    header('location: /admin');
}

// Conectar DB
require '../../includes/config/database.php';
$db = conectarDB();

// Consulta de los datos de la propiedad
$consultaDataPropiedad = "SELECT * FROM propiedades WHERE id = {$id}";
$resultadoDataPropiedad = mysqli_query($db, $consultaDataPropiedad);
$propiedad = mysqli_fetch_assoc($resultadoDataPropiedad);


// Consulta para obtener los vendedores de la DB
$consultaVendedor = "SELECT * FROM vendedores";
$resultado = mysqli_query($db, $consultaVendedor);

// Array para los mensajes de error
$errores = [];

$titulo = $propiedad['titulo'];
$precio = $propiedad['precio'];
$descripcion = $propiedad['descripcion'];
$habitaciones = $propiedad['habitaciones'];
$wc = $propiedad['wc'];
$estacionamiento = $propiedad['estacionamiento'];
$vendedorId = $propiedad['vendedores_id'];
$imagenPropiedad = $propiedad['imagen'];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Con mysqli_real_escape_string se escapa de una posible inyección de SQL
    $titulo = mysqli_real_escape_string($db, $_POST['titulo']);
    $precio = mysqli_real_escape_string($db, $_POST['precio']);
    $descripcion = mysqli_real_escape_string($db, $_POST['descripcion']);
    $habitaciones = mysqli_real_escape_string($db, $_POST['habitaciones']);
    $wc = mysqli_real_escape_string($db, $_POST['wc']);
    $estacionamiento = mysqli_real_escape_string($db, $_POST['estacionamiento']);
    $vendedorId = mysqli_real_escape_string($db, $_POST['vendedores_id']);
    $creado = date('Y-m-d');

    // Files hacia una variable
    $imagen = $_FILES['imagen'];

    if (!$titulo) {
        $errores[] = "Debes añadir un titulo.";
    }
    if (!$precio) {
        $errores[] = "El precio es obligatorio.";
    }
    if (strlen($descripcion) < 50) {
        $errores[] = "La descripcion es obligatorio y debe tener almenos 50 caracteres.";
    }
    if (!$habitaciones) {
        $errores[] = "El numero de habitaciones es obligatorio.";
    }
    if (!$wc) {
        $errores[] = "El numero de baños es obligatorio.";
    }
    if (!$estacionamiento) {
        $errores[] = "El numero de estacionamientos es obligatorio.";
    }
    if (!$vendedorId) {
        $errores[] = "El nombre del vendedor es obligatorio.";
    }

    //Validar por tamaño (Max. 100Mb)
    // Para concertir de Bt a Kb
    $medida = $medida = 1000 * 1000 * 2;

    if ($imagen['size'] > $medida) {
        $errores[] = "La imagen es muy pesada.";
    }

    // Revisar que el arreglo de errores este vacio para poder guardar los datos en el formulario
    if (empty($errores)) {
        /** SUBIDA DE LOS ARCHIVOS */

        // Crear una nueva carpeta para las imagenes
        $carpetaImg = '../../imagenes/';

        if (!is_dir($carpetaImg)) {
            mkdir($carpetaImg);
        }

        $nombreUnicoImagen = '';

        // Eliminar la imagen ya existente, si se sube una nueva

        if ($imagen['name']) {
            unlink($carpetaImg . $propiedad['imagen']);

            // Generar un nombre unico para las imagenes
            $nombreUnicoImagen = md5(uniqid(rand(), true)) . ".jpg";

            // Subir la imagen 
            move_uploaded_file($imagen['tmp_name'], $carpetaImg . $nombreUnicoImagen);
        } else {
            $nombreUnicoImagen = $propiedad['imagen'];
        }

        // Insertar datos en la DB
        $query = " UPDATE propiedades SET titulo = '{$titulo}', precio = {$precio}, imagen = '{$nombreUnicoImagen}', descripcion = '{$descripcion}', habitaciones = {$habitaciones}, wc = '{$wc}', estacionamiento = {$estacionamiento}, vendedores_id = '{$vendedorId}' WHERE id = {$id} ";

        // Guardar Datos
        $resultado = mysqli_query($db, $query);

        if ($resultado) {
            // Redirecionar al usuario una vez se envie el formulario
            header('location: /admin?registro=2');
        }
    }
}

require '../../includes/funciones.php';
incluirTemplate('header');
?>

<main class="contenedor seccion">
    <h1>Actualizar la Propiedad</h1>
    <a href="/admin" class="boton boton-azul">Volver</a>

    <?php foreach ($errores as $error) : ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php endforeach; ?>

    <form class="formulario" method="POST" enctype="multipart/form-data">
        <fieldset>
            <legend>Información General</legend>

            <label for="titulo">titulo</label>
            <input type="text" id="titulo" name="titulo" placeholder="Titulo Propiedad" value="<?php echo $titulo; ?>">

            <label for="precio">precio</label>
            <input type="number" id="precio" name="precio" placeholder="Precio Propiedad" value="<?php echo $precio; ?>">

            <label for="imagen">imagen:</label>
            <input type="file" id="imagen" accept="image/jpeg, image/png" name="imagen">

            <img src="/imagenes/<?php echo $imagenPropiedad; ?> " class="imagen-small">

            <label for="descripcion">descripcion</label>
            <textarea id="descripcion" name="descripcion"><?php echo $descripcion; ?></textarea>
        </fieldset>

        <fieldset>
            <legend>Información Propiedad</legend>

            <label for="habitaciones">habitaciones</label>
            <input type="number" id="habitaciones" name="habitaciones" placeholder="Ejm. 3" min="1" max="9" value="<?php echo $habitaciones; ?>">

            <label for="wc">baños</label>
            <input type="number" id="wc" name="wc" placeholder="Ejm. 3" min="1" max="9" value="<?php echo $wc; ?>">

            <label for="estacionamiento">estacionamiento</label>
            <input type="number" id="estacionamiento" name="estacionamiento" placeholder="Ejm. 3" min="1" max="9" value="<?php echo $estacionamiento; ?>">

        </fieldset>

        <fieldset>
            <legend>Información de Vendedor</legend>

            <select name="vendedores_id" value="<?php echo $vendedorId; ?>">
                <option value="">-- Seleccionar --</option>
                <?php while ($vendedor = mysqli_fetch_assoc($resultado)) { ?>
                    <option <?php echo $vendedorId === $vendedor['id'] ? 'selected' : ''; ?> value="<?php echo $vendedor['id']; ?>"><?php echo $vendedor['nombre'] . " " . $vendedor['apellido']; ?></option>
                <?php }; ?>
            </select>

        </fieldset>

        <input type="submit" value="Actualizar Propiedad" class="boton boton-azul">

    </form>
</main>

<?php
incluirTemplate('footer');
?>