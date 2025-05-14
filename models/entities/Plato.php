<?php
namespace App\models\entities;

use App\models\drivers\ConexDB; // Para la conexión a la base de datos

class Plato {

    private $id;
    private $descripcion;
    private $categoria_id;
    private $precio;

    public function __construct($descripcion = '', $categoria_id = null, $precio = 0.0) {
        $this->descripcion = $descripcion;
        $this->categoria_id = $categoria_id;
        $this->precio = $precio;
    }

    // Métodos getter y setter para los atributos
    public function get($attribute) {
        return $this->$attribute;
    }

    public function set($attribute, $value) {
        $this->$attribute = $value;
    }

    // Guardar el plato en la base de datos
    public function guardar() {
        // Establecer la conexión
        $conexion = new ConexDB();
        $conn = $conexion->getConexion();

        // Insertar datos en la base de datos
        $sql = "INSERT INTO platos (descripcion, categoria_id, precio) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);

        // Vincular parámetros y ejecutar
        $stmt->bind_param("sid", $this->descripcion, $this->categoria_id, $this->precio);

        // Ejecutar la consulta y devolver el resultado
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Método para obtener todos los platos (puedes usarlo si necesitas listar platos)
    public function all() {
        $conexion = new ConexDB();
        $conn = $conexion->getConexion();

        $sql = "SELECT * FROM platos";
        $result = $conn->query($sql);
        $platos = [];

        while ($row = $result->fetch_assoc()) {
            $platos[] = $row;
        }

        return $platos;
    }
}
