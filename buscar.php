<?php
include 'db.php';

// Verificar si se ha enviado la consulta
if (isset($_GET['query'])) {
    $query = $_GET['query'];
    
    // Preparar la consulta para buscar usuarios
    $sql = "SELECT * FROM Usuario WHERE nombre LIKE :query OR email LIKE :query";
    $stmt = $conn->prepare($sql);
    
    // Usar parámetros para prevenir inyecciones SQL
    $stmt->bindValue(':query', '%' . $query . '%');
    
    // Ejecutar la consulta
    $stmt->execute();
    
    // Obtener los resultados
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $usuarios = [];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados de Búsqueda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

    <!-- Barra lateral -->
    <div class="sidebar" style="width: 290px;">
        <h2>Panel de Control</h2>
        <ul>
            <li><a href="index.php"><i class="fas fa-home"></i> Inicio</a></li>
            <li><a href="usuarios.php"><i class="fas fa-users"></i> Usuarios</a></li>
            <li><a href="membresias.php"><i class="fas fa-id-card"></i> Membresías</a></li>
            <li><a href="asistencia.php"><i class="fas fa-calendar-check"></i> Asistencia</a></li>
            <li><a href="clases.php"><i class="fas fa-chalkboard-teacher"></i> Clases</a></li>
        </ul>
    </div>

    <!-- Contenido principal -->
    <div class="main-content">
        <header>
            <h1>Resultados de Búsqueda</h1>
        </header>

        <!-- Resultados de búsqueda -->
        <div class="search-results">
            <?php if (empty($usuarios)): ?>
                <p>No se encontraron usuarios que coincidan con la búsqueda.</p>
            <?php else: ?>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Telefono</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($usuarios as $usuario): ?>
                            <tr>
                                <td><?= htmlspecialchars($usuario['id_usuario']); ?></td>
                                <td><?= htmlspecialchars($usuario['Nombre']); ?></td>
                                <td><?= htmlspecialchars($usuario['Email']); ?></td>
                                <td><?= htmlspecialchars($usuario['Telefono']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>
