<?php
// Código PHP para crear un usuario (procesar datos y agregar a la base de datos)
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Crear Usuario</title>
</head>
<body>
    <!-- Barra lateral y contenido principal -->
    <div class="sidebar" style="width: 290px;">
        <h2>Mi Sistema</h2>
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
        <header>
            <h1>Crear Usuario</h1>
        </header>

        <!-- Formulario para crear usuario -->
        <div class="form-container">
            <form action="procesar_crear_usuario.php" method="post">
                <label for="nombre" class="form-label">Nombre*</label>
                <input type="text" id="nombre" name="nombre"  class="form-control">

                <label for="email" class="form-label">Email*</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="name@example.com">

                <label for="telefono" class="form-label">Teléfono*</label>
                <input type="text" id="telefono" name="telefono" class="form-control">

                <label for="password" class="form-label">Contraseña*</label>
                <input type="password" id="password" name="password" class="form-control">

                <button type="submit">Crear Usuario</button>
            </form>
        </div>
    </div>
</body>
</html>
