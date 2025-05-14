<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Mesa</title>
</head>
<body>
    <h1>Editar Mesa</h1>
    <br>
    
    <?php if (isset($error)): ?>
        <div style="color: red; margin-bottom: 10px;">
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <form action="index.php?controller=table&action=update" method="POST">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($table['id']); ?>">
        
        <div>
            <label for="name">Nombre:</label>
            <input type="text" id="name" name="name" 
                   value="<?php echo htmlspecialchars($table['name']); ?>" required>
        </div>
        
        <div>
            <button type="submit">Guardar</button>
            <button type="button" onclick="window.location='index.php?controller=table&action=index'">Cancelar</button>
        </div>
    </form>
</body>
</html> 