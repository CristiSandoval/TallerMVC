<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles de la Orden #<?php echo $order['id']; ?></title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Detalles de la Orden #<?php echo $order['id']; ?></h1>

        <div class="order-info">
            <p><strong>Fecha:</strong> <?php echo date('d/m/Y H:i', strtotime($order['dateOrder'])); ?></p>
            <p><strong>Mesa:</strong> <?php echo htmlspecialchars($order['table_name']); ?></p>
            <p><strong>Estado:</strong> 
                <?php if ($order['isCancelled']): ?>
                    <span class="badge badge-danger">Cancelada</span>
                <?php else: ?>
                    <span class="badge badge-success">Activa</span>
                <?php endif; ?>
            </p>
        </div>

        <div class="order-details">
            <h3>Platos Ordenados</h3>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Plato</th>
                        <th>Categoría</th>
                        <th>Precio Unitario</th>
                        <th>Cantidad</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($order['details'] as $detail): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($detail['dish_name']); ?></td>
                        <td><?php echo htmlspecialchars($detail['category_name']); ?></td>
                        <td>$<?php echo number_format($detail['price'], 2); ?></td>
                        <td><?php echo $detail['quantity']; ?></td>
                        <td>$<?php echo number_format($detail['price'] * $detail['quantity'], 2); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" class="text-end"><strong>Total:</strong></td>
                        <td><strong>$<?php echo number_format($order['total'], 2); ?></strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="button-group">
            <a href="index.php?controller=order&action=invoice&id=<?php echo $order['id']; ?>" 
               class="btn btn-info">Ver Factura</a>
            <?php if (!$order['isCancelled']): ?>
                <a href="index.php?controller=order&action=cancel&id=<?php echo $order['id']; ?>" 
                   class="btn btn-danger"
                   onclick="return confirm('¿Está seguro de que desea cancelar esta orden?')">Cancelar Orden</a>
            <?php endif; ?>
            <a href="index.php?controller=order&action=index" class="btn btn-secondary">Volver al Listado</a>
        </div>
    </div>
</body>
</html> 