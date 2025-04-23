<?php
include '../backend/db.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    echo "ID inválido.";
    exit;
}

// Obtener receta existente
$stmt = $pdo->prepare("SELECT * FROM recetas WHERE id = ?");
$stmt->execute([$id]);
$receta = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$receta) {
    echo "Receta no encontrada.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $ingredientes = $_POST['ingredientes'];
    $pasos = $_POST['pasos'];
    $tiempo_preparacion = $_POST['tiempo_preparacion'];
    $imagen_actual = $receta['imagen'];

    // Manejar nueva imagen (si se subió)
    if ($_FILES['imagen']['name']) {
        // Eliminar imagen anterior si existe
        if ($imagen_actual && file_exists('imagenes/' . $imagen_actual)) {
            unlink('imagenes/' . $imagen_actual);
        }
        $imagen_nombre = uniqid() . '_' . basename($_FILES['imagen']['name']);
        move_uploaded_file($_FILES['imagen']['tmp_name'], 'imagenes/' . $imagen_nombre);
    } else {
        $imagen_nombre = $imagen_actual; // Mantener imagen anterior
    }

    $sql = "UPDATE recetas SET titulo=?, descripcion=?, ingredientes=?, pasos=?, tiempo_preparacion=?, imagen=? WHERE id=?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$titulo, $descripcion, $ingredientes, $pasos, $tiempo_preparacion, $imagen_nombre, $id]);

    header('Location: ../index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestor de Recetas</title>
    <link rel="stylesheet" href="/frontend/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>✏️Editar Receta✏️</h1>
        <form method="POST" enctype="multipart/form-data">
            <label>1️⃣Título:</label><br>
            <input type="text" name="titulo" value="<?php echo htmlspecialchars($receta['titulo']); ?>" required><br>
            <label>2️⃣Descripción:</label><br>
            <textarea name="descripcion" required><?php echo htmlspecialchars($receta['descripcion']); ?></textarea><br>
            <label>3️⃣Ingredientes:</label><br>
            <textarea name="ingredientes" required><?php echo htmlspecialchars($receta['ingredientes']); ?></textarea><br>
            <label>4️⃣Pasos:</label><br>
            <textarea name="pasos" required><?php echo htmlspecialchars($receta['pasos']); ?></textarea><br>
            <label>5️⃣Tiempo de preparación (minutos):</label><br>
            <input type="number" name="tiempo_preparacion" value="<?php echo $receta['tiempo_preparacion']; ?>" required><br>
            <label>6️⃣Imagen actual:</label><br>
            <?php if ($receta['imagen']): ?>
                <img src="imagenes/<?php echo $receta['imagen']; ?>" width="100"><br>
            <?php else: ?>
                <p>Sin imagen</p>
            <?php endif; ?>
            <label>Cambiar imagen:</label><br>
            <input type="file" name="imagen"><br><br>
            <button type="submit">Guardar cambios</button>
        </form>
        <br>
        <a href="../index.php">Volver al listado</a>
    </div>
</body>
</html>