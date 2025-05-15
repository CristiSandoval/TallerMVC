<?php
require_once 'models/entities/Table.php';
require_once 'models/drivers/conexDB.php';

use App\models\drivers\ConexDB;
use App\models\entities\Table;

class TableController {
    private $tableModel;

    public function __construct() {
        $database = new ConexDB();
        $db = $database->getConnection();
        $this->tableModel = new Table($db);
    }

 
    public function index() {
        $tables = $this->tableModel->getAll();
        $error = isset($_SESSION['error']) ? $_SESSION['error'] : null;
        unset($_SESSION['error']);
        require_once 'views/tables/index.php';
    }

   
    public function create() {
        require_once 'views/tables/create.php';
    }

 
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->tableModel->setName($_POST['name']);

            if ($this->tableModel->create()) {
                header('Location: index.php?controller=table&action=index');
            } else {
                $error = "Error al crear la mesa";
                require_once 'views/tables/create.php';
            }
        }
    }

    
    public function edit($id) {
        $table = $this->tableModel->getById($id);
        if (!$table) {
            header('Location: index.php?controller=table&action=index');
            return;
        }
        require_once 'views/tables/edit.php';
    }

   
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->tableModel->setId($_POST['id']);
            $this->tableModel->setName($_POST['name']);

            if ($this->tableModel->update()) {
                header('Location: index.php?controller=table&action=index');
            } else {
                $error = "Error al actualizar la mesa";
                $table = $this->tableModel->getById($_POST['id']);
                require_once 'views/tables/edit.php';
            }
        }
    }

    
    public function delete($id) {
        if (!$this->tableModel->canBeDeleted($id)) {
            $_SESSION['error'] = "No se puede eliminar la mesa porque tiene órdenes asociadas";
            header('Location: index.php?controller=table&action=index');
            return;
        }

        if ($this->tableModel->delete($id)) {
            header('Location: index.php?controller=table&action=index');
        } else {
            $_SESSION['error'] = "Error al eliminar la mesa";
            header('Location: index.php?controller=table&action=index');
        }
    }
} 