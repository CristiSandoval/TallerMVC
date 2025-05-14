<?php
namespace App\models\entities;

use PDO;

class Dish {
    private $db;
    private $id;
    private $description;
    private $idCategory;
    private $price;

    public function __construct($db) {
        $this->db = $db;
    }

    // Getters y setters
    public function getId() { return $this->id; }
    public function getDescription() { return $this->description; }
    public function getIdCategory() { return $this->idCategory; }
    public function getPrice() { return $this->price; }

    public function setId($id) { $this->id = $id; }
    public function setDescription($description) { $this->description = $description; }
    public function setIdCategory($idCategory) { $this->idCategory = $idCategory; }
    public function setPrice($price) { 
        if ($price <= 0) {
            throw new \Exception("El precio debe ser mayor que 0");
        }
        $this->price = $price; 
    }

    public function getAll() {
        $sql = "SELECT d.*, c.name as category_name 
                FROM dishes d 
                JOIN categories c ON d.idCategory = c.id 
                ORDER BY d.description";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $sql = "SELECT d.*, c.name as category_name 
                FROM dishes d 
                JOIN categories c ON d.idCategory = c.id 
                WHERE d.id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create() {
        try {
            if ($this->price <= 0) {
                return false;
            }
            $sql = "INSERT INTO dishes (description, idCategory, price) VALUES (?, ?, ?)";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$this->description, $this->idCategory, $this->price]);
        } catch (\Exception $e) {
            return false;
        }
    }

    public function update() {
        try {
            if ($this->price <= 0) {
                return false;
            }
            $sql = "UPDATE dishes SET description = ?, price = ? WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$this->description, $this->price, $this->id]);
        } catch (\Exception $e) {
            return false;
        }
    }

    public function delete($id) {
        $sql = "DELETE FROM dishes WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }

    public function canBeDeleted($id) {
        $sql = "SELECT COUNT(*) as count FROM order_details WHERE idDish = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] == 0;
    }
} 