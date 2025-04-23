<?php
include '../backend/db.php';

$busqueda = $_GET['buscar'] ?? '';
if ($busqueda) {
    $stmt = $pdo->prepare("SELECT * FROM recetas WHERE titulo LIKE ?");
    $stmt->execute(["%$busqueda%"]);
} else {
    $stmt = $pdo->query("SELECT * FROM recetas");
}
$recetas = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
        <h1>💯Gestor de Recetas💯</h1>
        <form method="GET" action="index.php">
            <input type="text" name="buscar" placeholder="Buscar receta por título" value="<?php echo htmlspecialchars($busqueda); ?>">
            <button type="submit">🔎</button>
        </form>
        <br>
        <a href="https://recetasapp.codearlo.com/agregar">✔️Agregar nueva receta</a>
        <br><br>
        <div class="grid">
            <?php foreach ($recetas as $receta): ?>
                <div class="card">
                    <?php if ($receta['imagen']): ?>
                        <img src="imagenes/<?php echo htmlspecialchars($receta['imagen']); ?>" alt="Imagen de receta">
                    <?php else: ?>
                        <div class="no-image">Sin imagen</div>
                    <?php endif; ?>
                    <h2><?php echo htmlspecialchars($receta['titulo']); ?></h2>
                    <p><strong>Descripción:</strong> <?php echo htmlspecialchars($receta['descripcion']); ?></p>
                    <p><strong>Ingredientes:</strong> <?php echo htmlspecialchars($receta['ingredientes']); ?></p>
                    <p><strong>Pasos:</strong> <?php echo htmlspecialchars($receta['pasos']); ?></p>
                    <p><strong>Tiempo:</strong> <?php echo $receta['tiempo_preparacion']; ?> min</p>
                    <div class="acciones">
                        <a href="https://recetasapp.codearlo.com/editar?id=<?php echo $receta['id']; ?>" class="boton">✏️ Editar</a>
                        <a href="https://recetasapp.codearlo.com/eliminar?id=<?php echo $receta['id']; ?>" class="boton eliminar" onclick="return confirm('¿Eliminar esta receta?');">🗑️ Eliminar</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>