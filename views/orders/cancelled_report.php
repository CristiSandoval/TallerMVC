<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Órdenes Anuladas</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Reporte de Órdenes Anuladas</h1>
        <p class="report-period">Período: <?php echo date('d/m/Y', strtotime($_POST['start_date'])); ?> - 
                    <?php echo date('d/m/Y', strtotime($_POST['end_date'])); ?></p>

        <div class="row">
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Total de Órdenes Anuladas</h3>
                        <h4 class="text-danger">$<?php echo number_format($report['total'], 2); ?></h4>
                    </div>
                </div>
            </div>
        </div>

        <?php if (!empty($report['orders'])): ?>
            <div class="card mt-4">
                <div class="card-body">
                    <h3 class="card-title">Detalle de Órdenes Anuladas</h3>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID Orden</th>
                                <th>Fecha</th>
                                <th>Mesa</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($report['orders'] as $order): ?>
                            <tr>
                                <td><?php echo $order['id']; ?></td>
                                <td><?php echo date('d/m/Y H:i', strtotime($order['dateOrder'])); ?></td>
                                <td><?php echo htmlspecialchars($order['table_name']); ?></td>
                                <td>$<?php echo number_format($order['total'], 2); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endif; ?>

        <div class="button-group mt-4">
            <a href="index.php?controller=order&action=cancelledReportForm" class="btn btn-primary">Nuevo Reporte</a>
            <a href="index.php?controller=order&action=index" class="btn btn-secondary">Volver al Listado</a>
        </div>
    </div>
</body>
</html> 