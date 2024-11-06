<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id_membresia = $_GET['id'];
    
    // Consulta SQL para obtener los detalles de la membresía
    $sql = "SELECT * FROM membresia WHERE id_membresia = :id_membresia";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_membresia', $id_membresia);
    $stmt->execute();
    $membresia = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verifica si se encontró la membresía
    if (!$membresia) {
        echo "Membresía no encontrada.";
        exit;
    }
} else {
    echo "ID de membresía no especificado.";
    exit;
}

// Procesar el formulario de edición si se envía
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tipo = $_POST['tipo'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_fin = $_POST['fecha_fin'];

    // Obtener el estado actual de la membresía
    $estado = $membresia['estado']; // Usa el estado existente

    // Actualizar la membresía en la base de datos
    $sql = "UPDATE membresia SET Tipo = :tipo, fecha_inicio = :fecha_inicio, fecha_fin = :fecha_fin, estado = :estado WHERE id_membresia = :id_membresia";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':tipo', $tipo);
    $stmt->bindParam(':fecha_inicio', $fecha_inicio);
    $stmt->bindParam(':fecha_fin', $fecha_fin);
    $stmt->bindParam(':estado', $estado); // Usa el estado existente
    $stmt->bindParam(':id_membresia', $id_membresia);
    
    if ($stmt->execute()) {
        header("Location: membresias.php?mensaje=Actualización exitosa");
        exit;
    } else {
        echo "Error al actualizar la membresía.";
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Membresía</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
   
</head>
<body>
    <div class="sidebar">
        <h2>Gimnasio Body Fit</h2>
        <ul>
            <li><a href="index.php"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-house-door-fill" viewBox="0 0 16 16">
                <path d="M6.5 14.5v-3.505c0-.245.25-.495.5-.495h2c.25 0 .5.25.5.5v3.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5"/>
                </svg> Inicio</a></li>
            <li><a href="usuarios.php"><i class="fas fa-users"></i> Usuarios</a></li>
            <li><a href="membresias.php"><i class="fas fa-id-card"></i> Membresías</a></li>
            <li><a href="asistencia.php"><i class="fas fa-calendar-check"></i> Asistencia</a></li>
            <li><a href="clases.php"><i class="fas fa-chalkboard-teacher"></i> Clases</a></li>
        </ul>
    </div>
    <div class="main-content">
        <h1>Editar Membresía</h1>
        <div class="form-container">
        <form method="POST">
            <div class="mb-3">
                <label for="tipo" class="form-label">Tipo de Membresía</label>
                <select class="form-select" id="tipo" name="tipo" required>
                    <option value="">Seleccione un tipo de membresía</option>
                    <option value="Mensual" <?= ($membresia['Tipo'] == 'Mensual') ? 'selected' : ''; ?>>Mensual</option>
                    <option value="Promoción Halloween" <?= ($membresia['Tipo'] == 'Promoción Halloween') ? 'selected' : ''; ?>>Promoción Halloween</option>
                    <option value="Semestral" <?= ($membresia['Tipo'] == 'Semestral') ? 'selected' : ''; ?>>Semestral</option>
                    <option value="Anual" <?= ($membresia['Tipo'] == 'Anual') ? 'selected' : ''; ?>>Anual</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="fecha_inicio" class="form-label">Fecha Inicio</label>
                <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" value="<?= htmlspecialchars($membresia['fecha_inicio']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="fecha_fin" class="form-label">Fecha Fin</label>
                <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" value="<?= htmlspecialchars($membresia['fecha_fin']); ?>" required>
            </div>
            <div class="mb-3">
                    <label class="form-label">Estado de la Membresía</label>
                    <input type="text" class="form-control" value="<?= htmlspecialchars($membresia['estado']); ?>" readonly>
                </div>
            <button type="submit" class="btn btn-primary">Actualizar Membresía</button>
        </form>
        </div>
        
    </div>
</body>
</html>
