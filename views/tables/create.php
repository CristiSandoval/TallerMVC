<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Nueva Mesa</title>
</head>
<body>
    <h1>Crear Nueva Mesa</h1>
    <br>
    
    <?php if (isset($error)): ?>
        <div style="color: red; margin-bottom: 10px;">
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <form action="index.php?controller=table&action=store" method="POST">
        <div>
            <label for="name">Nombre:</label>
            <input type="text" id="name" name="name" required>
        </div>
        
        <div>
            <button type="submit">Guardar</button>
            <button type="button" onclick="window.location='index.php?controller=table&action=index'">Cancelar</button>
        </div>
    </form>
</body>
</html> 