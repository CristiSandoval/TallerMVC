<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Nueva Categoría</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <h1>Crear Nueva Categoría</h1>
    <br>
    
    <?php if (isset($error)): ?>
        <div class="error-message">
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <form action="index.php?controller=category&action=store" method="POST">
        <div class="form-group">
            <label for="name">Nombre:</label>
            <input type="text" id="name" name="name" required>
        </div>
        
        <div class="button-group">
            <button type="submit">Guardar</button>
            <button type="button" onclick="window.location='index.php?controller=category&action=index'">Cancelar</button>
        </div>
    </form>
</body>
</html> 