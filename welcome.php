<?php
session_start();  // inicio de sesión

if (!isset($_SESSION['usuario'])) {             // verificación de sesión
    header('Location: index.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenida</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2 class="mt-5">¡Bienvenido/a, <?php echo $_SESSION['usuario']; ?>!</h2>
        <p>Has iniciado sesión correctamente.</p>
        <a href="logout.php" class="btn btn-danger">Cerrar sesión</a>
    </div>
</body>
</html>
