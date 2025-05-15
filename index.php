<?php
session_start();

require_once 'controllers/DishController.php';
require_once 'controllers/CategoryController.php';
require_once 'controllers/TableController.php';
require_once 'controllers/OrderController.php';


$controller = isset($_GET['controller']) ? $_GET['controller'] : 'dish';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';


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
       
        header('Location: index.php?controller=dish&action=index');
        exit();
}


if (method_exists($controller, $action)) {
   
    if (isset($_GET['id'])) {
        $controller->$action($_GET['id']);
    } else {
        $controller->$action();
    }
} else {
    
    header('Location: index.php?controller=dish&action=index');
    exit();
}