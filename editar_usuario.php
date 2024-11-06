<?php
include 'db.php';

$id_usuario = $_GET['id'];
$sql = "SELECT * FROM Usuario WHERE id_usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$id_usuario]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];
    $id_rol = $_POST['id_roles'];

    $sql = "UPDATE Usuario SET Nombre = ?, Telefono = ?, Email = ?, id_Roles = ? WHERE id_usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$nombre, $telefono, $email, $id_rol, $id_usuario]);

    header('Location: usuarios.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario - Gestión de Membresías</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style/style.css">
    <style>
    .container-1 {
        max-width: 550px;
        

    }
    .card-1 {
        background-color: rgba(255, 255, 255, 0.3); 
        border-radius: 8px;
        border: 1px solid rgba(255, 255, 255, 0.18); 
        backdrop-filter: blur(10px); 
    }
    label{
        color: black;
    }
</style>
</head>
<body>
    <div class="sidebar" style="width: 290px;">
        <h2>Mi Sistema</h2>
        <ul>
            <li><a href="index.php">Inicio</a></li>
            <li><a href="crear_usuario.php">Agregar Usuario</a></li>
            <li><a href="usuarios.php">Lista de Usuarios</a></li>
            <li><a href="membresias.php">Membresías</a></li>
            <li><a href="pagos.php">Pagos</a></li>
            <li><a href="asistencia.php">Asistencias</a></li>
            <li><a href="clases.php">Clases</a></li>
        </ul>
    </div>

    <div class="main-content">
        <header>
            <h1>Editar Usuario</h1>
        </header>
        <div class="container-1 mt-4">
            <div class="card-1 p-4 shadow-sm">
                <form action="editar_usuario.php?id=<?= urlencode($id_usuario) ?>" method="POST">
                    <div class="row mb-3">
                        <div class="col-md-4 text-md-end">
                            <label for="nombre" class="col-form-label">Nombre:</label>
                        </div>
                        <div class="col-md-6">
                            <input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($usuario['Nombre']) ?>" class="form-control form-control-sm" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 text-md-end">
                            <label for="telefono" class="col-form-label">Teléfono:</label>
                        </div>
                        <div class="col-md-6">
                            <input type="text" id="telefono" name="telefono" value="<?= htmlspecialchars($usuario['Telefono']) ?>" class="form-control form-control-sm" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 text-md-end">
                            <label for="email" class="col-form-label">Email:</label>
                        </div>
                        <div class="col-md-6">
                            <input type="email" id="email" name="email" value="<?= htmlspecialchars($usuario['Email']) ?>" class="form-control form-control-sm" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 text-md-end">
                            <label for="id_roles" class="col-form-label">Rol:</label>
                        </div>
                        <div class="col-md-6">
                            <select id="id_roles" name="id_roles" class="form-select form-select-sm">
                                <option value="1" <?= $usuario['id_Roles'] == 1 ? 'selected' : '' ?>>Admin</option>
                                <option value="2" <?= $usuario['id_Roles'] == 2 ? 'selected' : '' ?>>Instructor</option>
                                <option value="3" <?= $usuario['id_Roles'] == 3 ? 'selected' : '' ?>>Cliente</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 text-center">
                            <input type="submit" value="Guardar Cambios" class="btn btn-primary">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
