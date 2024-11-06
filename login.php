<?php
// Incluir la conexión a la base de datos
include 'db.php';

// Verificar si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Validar que los campos no estén vacíos
    if (empty($username) || empty($password)) {
        echo "Nombre de usuario y contraseña son obligatorios.";
        exit;
    }

    // Consulta para verificar el usuario
    $sql = "SELECT * FROM usuario WHERE nombre = :nombre";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':nombre', $username);

    // Ejecutar la consulta
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verificar si el usuario existe y la contraseña es correcta
    if ($user && password_verify($password, $user['password'])) {
        // Iniciar sesión
        session_start();
        $_SESSION['usuario_id'] = $user['id'];
        $_SESSION['username'] = $username;

        // Verificar si la contraseña es genérica (por ejemplo, "password123")
        $genericPasswordHash = password_hash("password123", PASSWORD_DEFAULT);  // Define tu contraseña genérica aquí

        if (password_verify("password123", $user['password'])) {
            // Redirigir al cambio de contraseña si la contraseña es genérica
            header("Location: cambiar_contraseña.php");
        } else {
            // Redirigir al sistema principal si la contraseña no es genérica
            header("Location: index.php");
        }
        exit;
    } else {
        echo "Nombre de usuario o contraseña incorrectos.";
    }
}
?>
