<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Plato</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h1>Editar Plato</h1>

            <?php if (isset($error)): ?>
                <div class="error-message">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <form action="index.php?controller=dish&action=update" method="POST">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($dish['id']); ?>">
                
                <div class="form-group">
                    <label>Categoría:</label>
                    <input type="text" class="form-control" 
                           value="<?php echo isset($dish['category_name']) ? htmlspecialchars($dish['category_name']) : ''; ?>" 
                           disabled>
                </div>
                
                <div class="form-group">
                    <label for="description">Descripción:</label>
                    <input type="text" id="description" name="description" class="form-control"
                           value="<?php echo htmlspecialchars($dish['description']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="price">Precio:</label>
                    <input type="number" step="0.01" min="0.01" id="price" name="price" class="form-control"
                           value="<?php echo htmlspecialchars($dish['price']); ?>" required>
                </div>
                
                <div class="button-group">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <button type="button" class="btn btn-secondary" 
                            onclick="window.location='index.php?controller=dish&action=index'">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html> 