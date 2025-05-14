<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Platos</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container">
        <nav class="main-nav">
            <div class="nav-buttons">
                <a href="index.php?controller=dish&action=index" class="btn btn-primary">Platos</a>
                <a href="index.php?controller=category&action=index" class="btn btn-info">Categorías</a>
                <a href="index.php?controller=table&action=index" class="btn btn-warning">Mesas</a>
                <a href="index.php?controller=order&action=index" class="btn btn-success">Órdenes</a>
            </div>
        </nav>

        <?php if (isset($error)): ?>
            <div class="error-message">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <div class="header-actions">
            <h1>Lista de Platos</h1>
            <div class="action-buttons">
                <a href="index.php?controller=dish&action=create" class="btn btn-primary">Nuevo Plato</a>
            </div>
        </div>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Descripción</th>
                    <th>Categoría</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($dishes as $dish): ?>
                <tr>
                    <td><?php echo $dish['id']; ?></td>
                    <td><?php echo htmlspecialchars($dish['description']); ?></td>
                    <td><?php echo htmlspecialchars($dish['category_name']); ?></td>
                    <td>$<?php echo number_format($dish['price'], 2); ?></td>
                    <td>
                        <a href="index.php?controller=dish&action=edit&id=<?php echo $dish['id']; ?>" 
                           class="btn btn-warning btn-sm">Editar</a>
                        <a href="index.php?controller=dish&action=delete&id=<?php echo $dish['id']; ?>" 
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('¿Está seguro de que desea eliminar este plato?')">Eliminar</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html> 