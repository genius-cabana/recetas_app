<?php
include '../backend/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $ingredientes = $_POST['ingredientes'];
    $pasos = $_POST['pasos'];
    $tiempo_preparacion = $_POST['tiempo_preparacion'];

    // Manejar imagen
    $imagen_nombre = null;
    if ($_FILES['imagen']['name']) {
        $imagen_nombre = uniqid() . '_' . basename($_FILES['imagen']['name']);
        $ruta_imagen = 'imagenes/' . $imagen_nombre;

        // Crear la carpeta "imagenes" si no existe
        if (!is_dir('imagenes')) {
            mkdir('imagenes', 0755, true);
        }

        move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta_imagen);
    }

    $sql = "INSERT INTO recetas (titulo, descripcion, ingredientes, pasos, tiempo_preparacion, imagen)
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$titulo, $descripcion, $ingredientes, $pasos, $tiempo_preparacion, $imagen_nombre]);

    // Redirigir a index.php después de agregar la receta
    header('Location: https://recetasapp.codearlo.com');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestor de Recetas</title>
    <link rel="stylesheet" href="../frontend/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>➕Agregar Nueva Receta➕</h1>
        <!-- Formulario para agregar receta -->
        <form action="" method="POST" enctype="multipart/form-data">
            <label>1️⃣Título:</label><br>
            <input type="text" name="titulo" required><br>
            <label>2️⃣Descripción:</label><br>
            <textarea name="descripcion" required></textarea><br>
            <label>3️⃣Ingredientes:</label><br>
            <textarea name="ingredientes" required></textarea><br>
            <label>4️⃣Pasos:</label><br>
            <textarea name="pasos" required></textarea><br>
            <label>5️⃣Tiempo de preparación (minutos):</label><br>
            <input type="number" name="tiempo_preparacion" required><br>
            <label>6️⃣Imagen:</label><br>
            <input type="file" name="imagen"><br><br>
            <button type="submit">Guardar Receta</button>
        </form>
        <br>
        <a href="https://recetasapp.codearlo.com">Volver al listado</a>
    </div>
</body>
</html>