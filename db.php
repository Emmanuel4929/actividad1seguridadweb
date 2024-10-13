<?php
$host = "localhost"; // Nombre de usuario de 
$user = "root";     // Nombre de usuario de MySQL
$password = "";     // Contraseña de MySQL
$dbname = "login_applicacion";   // Nombre de la base de datos

// Crear la conexión
$conn = new mysqli($host, $user, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
