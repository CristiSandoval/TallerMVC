<?php
require_once 'models/entities/Category.php';
require_once 'models/drivers/conexDB.php';

use App\models\drivers\ConexDB;
use App\models\entities\Category;

class CategoryController {
    private $categoryModel;

    public function __construct() {
        $database = new ConexDB();
        $db = $database->getConnection();
        $this->categoryModel = new Category($db);
    }

    // Mostrar todas las categorías
    public function index() {
        $categories = $this->categoryModel->getAll();
        $error = isset($_SESSION['error']) ? $_SESSION['error'] : null;
        unset($_SESSION['error']);
        require_once 'views/categories/index.php';
    }

    // Mostrar formulario de creación
    public function create() {
        require_once 'views/categories/create.php';
    }

    // Procesar el formulario de creación
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->categoryModel->setName($_POST['name']);

            if ($this->categoryModel->create()) {
                header('Location: index.php?controller=category&action=index');
            } else {
                $error = "Error al crear la categoría";
                require_once 'views/categories/create.php';
            }
        }
    }

    // Mostrar formulario de edición
    public function edit($id) {
        $category = $this->categoryModel->getById($id);
        if (!$category) {
            header('Location: index.php?controller=category&action=index');
            return;
        }
        require_once 'views/categories/edit.php';
    }

    // Procesar actualización
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->categoryModel->setId($_POST['id']);
            $this->categoryModel->setName($_POST['name']);

            if ($this->categoryModel->update()) {
                header('Location: index.php?controller=category&action=index');
            } else {
                $error = "Error al actualizar la categoría";
                $category = $this->categoryModel->getById($_POST['id']);
                require_once 'views/categories/edit.php';
            }
        }
    }

    // Eliminar categoría
    public function delete($id) {
        if (!$this->categoryModel->canBeDeleted($id)) {
            $_SESSION['error'] = "No se puede eliminar la categoría porque tiene platos asociados";
            header('Location: index.php?controller=category&action=index');
            return;
        }

        if ($this->categoryModel->delete($id)) {
            header('Location: index.php?controller=category&action=index');
        } else {
            $_SESSION['error'] = "Error al eliminar la categoría";
            header('Location: index.php?controller=category&action=index');
        }
    }
} 