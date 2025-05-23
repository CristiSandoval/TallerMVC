<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurante MVC - Sistema de Control</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/menu.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <div class="menu-container">
        <div class="welcome-section">
            <h1>Bienvenido al Sistema de Control de Restaurante</h1>
            <p>Seleccione una opción para comenzar</p>
        </div>

        <div class="menu-grid">
            <div class="menu-item">
                <i class="fas fa-utensils"></i>
                <h3>Gestión de Platos</h3>
                <p>Administre el menú del restaurante, agregue, modifique o elimine platos.</p>
                <a href="index.php?controller=dish&action=index" class="btn">Acceder</a>
            </div>

            <div class="menu-item">
                <i class="fas fa-list"></i>
                <h3>Categorías</h3>
                <p>Gestione las categorías de los platos del menú.</p>
                <a href="index.php?controller=category&action=index" class="btn">Acceder</a>
            </div>

            <div class="menu-item">
                <i class="fas fa-chair"></i>
                <h3>Mesas</h3>
                <p>Administre las mesas del restaurante.</p>
                <a href="index.php?controller=table&action=index" class="btn">Acceder</a>
            </div>

            <div class="menu-item">
                <i class="fas fa-receipt"></i>
                <h3>Órdenes</h3>
                <p>Gestione las órdenes, vea reportes y facturas.</p>
                <a href="index.php?controller=order&action=index" class="btn">Acceder</a>
            </div>

            <div class="menu-item">
                <i class="fas fa-chart-bar"></i>
                <h3>Reporte de Ventas</h3>
                <p>Vea el reporte de ventas por período.</p>
                <a href="index.php?controller=order&action=reportForm" class="btn">Acceder</a>
            </div>

            <div class="menu-item">
                <i class="fas fa-ban"></i>
                <h3>Órdenes Canceladas</h3>
                <p>Consulte el reporte de órdenes canceladas.</p>
                <a href="index.php?controller=order&action=cancelledReportForm" class="btn">Acceder</a>
            </div>
        </div>
    </div>
</body>
</html> 