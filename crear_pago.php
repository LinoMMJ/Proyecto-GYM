<?php
include 'db.php'; // Incluye la conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger los datos del formulario
    $id_membresia = $_POST['id_membresia'];
    $monto = $_POST['monto'];

    // Verificar el estado de la membresía
    $sql_check = "SELECT estado FROM membresia WHERE id_membresia = :id_membresia";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bindParam(':id_membresia', $id_membresia);
    $stmt_check->execute();
    $membresia = $stmt_check->fetch(PDO::FETCH_ASSOC);

    if ($membresia) {
        // Si la membresía está "Pendiente", proceder a activar
        if ($membresia['estado'] == 'Pendiente') {
            // Preparar la consulta para insertar en la base de datos
            $sql_pago = "INSERT INTO Pago (id_membresia, Monto) VALUES (:id_membresia, :monto)";
            $stmt_pago = $conn->prepare($sql_pago);

            // Vincular los parámetros
            $stmt_pago->bindParam(':id_membresia', $id_membresia);
            $stmt_pago->bindParam(':monto', $monto);

            // Ejecutar la consulta de pago
            if ($stmt_pago->execute()) {
                // Actualizar el estado de la membresía a "Activo"
                $sql_update = "UPDATE membresia SET estado = 'Activo' WHERE id_membresia = :id_membresia";
                $stmt_update = $conn->prepare($sql_update);
                $stmt_update->bindParam(':id_membresia', $id_membresia);
                $stmt_update->execute();

                echo "<script>alert('Pago registrado y membresía activada exitosamente.'); window.location.href='pagos.php';</script>";
            } else {
                echo "<script>alert('Error al registrar el pago.');</script>";
            }
        } elseif ($membresia['estado'] == 'Activo') {
            // Aquí podrías decidir si quieres hacer algo si la membresía ya está activa
            echo "<script>alert('La membresía ya está activa.');</script>";
        } elseif ($membresia['estado'] == 'Vencido') {
            // Si la membresía está vencida, podrías renovarla o indicar que el pago se está registrando para renovarla
            echo "<script>alert('La membresía está vencida. Realiza el pago para renovarla.');</script>";
        }
    } else {
        echo "<script>alert('La membresía no existe.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Pago</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
    <div class="sidebar">
        <h2>Mi Sistema</h2>
        <ul>
            <li><a href="index.php">Inicio</a></li>
            <li><a href="crear_usuario.php">Agregar Usuario</a></li>
            <li><a href="usuarios.php">Lista de Usuarios</a></li>
            <li><a href="crear_membresia.php">Agregar Membresía</a></li>
            <li><a href="membresias.php">Lista de Membresías</a></li>
            <li><a href="crear_pago.php">Registrar Pago</a></li>
            <li><a href="pagos.php">Lista de Pagos</a></li>
            <li><a href="asistencia.php">Asistencias</a></li>
            <li><a href="clases.php">Clases</a></li>
        </ul>
    </div>

    <div class="main-content">
        <header>
            <h1>Registrar Pago</h1>
        </header>

        <div class="form-container">
            <form action="crear_pago.php" method="POST">
                <div class="mb-3">
                    <label for="id_membresia" class="form-label">ID Membresía</label>
                    <input type="number" class="form-control" id="id_membresia" name="id_membresia" required>
                </div>
                <div class="mb-3">
                    <label for="monto" class="form-label">Monto</label>
                    <input type="number" step="0.01" class="form-control" id="monto" name="monto" required>
                </div>
                <button type="submit" class="btn btn-primary">Registrar Pago</button>
            </form>
        </div>
    </div>
</body>
</html>
