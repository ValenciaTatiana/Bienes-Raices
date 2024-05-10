<?php
    /** CONEXIÓN CON LA BASE DE DATOS */

    // Importar la DB
    require '../includes/config/database.php';
    $db = conectarDB();

    // Escribir el Query
    $query = "SELECT * FROM propiedades";

    // Consultar la DB
    $resultadoConsulta = mysqli_query($db, $query);

    // Mostrar mensaje condicional 
    $resultado = $_GET['registro'] ?? null; // En caso de que no encuentre el valor de resultado, se agregar null por defecto

    require '../includes/funciones.php';
    incluirTemplate('header');
?>

<main class="contenedor seccion">
    <h1>Administrador de Bienes Raices</h1>
    <?php if($resultado === "1"): ?>
        <p class="alerta exito">Propiedad Creada Correctamente</p>
    <?php elseif($resultado === "2"): ?>
        <p class="alerta exito">Propiedad Actualizada Correctamente</p>
    <?php endif; ?>
    <a href="/admin/propiedades/crear.php" class="boton boton-azul">Nueva Propiedad</a>

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

        <tbody>
            <?php while( $propiedad = mysqli_fetch_assoc($resultadoConsulta) ): ?>
            <tr>
                <td><?php echo $propiedad['id']; ?></td>
                <td><?php echo $propiedad['titulo']; ?></td>
                <td><img src="/imagenes/<?php echo $propiedad['imagen']; ?>" alt="img de propiedad" class="imagen-tabla"></td>
                <td>$<?php echo $propiedad['precio']; ?></td>
                <td>
                    <a href="#" class="boton-rojo-block">Eliminar</a>
                    <a href="/admin/propiedades/actualizar.php?id=<?php echo $propiedad['id']; ?>" class="boton-verde-block">Actualizar</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</main>

<?php
    // Cerrar la conexión 
    mysqli_close($db);
    incluirTemplate('footer');
?>