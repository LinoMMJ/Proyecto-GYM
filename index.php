<?php
include 'db.php';

// Obtener el conteo de usuarios
$sql_usuarios = "SELECT COUNT(*) as total FROM Usuario";
$stmt_usuarios = $conn->prepare($sql_usuarios);
$stmt_usuarios->execute();
$total_usuarios = $stmt_usuarios->fetch(PDO::FETCH_ASSOC)['total'];

// Obtener el conteo de membresías activas
$sql_membresias_activas = "SELECT COUNT(*) as total FROM membresia WHERE estado = 'Activo' AND fecha_fin >= CURDATE()";
$stmt_membresias_activas = $stmt_membresias_activas->fetch(PDO::FETCH_ASSOC)['total'];

// Obtener el conteo de clases
$sql_clases = "SELECT COUNT(*) as total FROM Clase";
$stmt_clases = $conn->prepare($sql_clases);
$stmt_clases->execute();
$total_clases = $stmt_clases->fetch(PDO::FETCH_ASSOC)['total'];

// Obtener el conteo de asistencias
$sql_asistencias = "SELECT COUNT(*) as total FROM Asistencia";
$stmt_asistencias = $conn->prepare($sql_asistencias);
$stmt_asistencias->execute();
$total_asistencias = $stmt_asistencias->fetch(PDO::FETCH_ASSOC)['total'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Gestión de Membresías</title>
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script>
       
        const inactividadLimite = 1 * 60 * 1000; // 1 minuto

        let tiempoInactividad;

        function resetearTiempoInactividad() {
            clearTimeout(tiempoInactividad);
            tiempoInactividad = setTimeout(() => {
                alert("Has sido desconectado por inactividad.");
                window.location.href = "login.php"; // Redirecciona a la página de login
            }, inactividadLimite);
        }

        // Detecta actividad del usuario (clics, movimientos de mouse y pulsación de teclas)
        document.onload = resetearTiempoInactividad;
        document.onmousemove = resetearTiempoInactividad;
        document.onmousedown = resetearTiempoInactividad;
        document.ontouchstart = resetearTiempoInactividad;
        document.onclick = resetearTiempoInactividad;
        document.onkeypress = resetearTiempoInactividad;
    </script>
</head>
<body>
    <!-- Barra lateral -->
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

    <!-- Contenido principal -->
    <div class="main-content">
        <header>
            <h1>Panel de Gestión de Membresías</h1>
        </header>

        <!-- Tarjetas de estadísticas -->
        <div class="dashboard">
            <div class="card">
                <h2>Usuarios</h2>
                <p><?= $total_usuarios; ?></p>
            </div>
            <div class="card">
                <h2>Membresías Activas</h2>
                <p><?= $total_membresias_activas; ?></p>
            </div>
            <div class="card">
                <h2>Clases</h2>
                <p><?= $total_clases; ?></p>
            </div>
            <div class="card">
                <h2>Asistencias</h2>
                <p><?= $total_asistencias; ?></p>
            </div>
        </div>

        <!-- Búsqueda de usuarios -->
        <div class="search-bar">
            <form action="buscar.php" method="get">
                <input type="text" name="query" placeholder="Buscar usuarios...">
                <button type="submit"><i class="fas fa-search"></i></button>
            </form>
        </div>

        <!-- Filtros de membresías -->
        <div class="filters">
            <form action="membresias.php" method="get">
                <label for="estado">Filtrar por estado:</label>
                <select name="estado" id="estado">
                    <option value="todas">Todas</option>
                    <option value="activas">Activas</option>
                    <option value="vencidas">Vencidas</option>
                </select>
                <button type="submit">Filtrar</button>
            </form>
        </div>

    </div>
</body>
</html>
