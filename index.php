<?php
session_start();

// Incluir los controladores
require_once 'controllers/DishController.php';
require_once 'controllers/CategoryController.php';
require_once 'controllers/TableController.php';
require_once 'controllers/OrderController.php';

// Obtener el controlador y la acción de la URL
$controller = isset($_GET['controller']) ? $_GET['controller'] : 'dish';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

// Crear la instancia del controlador correspondiente
switch ($controller) {
    case 'dish':
        $controller = new DishController();
        break;
    case 'category':
        $controller = new CategoryController();
        break;
    case 'table':
        $controller = new TableController();
        break;
    case 'order':
        $controller = new OrderController();
        break;
    default:
        // Manejar error 404 o redirigir a una página por defecto
        header('Location: index.php?controller=dish&action=index');
        exit();
}

// Llamar a la acción correspondiente
if (method_exists($controller, $action)) {
    // Si la acción requiere un ID, pasarlo como parámetro
    if (isset($_GET['id'])) {
        $controller->$action($_GET['id']);
    } else {
        $controller->$action();
    }
} else {
    // Manejar error 404 o redirigir a una acción por defecto
    header('Location: index.php?controller=dish&action=index');
    exit();
}