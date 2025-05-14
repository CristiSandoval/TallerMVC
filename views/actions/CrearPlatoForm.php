<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Plato</title>
    <link rel="stylesheet" href="../../css/styles.css">
</head>
<body>
    <h1>Registrar nuevo plato</h1>
    
    <form action="../../controllers/PlatoController.php" method="POST">
        <label>Descripción:</label>
        <input type="text" name="descripcion" required>

        <label>Categoría:</label>
        <select name="categoria_id" required>
            <option value="1">Bebidas</option>
            <option value="2">Platos principales</option>
            <option value="3">Postres</option>
        </select>

        <label>Precio unitario:</label>
        <input type="number" step="0.01" name="precio" required>

        <button type="submit">Guardar</button>
    </form>

    <?php if (isset($_GET['success'])): ?>
        <p>✅ Plato registrado correctamente.</p>
    <?php endif; ?>
</body>
</html>
