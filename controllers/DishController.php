<?php
require_once 'models/entities/Dish.php';
require_once 'models/entities/Category.php';
require_once 'models/drivers/conexDB.php';

use App\models\drivers\ConexDB;
use App\models\entities\Dish;
use App\models\entities\Category;

class DishController {
    private $dishModel;
    private $categoryModel;

    public function __construct() {
        $database = new ConexDB();
        $db = $database->getConnection();
        $this->dishModel = new Dish($db);
        $this->categoryModel = new Category($db);
    }


    public function create() {
        $categories = $this->categoryModel->getAll();
        require_once 'views/dishes/create.php';
    }


    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                if ($_POST['price'] <= 0) {
                    throw new Exception("El precio debe ser mayor que 0");
                }
                
                $this->dishModel->setDescription($_POST['description']);
                $this->dishModel->setIdCategory($_POST['idCategory']);
                $this->dishModel->setPrice($_POST['price']);

                if ($this->dishModel->create()) {
                    header('Location: index.php?controller=dish&action=index');
                    return;
                }
                throw new Exception("Error al crear el plato");
            } catch (Exception $e) {
                $error = $e->getMessage();
                $categories = $this->categoryModel->getAll();
                require_once 'views/dishes/create.php';
            }
        }
    }

   
    public function index() {
        $dishes = $this->dishModel->getAll();
        
        $error = isset($_SESSION['error']) ? $_SESSION['error'] : null;
       
        unset($_SESSION['error']);
        require_once 'views/dishes/index.php';
    }

    
    public function edit($id) {
        $dish = $this->dishModel->getById($id);
        if (!$dish) {
            header('Location: index.php?controller=dish&action=index');
            return;
        }
        require_once 'views/dishes/edit.php';
    }

    
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                if ($_POST['price'] <= 0) {
                    throw new Exception("El precio debe ser mayor que 0");
                }

                $this->dishModel->setId($_POST['id']);
                $this->dishModel->setDescription($_POST['description']);
                $this->dishModel->setPrice($_POST['price']);

                if ($this->dishModel->update()) {
                    header('Location: index.php?controller=dish&action=index');
                    return;
                }
                throw new Exception("Error al actualizar el plato");
            } catch (Exception $e) {
                $error = $e->getMessage();
                $dish = $this->dishModel->getById($_POST['id']);
                require_once 'views/dishes/edit.php';
            }
        }
    }

  
    public function delete($id) {
        if (!$this->dishModel->canBeDeleted($id)) {
            
            $_SESSION['error'] = "No se puede eliminar el plato porque está siendo usado en órdenes";
            header('Location: index.php?controller=dish&action=index');
            return;
        }

        if ($this->dishModel->delete($id)) {
            header('Location: index.php?controller=dish&action=index');
        } else {
            $_SESSION['error'] = "Error al eliminar el plato";
            header('Location: index.php?controller=dish&action=index');
        }
    }
} 