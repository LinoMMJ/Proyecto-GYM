<?php 
include 'db.php'; // Incluye la conexión a la base de datos

// Inicializar variables
$error = '';
$success = '';
$tipo = '';
$fecha_inicio = '';
$fecha_fin = '';
$usuario_id = '';
$estado = ''; 
// Obtener la lista de usuarios para el dropdown
$usuarios = [];
$sql_usuarios = "SELECT id_usuario, Nombre FROM usuario"; // Cambié 'usuarios' a 'usuario'
$stmt_usuarios = $conn->prepare($sql_usuarios);
$stmt_usuarios->execute();
$usuarios = $stmt_usuarios->fetchAll(PDO::FETCH_ASSOC);

// Verificar si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger los datos del formulario
    $tipo = trim($_POST['tipo']);
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_fin = $_POST['fecha_fin'];
    $usuario_id = $_POST['usuario_id'];

    // Validar los datos
    if (empty($tipo) || empty($fecha_inicio) || empty($fecha_fin) || empty($usuario_id)) {
        $error = 'Por favor, completa todos los campos.';
    } else {
        // Preparar la consulta para insertar en la base de datos
        $sql = "INSERT INTO membresia (Tipo, fecha_inicio, fecha_fin, id_usuario, estado) VALUES (:tipo, :fecha_inicio, :fecha_fin, :id_usuario, :estado)";
        $stmt = $conn->prepare($sql);
        
        // Vincular los parámetros
        $stmt->bindParam(':tipo', $tipo);
        $stmt->bindParam(':fecha_inicio', $fecha_inicio);
        $stmt->bindParam(':fecha_fin', $fecha_fin);
        $stmt->bindParam(':id_usuario', $usuario_id);
        $stmt->bindParam(':estado', $estado); 
        
        // Ejecutar la consulta
        try {
            if ($stmt->execute()) {
                echo "<script>alert('Membresía agregada exitosamente.'); window.location.href='membresias.php';</script>";
                exit; // Asegúrate de salir después de redirigir
            } else {
                $error = 'Error al agregar la membresía. Inténtalo de nuevo.';
            }
        } catch (Exception $e) {
            $error = 'Error al agregar la membresía: ' . htmlspecialchars($e->getMessage());
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Membresía</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
    <div class="sidebar" style="width: 290px;">
        <h2>Mi Sistema</h2>
        <ul>
            <li><a href="index.php">Inicio</a></li>
            <li><a href="crear_usuario.php">Agregar Usuario</a></li>
            <li><a href="usuarios.php">Lista de Usuarios</a></li>
            <li><a href="crear_membresia.php">Agregar Membresía</a></li>
            <li><a href="membresias.php">Lista de Membresías</a></li>
            <li><a href="pagos.php">Pagos</a></li>
            <li><a href="asistencia.php">Asistencias</a></li>
            <li><a href="clases.php">Clases</a></li>
        </ul>
    </div>

    <div class="main-content">
        <header>
            <h1>Agregar Membresía</h1>
        </header>

        <div class="form-container">
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error); ?></div>
            <?php endif; ?>
            <?php if (!empty($success)): ?>
                <div class="alert alert-success"><?= htmlspecialchars($success); ?></div>
            <?php endif; ?>

            <form action="crear_membresia.php" method="POST">
                <div class="mb-3">
                    <label for="usuario_id" class="form-label">Seleccionar Usuario</label>
                    <select class="form-select" id="usuario_id" name="usuario_id" required>
                        <option value="">Seleccione un usuario</option>
                        <?php foreach ($usuarios as $usuario): ?>
                            <option value="<?= htmlspecialchars($usuario['id_usuario']); ?>"><?= htmlspecialchars($usuario['Nombre']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="tipo" class="form-label">Tipo de Membresía</label>
                    <select class="form-select" id="tipo" name="tipo" required>
                        <option value="">Seleccione un tipo de membresía</option>
                        <option value="Mensual" <?= ($tipo == 'Mensual') ? 'selected' : ''; ?>>Mensual</option>
                        <option value="Promoción Halloween" <?= ($tipo == 'Promoción Halloween') ? 'selected' : ''; ?>>Promoción Halloween</option>
                        <option value="Semestral" <?= ($tipo == 'Semestral') ? 'selected' : ''; ?>>Semestral</option>
                        <option value="Anual" <?= ($tipo == 'Anual') ? 'selected' : ''; ?>>Anual</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="fecha_inicio" class="form-label">Fecha Inicio</label>
                    <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" value="<?= htmlspecialchars($fecha_inicio); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="fecha_fin" class="form-label">Fecha Fin</label>
                    <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" value="<?= htmlspecialchars($fecha_fin); ?>" required>
                </div>
                <button type="submit" class="btn btn-success">Agregar Membresía</button>
            </form>
        </div>
    </div>
</body>
</html>
