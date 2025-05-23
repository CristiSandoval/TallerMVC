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
        <div class="form-container">
            <h1>Reporte de Órdenes Anuladas</h1>

            <?php if (isset($error)): ?>
                <div class="error-message">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <form action="index.php?controller=order&action=generateCancelledReport" method="POST">
                <div class="form-row">
                    <div class="form-group">
                        <label for="start_date">Fecha Inicial:</label>
                        <input type="date" id="start_date" name="start_date" required>
                    </div>
                    <div class="form-group">
                        <label for="end_date">Fecha Final:</label>
                        <input type="date" id="end_date" name="end_date" required>
                    </div>
                </div>

                <div class="button-group">
                    <button type="submit" class="btn btn-primary">Generar Reporte</button>
                    <a href="index.php?controller=home&action=index" class="btn btn-secondary">Volver al Menú Principal</a>
                    <a href="index.php?controller=order&action=index" class="btn btn-info">Volver a Órdenes</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('start_date').max = today;
        document.getElementById('end_date').max = today;

        const lastMonth = new Date();
        lastMonth.setMonth(lastMonth.getMonth() - 1);
        document.getElementById('start_date').value = lastMonth.toISOString().split('T')[0];
        document.getElementById('end_date').value = today;
    </script>
</body>
</html> 