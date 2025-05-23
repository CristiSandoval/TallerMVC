<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Órdenes</title>
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
            <h1>Lista de Órdenes</h1>
            <div class="button-group">
                <a href="index.php?controller=order&action=reportForm" class="btn btn-info">Reporte de Órdenes</a>
                <a href="index.php?controller=order&action=cancelledReportForm" class="btn btn-warning">Reporte de Anuladas</a>
                <a href="index.php?controller=order&action=create" class="btn btn-primary">Nueva Orden</a>
                <a href="index.php?controller=home&action=index" class="btn btn-secondary">Volver al Menú Principal</a>
            </div>
        </div>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Fecha</th>
                    <th>Mesa</th>
                    <th>Total</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?php echo $order['id']; ?></td>
                    <td><?php echo date('d/m/Y H:i', strtotime($order['dateOrder'])); ?></td>
                    <td><?php echo htmlspecialchars($order['table_name']); ?></td>
                    <td>$<?php echo number_format($order['total'], 2); ?></td>
                    <td>
                        <?php if ($order['isCancelled']): ?>
                            <span class="badge badge-danger">Cancelada</span>
                        <?php else: ?>
                            <span class="badge badge-success">Activa</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="index.php?controller=order&action=view&id=<?php echo $order['id']; ?>" 
                           class="btn btn-info btn-sm">Ver Detalles</a>
                        <a href="index.php?controller=order&action=invoice&id=<?php echo $order['id']; ?>" 
                           class="btn btn-info btn-sm">Ver Factura</a>
                        <?php if (!$order['isCancelled']): ?>
                            <a href="index.php?controller=order&action=cancel&id=<?php echo $order['id']; ?>" 
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('¿Está seguro de que desea cancelar esta orden?')">Cancelar</a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="button-group">
            <a href="index.php?controller=home&action=index" class="btn btn-secondary">Volver al Menú Principal</a>
        </div>
    </div>
</body>
</html> 