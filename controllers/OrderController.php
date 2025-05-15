<?php
require_once 'models/entities/Order.php';
require_once 'models/entities/Table.php';
require_once 'models/entities/Dish.php';
require_once 'models/drivers/conexDB.php';

use App\models\drivers\ConexDB;
use App\models\entities\Order;
use App\models\entities\Table;
use App\models\entities\Dish;

class OrderController {
    private $orderModel;
    private $tableModel;
    private $dishModel;

    public function __construct() {
        $database = new ConexDB();
        $db = $database->getConnection();
        $this->orderModel = new Order($db);
        $this->tableModel = new Table($db);
        $this->dishModel = new Dish($db);
    }

   
    public function index() {
        $orders = $this->orderModel->getAll();
        $error = isset($_SESSION['error']) ? $_SESSION['error'] : null;
        unset($_SESSION['error']);
        require_once 'views/orders/index.php';
    }

    
    public function create() {
        $tables = $this->tableModel->getAll();
        $dishes = $this->dishModel->getAll();
        require_once 'views/orders/create.php';
    }

    
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $orderDetails = [];
            $total = 0;

          
            foreach ($_POST['dishes'] as $index => $dishId) {
                if (!empty($_POST['quantities'][$index]) && $_POST['quantities'][$index] > 0) {
                    $dish = $this->dishModel->getById($dishId);
                    $quantity = $_POST['quantities'][$index];
                    $price = $dish['price'];
                    
                    $orderDetails[] = [
                        'idDish' => $dishId,
                        'quantity' => $quantity,
                        'price' => $price
                    ];
                    
                    $total += $quantity * $price;
                }
            }

            if (empty($orderDetails)) {
                $_SESSION['error'] = "Debe agregar al menos un plato a la orden";
                header('Location: index.php?controller=order&action=create');
                return;
            }

            
            $this->orderModel->setDateOrder($_POST['dateOrder']);
            $this->orderModel->setIdTable($_POST['idTable']);
            $this->orderModel->setTotal($total);
            $this->orderModel->setIsCancelled(0);
            $this->orderModel->setOrderDetails($orderDetails);

            if ($this->orderModel->create()) {
                header('Location: index.php?controller=order&action=index');
            } else {
                $_SESSION['error'] = "Error al crear la orden";
                header('Location: index.php?controller=order&action=create');
            }
        }
    }

    
    public function view($id) {
        $order = $this->orderModel->getById($id);
        if (!$order) {
            header('Location: index.php?controller=order&action=index');
            return;
        }
        require_once 'views/orders/view.php';
    }

    public function cancel($id) {
        if ($this->orderModel->cancel($id)) {
            header('Location: index.php?controller=order&action=index');
        } else {
            $_SESSION['error'] = "Error al cancelar la orden";
            header('Location: index.php?controller=order&action=index');
        }
    }

   
    public function reportForm() {
        require_once 'views/orders/report_form.php';
    }

    
    public function generateReport() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $startDate = $_POST['start_date'] . ' 00:00:00';
            $endDate = $_POST['end_date'] . ' 23:59:59';

           
            if (strtotime($endDate) < strtotime($startDate)) {
                $_SESSION['error'] = "La fecha final debe ser mayor o igual a la fecha inicial";
                header('Location: index.php?controller=order&action=reportForm');
                return;
            }

            $report = $this->orderModel->getOrderReport($startDate, $endDate);
            require_once 'views/orders/report.php';
        } else {
            header('Location: index.php?controller=order&action=reportForm');
        }
    }

    public function cancelledReportForm() {
        require_once 'views/orders/cancelled_report_form.php';
    }

  
    public function generateCancelledReport() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $startDate = $_POST['start_date'] . ' 00:00:00';
            $endDate = $_POST['end_date'] . ' 23:59:59';

            
            if (strtotime($endDate) < strtotime($startDate)) {
                $_SESSION['error'] = "La fecha final debe ser mayor o igual a la fecha inicial";
                header('Location: index.php?controller=order&action=cancelledReportForm');
                return;
            }

            $report = $this->orderModel->getCancelledOrderReport($startDate, $endDate);
            require_once 'views/orders/cancelled_report.php';
        } else {
            header('Location: index.php?controller=order&action=cancelledReportForm');
        }
    }

    
    public function invoice($id) {
        $order = $this->orderModel->getOrderWithDetails($id);
        if (!$order) {
            header('Location: index.php?controller=order&action=index');
            return;
        }
        require_once 'views/orders/invoice.php';
    }
} 