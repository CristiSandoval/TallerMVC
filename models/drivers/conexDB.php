<?php
namespace App\models\drivers;

use PDO;
use PDOException;

class ConexDB {
    private $host = "localhost";
    private $database = "proyecto_2_db";
    private $username = "root";
    private $password = "";
    private $conn;

    public function __construct() {
        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->database,
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo "Error de conexión: " . $e->getMessage();
        }
    }

    public function getConnection() {
        return $this->conn;
    }

    public function close(){
        $this->conn = null;
    }

    public function exeSQL($sql){
        return $this->conn->query($sql);
    }
}