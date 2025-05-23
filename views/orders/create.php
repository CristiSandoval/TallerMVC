<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Nueva Orden</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/forms.css">
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h1>Crear Nueva Orden</h1>
            
            <?php if (isset($error)): ?>
                <div class="error-message">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <form action="index.php?controller=order&action=store" method="POST" id="orderForm">
                <div class="form-row">
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
                        
                            <button type="button" class="btn btn-danger remove-item hidden">
                                Eliminar
                            </button>
                        </div>
                    </div>
                </div>

                <div class="button-group">
                    <button type="button" id="addItem" class="btn btn-info">Agregar Plato</button>
                </div>

                <div class="total-section">
                    <h3>Total: $<span id="orderTotal">0.00</span></h3>
                </div>
                
                <div class="button-group">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <button type="button" class="btn btn-secondary" onclick="window.location='index.php?controller=order&action=index'">Cancelar</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const orderDetails = document.getElementById('orderDetails');
            const addItemButton = document.getElementById('addItem');
            const orderTotalSpan = document.getElementById('orderTotal');
            const firstItem = orderDetails.querySelector('.order-item');

            const now = new Date();
            now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
            document.getElementById('dateOrder').value = now.toISOString().slice(0, 16);

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

            orderDetails.addEventListener('change', function(e) {
                if (e.target.classList.contains('dish-select') || 
                    e.target.classList.contains('quantity-input')) {
                    calculateTotal();
                }
            });

            addItemButton.addEventListener('click', function() {
                const newItem = firstItem.cloneNode(true);
                newItem.querySelector('.dish-select').value = '';
                newItem.querySelector('.quantity-input').value = 1;
                newItem.querySelector('.remove-item').classList.remove('hidden');
                orderDetails.appendChild(newItem);
            });

            orderDetails.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-item')) {
                    e.target.closest('.order-item').remove();
                    calculateTotal();
                }
            });
        });
    </script>
</body>
</html> 