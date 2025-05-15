<?php
namespace App\models\entities;

use PDO;
use Exception;

class Order {
    private $db;
    private $id;
    private $dateOrder;
    private $total;
    private $idTable;
    private $isCancelled;
    private $orderDetails = [];

    public function __construct($db) {
        $this->db = $db;
    }

    
    public function getId() { return $this->id; }
    public function getDateOrder() { return $this->dateOrder; }
    public function getTotal() { return $this->total; }
    public function getIdTable() { return $this->idTable; }
    public function getIsCancelled() { return $this->isCancelled; }
    public function getOrderDetails() { return $this->orderDetails; }

    public function setId($id) { $this->id = $id; }
    public function setDateOrder($dateOrder) { $this->dateOrder = $dateOrder; }
    public function setTotal($total) { $this->total = $total; }
    public function setIdTable($idTable) { $this->idTable = $idTable; }
    public function setIsCancelled($isCancelled) { $this->isCancelled = $isCancelled; }
    public function setOrderDetails($orderDetails) { $this->orderDetails = $orderDetails; }

    public function create() {
        try {
            $this->db->beginTransaction();

            $sql = "INSERT INTO orders (dateOrder, total, idTable, isCancelled) VALUES (?, ?, ?, ?)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$this->dateOrder, $this->total, $this->idTable, $this->isCancelled]);
            
            $this->id = $this->db->lastInsertId();

            foreach ($this->orderDetails as $detail) {
                $sql = "INSERT INTO order_details (quantity, price, idOrder, idDish) VALUES (?, ?, ?, ?)";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([
                    $detail['quantity'],
                    $detail['price'],
                    $this->id,
                    $detail['idDish']
                ]);
            }

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }

    public function getAll() {
        $sql = "SELECT o.*, t.name as table_name 
                FROM orders o 
                JOIN restaurant_tables t ON o.idTable = t.id 
                ORDER BY o.dateOrder DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $sql = "SELECT o.*, t.name as table_name 
                FROM orders o 
                JOIN restaurant_tables t ON o.idTable = t.id 
                WHERE o.id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        $order = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($order) {
            $sql = "SELECT od.*, d.description as dish_name 
                    FROM order_details od 
                    JOIN dishes d ON od.idDish = d.id 
                    WHERE od.idOrder = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$id]);
            $order['details'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        return $order;
    }

    public function cancel($id) {
        $sql = "UPDATE orders SET isCancelled = 1 WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }

    public function calculateTotal() {
        $total = 0;
        foreach ($this->orderDetails as $detail) {
            $total += $detail['quantity'] * $detail['price'];
        }
        return $total;
    }

    public function getOrderReport($startDate, $endDate) {
        $sql = "SELECT o.*, t.name as table_name 
                FROM orders o 
                JOIN restaurant_tables t ON o.idTable = t.id 
                WHERE o.dateOrder BETWEEN ? AND ?
                AND o.isCancelled = 0
                ORDER BY o.dateOrder DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$startDate, $endDate]);
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $sql = "SELECT SUM(total) as total_revenue
                FROM orders 
                WHERE dateOrder BETWEEN ? AND ?
                AND isCancelled = 0";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$startDate, $endDate]);
        $revenue = $stmt->fetch(PDO::FETCH_ASSOC);

        $sql = "SELECT d.id, d.description, d.price,
                       SUM(od.quantity) as total_sold,
                       c.name as category_name
                FROM order_details od
                JOIN orders o ON od.idOrder = o.id
                JOIN dishes d ON od.idDish = d.id
                JOIN categories c ON d.idCategory = c.id
                WHERE o.dateOrder BETWEEN ? AND ?
                AND o.isCancelled = 0
                GROUP BY d.id, d.description, d.price, c.name
                ORDER BY total_sold DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$startDate, $endDate]);
        $topDishes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return [
            'orders' => $orders,
            'revenue' => $revenue['total_revenue'],
            'topDishes' => $topDishes
        ];
    }

    public function getCancelledOrderReport($startDate, $endDate) {
        $sql = "SELECT o.*, t.name as table_name 
                FROM orders o 
                JOIN restaurant_tables t ON o.idTable = t.id 
                WHERE o.dateOrder BETWEEN ? AND ?
                AND o.isCancelled = 1
                ORDER BY o.dateOrder DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$startDate, $endDate]);
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $sql = "SELECT SUM(total) as total_cancelled
                FROM orders 
                WHERE dateOrder BETWEEN ? AND ?
                AND isCancelled = 1";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$startDate, $endDate]);
        $total = $stmt->fetch(PDO::FETCH_ASSOC);

        return [
            'orders' => $orders,
            'total' => $total['total_cancelled'] ?? 0
        ];
    }

    public function getOrderWithDetails($id) {
        $sql = "SELECT o.*, t.name as table_name 
                FROM orders o 
                JOIN restaurant_tables t ON o.idTable = t.id 
                WHERE o.id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        $order = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($order) {
            $sql = "SELECT od.*, d.description as dish_name, d.price,
                           c.name as category_name
                    FROM order_details od 
                    JOIN dishes d ON od.idDish = d.id 
                    JOIN categories c ON d.idCategory = c.id
                    WHERE od.idOrder = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$id]);
            $order['items'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        return $order;
    }
} 