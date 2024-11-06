<?php
// Incluir conexión a la base de datos
include 'db.php';

// Verificar si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $nombre = trim($_POST['nombre']);
    $email = trim($_POST['email']);
    $telefono = trim($_POST['telefono']);
    $password = $_POST['password'];

    // Validar que los campos no estén vacíos
    if (empty($nombre) || empty($email) || empty($telefono) || empty($password)) {
        echo "Todos los campos son obligatorios.";
        exit;
    }

    // Validar formato de email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "El correo electrónico no es válido.";
        exit;
    }

    // Hashear la contraseña antes de guardarla
    $passwordHashed = password_hash($password, PASSWORD_DEFAULT);

    // Preparar la consulta para insertar el nuevo usuario
    $sql = "INSERT INTO usuario (nombre, email, telefono, password) VALUES (:nombre, :email, :telefono, :password)";
    $stmt = $conn->prepare($sql);

    // Ejecutar la consulta con los parámetros del formulario
    try {
        $stmt->execute([
            ':nombre' => $nombre,
            ':email' => $email,
            ':telefono' => $telefono,
            ':password' => $passwordHashed
        ]);
        // Redirigir a la lista de usuarios después de la creación exitosa
        header("Location: usuarios.php");
        exit;
    } catch (PDOException $e) {
        // Manejar errores en la inserción
        echo "Error al crear usuario: " . $e->getMessage();
    }
}
?>
