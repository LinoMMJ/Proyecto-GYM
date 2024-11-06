<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $id_usuario = $_POST['id_usuario'];
    $fecha = $_POST['fecha'];
    $duracion = $_POST['duracion'];

    // Preparar la consulta SQL
    $sql = "INSERT INTO Clase (id_usuario, Fecha, Duracion) VALUES (:id_usuario, :fecha, :duracion)";
    $stmt = $conn->prepare($sql);
    
    // Vincular los parámetros
    $stmt->bindParam(':id_usuario', $id_usuario);
    $stmt->bindParam(':fecha', $fecha);
    $stmt->bindParam(':duracion', $duracion);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        header("Location: clases.php?success=Clase registrada correctamente");
        exit;
    } else {
        $error = "Error al registrar la clase.";
    }
}

// Obtener usuarios para el selector
$sql = "SELECT * FROM Usuario";
$stmt = $conn->prepare($sql);
$stmt->execute();
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Clase</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style/style.css">

</head>
<body>
    <div class="sidebar" style="width: 290px;">
        <h2>Gimnasio Body Fit</h2>
        <ul>
            <li><a href="index.php">Inicio</a></li>
            <li><a href="crear_usuario.php">Agregar Usuario</a></li>
            <li><a href="usuarios.php">Lista de Usuarios</a></li>
            <li><a href="crear_membresia.php">Agregar Membresía</a></li>
            <li><a href="membresias.php">Lista de Membresías</a></li>
            <li><a href="crear_pago.php">Registrar Pago</a></li>
            <li><a href="pagos.php">Lista de Pagos</a></li>
            <li><a href="crear_clase.php">Registrar Clase</a></li>
            <li><a href="clases.php">Lista de Clases</a></li>
            <li><a href="asistencia.php">Asistencias</a></li>
        </ul>
    </div>

    <div class="main-content" style="margin-left: 300px;"> <!-- Ajusta el margen según el ancho del sidebar -->
        <header>
            <h1>Registrar Clase</h1>
        </header>
        <div class="form-container">
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="mb-3 ">
                <label for="id_usuario" class="form-label">ID Usuario</label>
                <select name="id_usuario" id="id_usuario" class="form-select" required>
                    <option value="">Selecciona un usuario</option>
                    <?php foreach ($usuarios as $usuario): ?>
                        <option value="<?= htmlspecialchars($usuario['id_usuario']); ?>"><?= htmlspecialchars($usuario['Nombre']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="fecha" class="form-label">Fecha</label>
                <input type="date" name="fecha" id="fecha" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="duracion" class="form-label">Duración</label>
                <input type="time" name="duracion" id="duracion" class="form-control" placeholder="Ej: 1 hora" required>
            </div>

            <button type="submit">Registrar</button>
            <a href="clases.php" class="btn btn-danger" >Cancelar</a>
        </form>
        </div>
    </div>
</body>
</html>
