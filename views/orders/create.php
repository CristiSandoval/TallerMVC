<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Nueva Orden</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <h1>Crear Nueva Orden</h1>
    <br>
    
    <?php if (isset($error)): ?>
        <div class="error-message">
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <form action="index.php?controller=order&action=store" method="POST" id="orderForm">
        <div class="form-group">
            <label for="dateOrder">Fecha y Hora:</label>
            <input type="datetime-local" id="dateOrder" name="dateOrder" required>
        </div>
        
        <div class="form-group">
            <label for="idTable">Mesa:</label>
            <select id="idTable" name="idTable" required>
                <option value="">Seleccione una mesa</option>
                <?php foreach ($tables as $table): ?>
                    <option value="<?php echo $table['id']; ?>">
                        <?php echo htmlspecialchars($table['name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div id="orderDetails">
            <h3>Detalles de la Orden</h3>
            <div class="order-item">
                <div class="form-group">
                    <label>Plato:</label>
                    <select class="dish-select" name="dishes[]" required>
                        <option value="">Seleccione un plato</option>
                        <?php foreach ($dishes as $dish): ?>
                            <option value="<?php echo $dish['id']; ?>" 
                                    data-price="<?php echo $dish['price']; ?>">
                                <?php echo htmlspecialchars($dish['description']); ?> 
                                - $<?php echo number_format($dish['price'], 2); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                
                    <label>Cantidad:</label>
                    <input type="number" class="quantity-input" 
                           name="quantities[]" min="1" value="1" required>
                
                    <button type="button" class="remove-item hidden">
                        Eliminar
                    </button>
                </div>
            </div>
        </div>

        <button type="button" id="addItem">Agregar Plato</button>

        <div class="total-section">
            <h3>Total: $<span id="orderTotal">0.00</span></h3>
        </div>
        
        <div class="button-group">
            <button type="submit">Guardar</button>
            <button type="button" onclick="window.location='index.php?controller=order&action=index'">Cancelar</button>
        </div>
    </form>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const orderDetails = document.getElementById('orderDetails');
            const addItemButton = document.getElementById('addItem');
            const orderTotalSpan = document.getElementById('orderTotal');
            const firstItem = orderDetails.querySelector('.order-item');

            // Establecer la fecha actual por defecto
            const now = new Date();
            now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
            document.getElementById('dateOrder').value = now.toISOString().slice(0, 16);

            // Función para calcular el total
            function calculateTotal() {
                let total = 0;
                const items = orderDetails.querySelectorAll('.order-item');
                items.forEach(item => {
                    const select = item.querySelector('.dish-select');
                    const quantity = item.querySelector('.quantity-input').value;
                    if (select.value) {
                        const price = select.options[select.selectedIndex].dataset.price;
                        total += price * quantity;
                    }
                });
                orderTotalSpan.textContent = total.toFixed(2);
            }

            // Agregar evento para calcular total al cambiar cantidad o plato
            orderDetails.addEventListener('change', function(e) {
                if (e.target.classList.contains('dish-select') || 
                    e.target.classList.contains('quantity-input')) {
                    calculateTotal();
                }
            });

            // Función para agregar nuevo item
            addItemButton.addEventListener('click', function() {
                const newItem = firstItem.cloneNode(true);
                newItem.querySelector('.dish-select').value = '';
                newItem.querySelector('.quantity-input').value = 1;
                newItem.querySelector('.remove-item').classList.remove('hidden');
                orderDetails.appendChild(newItem);
            });

            // Mostrar botón eliminar en items adicionales
            document.querySelectorAll('.order-item').forEach((item, index) => {
                if (index > 0) {
                    item.querySelector('.remove-item').classList.remove('hidden');
                }
            });

            // Eliminar items
            orderDetails.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-item')) {
                    if (orderDetails.querySelectorAll('.order-item').length > 1) {
                        e.target.closest('.order-item').remove();
                        calculateTotal();
                    }
                }
            });
        });
    </script>
</body>
</html> 