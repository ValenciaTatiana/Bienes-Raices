<?php
// Importar la DB
require 'includes/config/database.php';
$db = conectarDB();
// Crear el email y el password
$email = "adminbinesraices@gmail.com";
$password = "1234abcd";

$passwordHash = password_hash($password, PASSWORD_DEFAULT);

// Query para crear el user
$query = " INSERT INTO usuarios (email, password) VALUES ('{$email}', '{$passwordHash}')";

echo $query;

// Agregarlo a la DB
mysqli_query($db, $query);
?>