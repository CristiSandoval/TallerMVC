<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Mesas</title>
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
            <h1>Lista de Mesas</h1>
            <div class="button-group">
                <a href="index.php?controller=table&action=create" class="btn btn-primary">Nueva Mesa</a>
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
                <?php foreach ($tables as $table): ?>
                <tr>
                    <td><?php echo $table['id']; ?></td>
                    <td><?php echo htmlspecialchars($table['name']); ?></td>
                    <td>
                        <a href="index.php?controller=table&action=edit&id=<?php echo $table['id']; ?>" 
                           class="btn btn-warning btn-sm">Editar</a>
                        <a href="index.php?controller=table&action=delete&id=<?php echo $table['id']; ?>" 
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('¿Está seguro de que desea eliminar esta mesa?')">Eliminar</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html> 