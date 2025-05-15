<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura - Orden #<?php echo $order['id']; ?></title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container">
        <div class="invoice-header">
            <div class="row">
                <div class="col-6">
                    <h1 class="invoice-title">Restaurante MVC</h1>
                    <p class="invoice-details">
                        Sistema de Control de Órdenes<br>
                        Teléfono: (123) 456-7890<br>
                        Email: info@restaurantemvc.com
                    </p>
                </div>
                <div class="col-6 text-end">
                    <h2>FACTURA</h2>
                    <p class="invoice-details">
                        Orden #<?php echo $order['id']; ?><br>
                        Fecha: <?php echo date('d/m/Y H:i', strtotime($order['dateOrder'])); ?><br>
                        Mesa: <?php echo htmlspecialchars($order['table_name']); ?>
                    </p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Plato</th>
                            <th>Categoría</th>
                            <th class="text-end">Precio Unitario</th>
                            <th class="text-end">Cantidad</th>
                            <th class="text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($order['items'] as $item): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['dish_name']); ?></td>
                            <td><?php echo htmlspecialchars($item['category_name']); ?></td>
                            <td class="text-end">$<?php echo number_format($item['price'], 2); ?></td>
                            <td class="text-end"><?php echo $item['quantity']; ?></td>
                            <td class="text-end">$<?php echo number_format($item['quantity'] * $item['price'], 2); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row total-section">
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Estado de la Orden</h5>
                        <?php if ($order['isCancelled']): ?>
                            <span class="badge badge-danger">ANULADA</span>
                        <?php else: ?>
                            <span class="badge badge-success">ACTIVA</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <table class="table">
                    <tr>
                        <th class="text-end">Total:</th>
                        <td class="text-end"><h3>$<?php echo number_format($order['total'], 2); ?></h3></td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="row mt-4 mb-4 no-print">
            <div class="col-12">
                <button onclick="window.print();" class="btn btn-primary">
                    Imprimir Factura
                </button>
                <a href="javascript:history.back()" class="btn btn-secondary">
                    Volver
                </a>
            </div>
        </div>
    </div>
</body>
</html> 