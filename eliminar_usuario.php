<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Mostrar ventana de confirmación
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Confirmar Eliminación</title>
        <script>
            function confirmarEliminacion() {
                var confirmacion = confirm("¿Estás seguro de que deseas eliminar este usuario?");
                if (confirmacion) {
                    // Redirigir a la misma página para proceder con la eliminación
                    window.location.href = "eliminar_usuario.php?id=<?php echo $id; ?>&confirmar=1";
                } else {
                    // Redirigir a la lista de usuarios si se cancela
                    window.location.href = "usuarios.php";
                }
            }
        </script>
    </head>
    <body onload="confirmarEliminacion();">
    </body>
    </html>
    <?php
    exit; // Asegurarse de detener la ejecución
}

// Si se confirma la eliminación
if (isset($_GET['confirmar']) && $_GET['confirmar'] == '1') {
    // Proceder a eliminar el usuario
    $sql = "DELETE FROM Usuario WHERE id_usuario = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    
    if ($stmt->execute()) {
        // Redireccionar después de eliminar
        header('Location: usuarios.php?eliminado=success');
        exit;
    } else {
        // Redireccionar con error
        header('Location: usuarios.php?eliminado=error');
        exit;
    }
}
?>
