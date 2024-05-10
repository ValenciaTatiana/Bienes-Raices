<?php
    $resultado = $_GET['registro'] ?? null; // En caso de que no encuentre el valor de resultado, se agregar null por defecto

    require '../includes/funciones.php';
    incluirTemplate('header');
?>

<main class="contenedor seccion">
    <h1>Administrador de Bienes Raices</h1>
    <?php if($resultado === "1"): ?>
        <p class="alerta exito">Propiedad Creada Correctamente</p>
    <?php endif; ?>
    <a href="/admin/propiedades/crear.php" class="boton boton-azul">Nueva Propiedad</a>
</main>

<?php
    incluirTemplate('footer');
?>