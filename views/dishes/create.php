<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Nuevo Plato</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/forms.css">
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h1>Crear Nuevo Plato</h1>
            
            <?php if (isset($error)): ?>
                <div class="error-message">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <form action="index.php?controller=dish&action=store" method="POST">
                <div class="form-group">
                    <label for="description">Descripción:</label>
                    <input type="text" id="description" name="description" required>
                </div>
                
                <div class="form-group">
                    <label for="idCategory">Categoría:</label>
                    <select id="idCategory" name="idCategory" required>
                        <option value="">Seleccione una categoría</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?php echo $category['id']; ?>">
                                <?php echo htmlspecialchars($category['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="price">Precio:</label>
                    <input type="number" step="0.01" min="0.01" id="price" name="price" required>
                </div>
                
                <div class="button-group">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <button type="button" class="btn btn-secondary" onclick="window.location='index.php?controller=dish&action=index'">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html> 