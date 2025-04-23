<?php
include '../backend/db.php';

$id = $_GET['id'] ?? null;
if ($id) {
    // Eliminar imagen asociada primero
    $stmt = $pdo->prepare("SELECT imagen FROM recetas WHERE id = ?");
    $stmt->execute([$id]);
    $receta = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($receta && $receta['imagen']) {
        $ruta_imagen = 'imagenes/' . $receta['imagen'];
        if (file_exists($ruta_imagen)) {
            unlink($ruta_imagen); // Elimina la imagen del servidor
        }
    }
    // Eliminar receta de la base de datos
    $stmt = $pdo->prepare("DELETE FROM recetas WHERE id = ?");
    $stmt->execute([$id]);
}
header('Location: https://recetasapp.codearlo.com');
exit;
?>