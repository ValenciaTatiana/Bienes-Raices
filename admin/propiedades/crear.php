<?php
    // Conectar DB
    require '../../includes/config/database.php';
    $db = conectarDB();

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        echo "<pre>";
        var_dump($_POST);
        echo "</pre>";

        $titulo = $_POST['titulo'];
        $precio = $_POST['precio'];
        $descripcion = $_POST['descripcion'];
        $habitaciones = $_POST['habitaciones'];
        $wc = $_POST['wc'];
        $estacionamiento = $_POST['estacionamiento'];
        $vendedorId = $_POST['vendedor'];

        // Insertar datos en la DB
        $query = " INSERT INTO propiedades ( titulo, precio, descripcion, habitaciones, wc, estacionamiento, vendedores_Id ) VALUES 
        ('$titulo', '$precio', '$descripcion', '$habitaciones', '$wc', '$estacionamiento', '$vendedorId') ";

        // Guardar Datos
        $resultado = mysqli_query($db, $query);

        if($resultado) {
            echo "Enviando datos...";
        }
    }

    require '../../includes/funciones.php';
    incluirTemplate('header');
?>

<main class="contenedor seccion">
    <h1>Crear</h1>
    <a href="/admin" class="boton boton-azul">Volver</a>

    <form class="formulario" method="POST" action="/admin/propiedades/crear.php">
        <fieldset>
            <legend>Información General</legend>

            <label for="titulo">titulo</label>
            <input type="text" id="titulo" name="titulo" placeholder="Titulo Propiedad">

            <label for="precio">precio</label>
            <input type="number" id="precio" name="precio" placeholder="Precio Propiedad">

            <label for="imagen">imagen:</label>
            <input type="file" id="imagen" accept="image/jpeg, image/png">

            <label for="descripcion">descripcion</label>
            <textarea id="descripcion" name="descripcion"></textarea>
        </fieldset>

        <fieldset>
            <legend>Información Propiedad</legend>

            <label for="habitaciones">habitaciones</label>
            <input type="number" id="habitaciones" name="habitaciones" placeholder="Ejm. 3" min="1" max="9">

            <label for="wc">baños</label>
            <input type="number" id="wc" name="wc" placeholder="Ejm. 3" min="1" max="9">

            <label for="estacionamiento">estacionamiento</label>
            <input type="number" id="estacionamiento" name="estacionamiento" placeholder="Ejm. 3" min="1" max="9">

        </fieldset>

        <fieldset>
            <legend>Información de Vendedor</legend>

            <select  name="vendedor">
                <option value="1">Tatiana</option>
                <option value="2">Andres</option>
            </select>

        </fieldset>

        <input type="submit" value="Crear Propiedad" class="boton boton-azul">

    </form>
</main>

<?php
    incluirTemplate('footer');
?>