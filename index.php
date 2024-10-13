<?php
session_start();      // Inicia una nueva sesión o reanuda una existente.
require_once 'db.php';  // Incluye el archivo de conexión a la base de datos.
// verificar si el metodo es un POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {       
    $usuario = $_POST['usuario'];   // Captura el nombre de usuario del formulario.
    $password = $_POST['password']; // Captura la contraseña del formulario.

    // Verificar si el usuario existe
    $sql = "SELECT * FROM usuarios WHERE usuario = ?";
    $stmt = $conn->prepare($sql);       // Consulta SQL para verificar si el usuario existe.
    $stmt->bind_param("s", $usuario); // Vincula el parámetro de consulta.
    $stmt->execute();   // Ejecuta la consulta.
    $result = $stmt->get_result(); // Obtiene el resultado de la consulta.
    
    if ($result->num_rows > 0) {      // Verifica si el usuario existe en la base de datos.
        $row = $result->fetch_assoc();  // Recupera los datos del usuario como un arreglo asociativo.
        $hashed_password = $row['password'];  // Obtiene la contraseña encriptada.
        $salt = $row['salt'];   // Obtiene el salt.
        
        // Verificar la contraseña utilizando el salt almacenado
        $hashed_input_password = hash('sha256', $salt . $password); // Genera el hash de la contraseña ingresada + salt.

        if ($hashed_password === $hashed_input_password) {    // Compara la contraseña almacenada con la ingresada.
            $_SESSION['usuario'] = $usuario;                  // Almacena el nombre de usuario en la sesión.
            header('Location: welcome.php');          // Redirige a la página de bienvenida.
            exit;
        } else {
            $error = "Contraseña incorrecta.";  // Mensaje de error si la contraseña no coincide.
        }
    } else {
        $error = "Usuario no encontrado.";      // Mensaje de error si no se encuentra el usuario.
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
          rel="stylesheet" 
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" 
          crossorigin="anonymous">
          
          
    <style>
        body {
          background-color: #365370;  
        }
        .login-container {
            max-width: 400px;
            margin-top: 100px;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0px 0px 15px rgba(0,0,0,0.1);
        }
    </style>

</head>
<body>
    <div class="container d-flex justify-content-center align-items-center">
        <div class="login-container">
            <h2 class="text-center mb-4">Iniciar Sesión</h2>
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            <form action="index.php" method="POST">
                <div class="mb-3">
                    <label for="usuario" class="form-label">Usuario</label>
                    <input type="text" name="usuario" class="form-control" id="usuario" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" name="password" class="form-control" id="password" required>
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-block">Iniciar sesión</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
