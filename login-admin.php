<?php
    require 'includes/config/database.php';
    $db = conectarDB();
    // Atenticar user

    $errores = [];

    if($_SERVER['REQUEST_METHOD'] === 'POST') {

        $email = mysqli_escape_string($db, filter_var( $_POST['email'], FILTER_VALIDATE_EMAIL));
        $password = mysqli_escape_string($db, $_POST['password']);

        if(!$email) {
            $errores[] = "El E-mail es obligatorio";
        }
        if(!$password) {
            $errores[] = "El password es obligatorio";
        }

        // Validar existencia de usuario
        $query = " SELECT * FROM usuarios WHERE email = '{$email}'";
        $resultado = mysqli_query($db, $query);

        // Al ser un objeto se usa la flechita
        if($resultado->num_rows) {
            // Resultado de los datos traidos de la DB
            $usuario = mysqli_fetch_assoc($resultado);

            // Verificar si el password es correcto
            $auth = password_verify($password, $usuario['password']);
            if($auth) {
                // El usuario esta autenticado
                session_start();
                
                // LLenar el arreglo o la información de la sesión
                $_SESSION['usuario'] = $usuario['email'];
                $_SESSION['login'] = true;

                header('location: /admin');
                
            } else {
                $errores[] = "El password es incorrecto"; 
            }

        } else {
            $errores[] = "Usuario No Encontrado";
        }
    }

    // Header
    require 'includes/funciones.php';
    incluirTemplate('header');
?>

<main class="contenedor seccion contenido-centrado">
    <h1>Iniciar Sesión Administrador</h1>

    <?php foreach($errores as $error):?>
        <div class="alerta error">
        <?php echo $error; ?>
        </div>
    <?php endforeach; ?>

    <form method="POST" class="formulario">
    <fieldset>
            <legend>Email y Password</legend>

            <label for="email">E-mail</label>
            <input type="email" name="email" placeholder="Tu Email" id="email" require>

            <label for="password">Password</label>
            <input type="password" name="password" placeholder="Tu Password" id="password" require>
        </fieldset>

        <input type="submit" value="Iniciar Sesión" class="boton boton-azul">
    </form>
</main>

<?php
    incluirTemplate('footer');
?>