<?php
include 'db.php';

$sql = "SELECT * FROM Asistencia";
$stmt = $conn->prepare($sql);
$stmt->execute();
$asistencias = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asistencias - Gestión de Membresías</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> 
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
            <li><a href="registrar_asistencia.php">Registrar Asistencia</a></li>
            <li><a href="asistencia.php">Lista de Asistencias</a></li>
        </ul>
    </div>

    <div class="main-content">
        <header>
            <h1>Lista de Asistencias</h1>
            <a href="registrar_asistencia.php"><button class="btn btn-success">Registrar Asistencia</button></a>
        </header>

        <div class="container">
            <table class="table table-striped">
                <tr>
                    <th>ID</th>
                    <th>ID Usuario</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
                <?php foreach($asistencias as $asistencia): ?>
                <tr>
                    <td><?= htmlspecialchars($asistencia['id_asistencia']); ?></td>
                    <td><?= htmlspecialchars($asistencia['id_usuario']); ?></td>
                    <td><?= isset($asistencia['Fecha']) ? htmlspecialchars($asistencia['Fecha']) : 'No disponible'; ?></td>

                    <td>
                        <a class="btn btn-primary" href="editar_asistencia.php?id=<?= urlencode($asistencia['id_asistencia']); ?>"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                        </svg></a>
                        <a class="btn btn-danger" href="eliminar_asistencia.php?id=<?= urlencode($asistencia['id_asistencia']); ?>"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                        <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5"/>
                        </svg></a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</body>
</html>
