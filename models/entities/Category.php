<?php
namespace App\models\entities;

use PDO;

class Category {
    private $db;
    private $id;
    private $name;

    public function __construct($db) {
        $this->db = $db;
    }

    
    public function getId() { return $this->id; }
    public function getName() { return $this->name; }
    public function setId($id) { $this->id = $id; }
    public function setName($name) { $this->name = $name; }

    public function getAll() {
        $sql = "SELECT * FROM categories ORDER BY name";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $sql = "SELECT * FROM categories WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create() {
        $sql = "INSERT INTO categories (name) VALUES (?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$this->name]);
    }

    public function update() {
        $sql = "UPDATE categories SET name = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$this->name, $this->id]);
    }

    public function delete($id) {
        $sql = "DELETE FROM categories WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }

    public function canBeDeleted($id) {
        $sql = "SELECT COUNT(*) as count FROM dishes WHERE idCategory = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] == 0;
    }
} 