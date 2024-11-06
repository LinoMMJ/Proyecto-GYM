<?php
include 'db.php';

// Obtener la lista de pagos y las membresías asociadas, junto con su estado
$sql = "SELECT p.id_pago, p.id_membresia, p.Monto, m.fecha_inicio, m.fecha_fin, m.estado 
        FROM Pago p
        JOIN Membresia m ON p.id_membresia = m.id_membresia";
$stmt = $conn->prepare($sql);
$stmt->execute();
$pagos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Función para actualizar el estado de una membresía según sus fechas y pagos
function actualizarEstadoMembresia($fecha_inicio, $fecha_fin, $estado_actual) {
    $hoy = date('Y-m-d');
    
    if ($estado_actual == 'Pendiente') {
        return 'Pendiente'; // Si es pendiente, permanece pendiente hasta que se pague
    } elseif ($hoy >= $fecha_inicio && $hoy <= $fecha_fin) {
        return 'Activo'; // Si está dentro del rango de fechas, es activo
    } elseif ($hoy > $fecha_fin) {
        return 'Vencido'; // Si la fecha actual es mayor que la fecha de fin, está vencido
    }
    return $estado_actual; // Retorna el estado actual si no cambia
}

// Actualizar el estado en la base de datos si es necesario
foreach ($pagos as &$pago) {
    $nuevo_estado = actualizarEstadoMembresia($pago['fecha_inicio'], $pago['fecha_fin'], $pago['estado']);
    if ($nuevo_estado != $pago['estado']) {
        // Actualizamos el estado en la base de datos
        $sql_update = "UPDATE Membresia SET estado = :estado WHERE id_membresia = :id_membresia";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->execute([
            ':estado' => $nuevo_estado,
            ':id_membresia' => $pago['id_membresia']
        ]);
        // Reflejamos el cambio en la variable local
        $pago['estado'] = $nuevo_estado;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagos - Gestión de Membresías</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
            <h1>Lista de Pagos</h1>
            <a href="crear_pago.php"><button class="btn btn-success">Registrar Pago</button></a>
        </header>

        <div class="container">
            <table class="table table-striped">
                <tr>
                    <th>ID</th>
                    <th>ID Membresía</th>
                    <th>Monto</th>
                    <th>Estado Membresía</th>
                    <th>Acciones</th>
                </tr>
                <?php foreach($pagos as $pago): ?>
                <tr>
                    <td><?= htmlspecialchars($pago['id_pago']); ?></td>
                    <td><?= htmlspecialchars($pago['id_membresia']); ?></td>
                    <td><?= htmlspecialchars($pago['Monto']); ?></td>
                    <td><?= htmlspecialchars($pago['estado']); ?></td> <!-- Mostrar el estado de la membresía -->
                    <td>
                        <a class="btn btn-primary" href="editar_pago.php?id=<?= urlencode($pago['id_pago']); ?>"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                        </svg></a>
                        <a class="btn btn-danger" href="eliminar_pago.php?id=<?= urlencode($pago['id_pago']); ?>"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                        <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z"/>
                        </svg></a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</body>
</html>
