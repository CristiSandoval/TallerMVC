<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Nuevo Plato</title>
</head>
<body>
    <h1>Crear Nuevo Plato</h1>
    <br>
    
    <form action="index.php?controller=dish&action=store" method="POST">
        <div>
            <label for="description">Descripción:</label>
            <input type="text" id="description" name="description" required>
        </div>
        
        <div>
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
        
        <div>
            <label for="price">Precio:</label>
            <input type="number" step="0.01" min="0.01" id="price" name="price" required>
        </div>
        
        <div>
            <button type="submit">Guardar</button>
            <button type="button" onclick="window.location='index.php?controller=dish&action=index'">Cancelar</button>
        </div>
    </form>
</body>
</html> 