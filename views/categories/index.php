<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Categorías</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container">
        <?php if (isset($error)): ?>
            <div class="error-message">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <div class="header-actions">
            <h1>Lista de Categorías</h1>
            <div class="button-group">
                <a href="index.php?controller=category&action=create" class="btn btn-primary">Nueva Categoría</a>
                <a href="index.php?controller=home&action=index" class="btn btn-secondary">Volver al Menú Principal</a>
            </div>
        </div>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $category): ?>
                <tr>
                    <td><?php echo $category['id']; ?></td>
                    <td><?php echo htmlspecialchars($category['name']); ?></td>
                    <td>
                        <a href="index.php?controller=category&action=edit&id=<?php echo $category['id']; ?>" 
                           class="btn btn-warning btn-sm">Editar</a>
                        <a href="index.php?controller=category&action=delete&id=<?php echo $category['id']; ?>" 
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('¿Está seguro de que desea eliminar esta categoría?')">Eliminar</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html> 