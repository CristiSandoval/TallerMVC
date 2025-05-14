<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Órdenes</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Reporte de Órdenes</h1>
        <p class="report-period">Período: <?php echo date('d/m/Y', strtotime($_POST['start_date'])); ?> - 
                    <?php echo date('d/m/Y', strtotime($_POST['end_date'])); ?></p>

        <div class="summary-card">
            <div class="card">
                <h3>Total Recaudado</h3>
                <p class="amount-success">$<?php echo number_format($report['revenue'], 2); ?></p>
            </div>
        </div>

        <div class="report-content">
            <div class="orders-section">
                <h3>Órdenes del Período</h3>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Fecha</th>
                            <th>Mesa</th>
                            <th>Total</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($report['orders'] as $order): ?>
                        <tr>
                            <td><?php echo $order['id']; ?></td>
                            <td><?php echo date('d/m/Y H:i', strtotime($order['dateOrder'])); ?></td>
                            <td><?php echo htmlspecialchars($order['table_name']); ?></td>
                            <td>$<?php echo number_format($order['total'], 2); ?></td>
                            <td>
                                <a href="index.php?controller=order&action=view&id=<?php echo $order['id']; ?>" 
                                   class="btn btn-info btn-sm">Ver Detalles</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="top-dishes-section">
                <h3>Platos Más Vendidos</h3>
                <div class="dish-list">
                    <?php foreach ($report['topDishes'] as $dish): ?>
                    <div class="dish-item">
                        <h4><?php echo htmlspecialchars($dish['description']); ?></h4>
                        <p>Categoría: <?php echo htmlspecialchars($dish['category_name']); ?></p>
                        <p class="dish-details">
                            Cantidad vendida: <?php echo $dish['total_sold']; ?> unidades<br>
                            Precio unitario: $<?php echo number_format($dish['price'], 2); ?>
                        </p>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <div class="button-group">
            <button type="button" class="btn btn-primary" onclick="window.location='index.php?controller=order&action=reportForm'">Nuevo Reporte</button>
            <button type="button" class="btn btn-secondary" onclick="window.location='index.php?controller=order&action=index'">Volver al Listado</button>
        </div>
    </div>
</body>
</html> 