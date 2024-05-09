<?php

function conectarDB() : mysqli {
    $db = mysqli_connect('localhost', 'root', 'Cuadros.2023', 'bienesraices_crud');

    if(!$db) {
        echo "Hubo un error!!";
        exit;
    }

    return $db;
}