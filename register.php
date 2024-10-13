<?php
require_once 'db.php';  // Incluye el archivo de conexión a la base de datos.

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'];     // Captura el nombre de usuario del formulario.
    $password = $_POST['password'];   // Captura la contraseña del formulario.

    // Generar un salt aleatorio
    $salt = bin2hex(random_bytes(16)); // Salt de 16 bytes convertido a hexadecimal

    // Crear el hash de la contraseña con SHA-256
    $hashed_password = hash('sha256', $salt . $password);

    // Insertar el nuevo usuario en la base de datos
    $sql = "INSERT INTO usuarios (usuario, password, salt) VALUES (?, ?, ?)"; // Consulta SQL para insertar un nuevo usuario.
    $stmt = $conn->prepare($sql);                                      // Prepara la consulta SQL.
    $stmt->bind_param("sss", $usuario, $hashed_password, $salt); // Vincula los parámetros.

    if ($stmt->execute()) {
        echo "Usuario registrado correctamente"; // Mensaje de éxito.
    } else {
        echo "Error: " . $conn->error;           // Mensaje de error en caso de fallo.
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
          rel="stylesheet" 
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" 
          crossorigin="anonymous">

    <style>
        body {
          background-color: "#FFFFFF";
        }
        .register-container {
            max-width: 400px;
            margin-top: 100px;
            padding: 20px;
            background-color: lightblue;
            border-radius: 8px;
            box-shadow: 0px 0px 15px rgba(0,0,0,0.1);
        }
    </style>

</head>
<body>
    <div class="container d-flex justify-content-center align-items-center">
        <div class="register-container">
            <h2 class="text-center mb-4">Registrar Usuario</h2>
            <form action="register.php" method="POST">
                <div class="mb-3">
                    <label for="usuario" class="form-label">Usuario</label>
                    <input type="text" name="usuario" class="form-control" id="usuario" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" name="password" class="form-control" id="password" required>
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-success btn-block">Registrar</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>

